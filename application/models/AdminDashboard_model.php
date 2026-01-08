<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminDashboard_model extends CI_Model
{

    /* =====================
       COUNTING
    ===================== */

    public function count_users()
    {
        return (int) $this->db->count_all('users');
    }

    public function count_paket()
    {
        return (int) $this->db->count_all('paket_wisata');
    }

    public function count_artikel()
    {
        return (int) $this->db->count_all('artikel');
    }

    public function count_reservasi()
    {
        return (int) $this->db->count_all('reservasi');
    }

    public function count_pending()
    {
        return (int) $this->db
            ->where('status', 'Pending')
            ->count_all_results('reservasi');
    }

    /* =====================
       TOTAL PENDAPATAN
    ===================== */

    public function total_pendapatan()
    {
        $row = $this->db
            ->select_sum('total_harga', 'total')
            ->where('status', 'Selesai')
            ->get('reservasi')
            ->row();

        return (int) ($row->total ?? 0);
    }

    /* =====================
       RESERVASI TERBARU
    ===================== */

    public function latest_reservasi($limit = 3)
    {
        return $this->db
            ->select([
                'r.id_reservasi',
                'r.total_harga',
                'r.status',
                'r.tanggal_kunjungan',
                'r.jumlah_peserta',
                'u.nama AS nama_user',
                'p.nama_paket'
            ])
            ->from('reservasi r')
            ->join('users u', 'u.id_user = r.id_user', 'left')
            ->join('paket_wisata p', 'p.id_paket = r.id_paket', 'left')
            ->order_by('r.created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }
}
