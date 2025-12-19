<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminDashboard_model extends CI_Model {

    /* =====================
       COUNTING
    ===================== */
    public function count_users() {
        return $this->db->count_all('users');
    }

    public function count_paket() {
        return $this->db->count_all('paket_wisata');
    }

    public function count_artikel() {
        return $this->db->count_all('artikel');
    }

    public function count_reservasi() {
        return $this->db->count_all('reservasi');
    }

    public function count_pending() {
        return $this->db
            ->where('status', 'Pending')
            ->count_all_results('reservasi');
    }

    /* =====================
       TOTAL PENDAPATAN
    ===================== */
    public function total_pendapatan() {
        return $this->db
            ->select_sum('total_harga')
            ->where('status', 'Selesai')
            ->get('reservasi')
            ->row()
            ->total_harga ?? 0;
    }

    /* =====================
       RESERVASI TERBARU (ADMIN)
    ===================== */
    public function latest_reservasi($limit = 3) {
        return $this->db
            ->select('r.*, u.nama AS nama_user, p.nama_paket')
            ->from('reservasi r')
            ->join('users u', 'u.id_user = r.id_user')
            ->join('paket_wisata p', 'p.id_paket = r.id_paket')
            ->order_by('r.created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }
}