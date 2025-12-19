<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review_model extends CI_Model {

    protected $table = 'paket_review';

    /* =====================
       AMBIL REVIEW PER PAKET
    ===================== */
    public function get_review_by_paket($id_paket){
        return $this->db
            ->select('paket_review.*, users.nama')
            ->from($this->table)
            ->join('users', 'users.id_user = paket_review.id_user')
            ->where('paket_review.id_paket', $id_paket)
            ->order_by('paket_review.created_at', 'DESC')
            ->get()
            ->result();
    }

    /* =====================
       CEK APAKAH USER SUDAH REVIEW
    ===================== */
    public function cek_review_user($id_paket, $id_user){
        return $this->db
            ->where('id_paket', $id_paket)
            ->where('id_user', $id_user)
            ->get($this->table)
            ->row();
    }

    /* =====================
       SIMPAN REVIEW
    ===================== */
    public function insert_review($data){
        return $this->db->insert($this->table, $data);
    }

    /* =====================
       HITUNG RATA-RATA RATING
    ===================== */
    public function get_avg_rating($id_paket){
        $result = $this->db
            ->select_avg('rating', 'rata_rating')
            ->where('id_paket', $id_paket)
            ->get($this->table)
            ->row();

        return $result ? round($result->rata_rating, 1) : 0;
    }

    /* =====================
       UPDATE RATING KE TABEL PAKET
    ===================== */
    public function update_rating_paket($id_paket){
        $avg = $this->get_avg_rating($id_paket);

        $this->db
            ->where('id_paket', $id_paket)
            ->update('paket_wisata', ['rating' => $avg]);
    }
}
