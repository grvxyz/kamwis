<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminLaporan_model extends CI_Model {

    public function total_pendapatan_bulan_ini() {
        return $this->db
            ->select_sum('total_harga')
            ->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->get('reservasi')
            ->row()
            ->total_harga ?? 0;
    }

    public function total_reservasi_bulan_ini() {
        return $this->db
            ->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->count_all_results('reservasi');
    }

    public function total_peserta_bulan_ini() {
        return $this->db
            ->select_sum('jumlah_peserta')
            ->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
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
            ->select('paket_wisata.nama_paket, COUNT(reservasi.id_reservasi) as total, SUM(reservasi.total_harga) as pendapatan')
            ->join('reservasi', 'reservasi.id_paket = paket_wisata.id_paket', 'left')
            ->group_by('paket_wisata.id_paket')
            ->order_by('total', 'DESC')
            ->limit(3)
            ->get('paket_wisata')
            ->result();
    }

    public function performa_paket() {
        return $this->db
            ->select('paket_wisata.nama_paket, COUNT(reservasi.id_reservasi) as pemesanan, SUM(reservasi.total_harga) as pendapatan')
            ->join('reservasi', 'reservasi.id_paket = paket_wisata.id_paket', 'left')
            ->group_by('paket_wisata.id_paket')
            ->get('paket_wisata')
            ->result();
    }
}
