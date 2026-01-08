<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminLaporan_model extends CI_Model {

    /* ================= DEFAULT (INDEX) ================= */

    public function total_pendapatan_bulan_ini() {
        return $this->db
            ->select_sum('total_harga')
            ->where('MONTH(reservasi.created_at)', date('m'))
            ->where('YEAR(reservasi.created_at)', date('Y'))
            ->get('reservasi')
            ->row()
            ->total_harga ?? 0;
    }

    public function total_reservasi_bulan_ini() {
        return $this->db
            ->where('MONTH(reservasi.created_at)', date('m'))
            ->where('YEAR(reservasi.created_at)', date('Y'))
            ->count_all_results('reservasi');
    }

    public function total_peserta_bulan_ini() {
        return $this->db
            ->select_sum('jumlah_peserta')
            ->where('MONTH(reservasi.created_at)', date('m'))
            ->where('YEAR(reservasi.created_at)', date('Y'))
            ->get('reservasi')
            ->row()
            ->jumlah_peserta ?? 0;
    }

    public function status_reservasi() {
        return $this->db
            ->select('status, COUNT(*) as total')
            ->group_by('status')
            ->get('reservasi')
            ->result();
    }

    public function paket_terlaris() {
        return $this->db
            ->select('paket_wisata.nama_paket,
                      COUNT(reservasi.id_reservasi) as total,
                      SUM(reservasi.total_harga) as pendapatan')
            ->join('reservasi','reservasi.id_paket = paket_wisata.id_paket','left')
            ->group_by('paket_wisata.id_paket')
            ->order_by('total','DESC')
            ->limit(3)
            ->get('paket_wisata')
            ->result();
    }

    public function performa_paket() {
        return $this->db
            ->select('paket_wisata.nama_paket,
                      COUNT(reservasi.id_reservasi) as pemesanan,
                      SUM(reservasi.total_harga) as pendapatan')
            ->join('reservasi','reservasi.id_paket = paket_wisata.id_paket','left')
            ->group_by('paket_wisata.id_paket')
            ->get('paket_wisata')
            ->result();
    }

    /* ================= FILTER HELPER ================= */

    private function apply_filter($bulan=null,$tahun=null,$preset=null)
    {
        if ($preset) {
            switch ($preset) {
                case 'today':
                    $this->db->where('DATE(reservasi.created_at)', date('Y-m-d'));
                    break;

                case 'this_month':
                    $this->db->where('MONTH(reservasi.created_at)', date('m'));
                    $this->db->where('YEAR(reservasi.created_at)', date('Y'));
                    break;

                case 'this_year':
                    $this->db->where('YEAR(reservasi.created_at)', date('Y'));
                    break;
            }
        } else {
            if ($bulan) {
                $this->db->where('MONTH(reservasi.created_at)', $bulan);
            }
            if ($tahun) {
                $this->db->where('YEAR(reservasi.created_at)', $tahun);
            }
        }
    }

    /* ================= FILTERED ================= */

    public function total_pendapatan_filter($bulan,$tahun,$preset)
    {
        $this->db->select_sum('total_harga');
        $this->apply_filter($bulan,$tahun,$preset);
        return $this->db->get('reservasi')->row()->total_harga ?? 0;
    }

    public function total_reservasi_filter($bulan,$tahun,$preset)
    {
        $this->apply_filter($bulan,$tahun,$preset);
        return $this->db->count_all_results('reservasi');
    }

    public function total_peserta_filter($bulan,$tahun,$preset)
    {
        $this->db->select_sum('jumlah_peserta');
        $this->apply_filter($bulan,$tahun,$preset);
        return $this->db->get('reservasi')->row()->jumlah_peserta ?? 0;
    }

    public function status_reservasi_filter($bulan,$tahun,$preset)
    {
        $this->db->select('status, COUNT(*) as total');
        $this->apply_filter($bulan,$tahun,$preset);
        return $this->db
            ->group_by('status')
            ->get('reservasi')
            ->result();
    }

    public function paket_terlaris_filter($bulan,$tahun,$preset)
    {
        $this->db->select('paket_wisata.nama_paket,
                          COUNT(reservasi.id_reservasi) as total,
                          SUM(reservasi.total_harga) as pendapatan');
        $this->db->join('reservasi','reservasi.id_paket = paket_wisata.id_paket','left');
        $this->apply_filter($bulan,$tahun,$preset);

        return $this->db
            ->group_by('paket_wisata.id_paket')
            ->order_by('total','DESC')
            ->limit(3)
            ->get('paket_wisata')
            ->result();
    }

    public function performa_paket_filter($bulan,$tahun,$preset)
    {
        $this->db->select('paket_wisata.nama_paket,
                          COUNT(reservasi.id_reservasi) as pemesanan,
                          SUM(reservasi.total_harga) as pendapatan');
        $this->db->join('reservasi','reservasi.id_paket = paket_wisata.id_paket','left');
        $this->apply_filter($bulan,$tahun,$preset);

        return $this->db
            ->group_by('paket_wisata.id_paket')
            ->get('paket_wisata')
            ->result();
    }

    /* ================= GROWTH BULANAN ================= */

public function growth_bulanan($tahun)
{
    $query = $this->db->select("
            MONTH(created_at) as bulan,
            COUNT(id_reservasi) as pemesanan,
            SUM(jumlah_peserta) as peserta
        ")
        ->from('reservasi')
        ->where('YEAR(created_at)', $tahun)
        ->group_by('MONTH(created_at)')
        ->get()
        ->result();

    // Default 12 bulan = 0
    $data = [];
    for ($i = 1; $i <= 12; $i++) {
        $data[$i] = (object)[
            'bulan' => $i,
            'pemesanan' => 0,
            'peserta' => 0
        ];
    }

    // Isi bulan yang ada datanya
    foreach ($query as $row) {
        $data[(int)$row->bulan] = $row;
    }

    return array_values($data);
}

    
}
