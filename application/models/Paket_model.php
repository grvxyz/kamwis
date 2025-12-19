<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paket_model extends CI_Model {

    protected $table = 'paket_wisata';

    /* =====================
       AMBIL SEMUA PAKET (USER)
    ===================== */
    public function get_all_paket(){
        return $this->db
            ->where('status', 'aktif')
            ->order_by('created_at', 'DESC')
            ->get($this->table)
            ->result();
    }

    /* =====================
       AMBIL PAKET BERDASARKAN ID
    ===================== */
    public function get_paket_by_id($id_paket){
        return $this->db
            ->where('id_paket', $id_paket)
            ->where('status', 'aktif')
            ->get($this->table)
            ->row();
    }

    /* =====================
       INSERT PAKET (ADMIN)
    ===================== */
    public function insert($data){
        return $this->db->insert($this->table, $data);
    }

    /* =====================
       UPDATE PAKET
    ===================== */
    public function update($id_paket, $data){
        return $this->db
            ->where('id_paket', $id_paket)
            ->update($this->table, $data);
    }

    /* =====================
       DELETE PAKET
    ===================== */
    public function delete($id_paket){
        return $this->db
            ->where('id_paket', $id_paket)
            ->delete($this->table);
    }

    /* =====================
       UPDATE RATING PAKET
    ===================== */
    public function update_rating($id_paket, $rating){
        return $this->db
            ->where('id_paket', $id_paket)
            ->update($this->table, ['rating' => $rating]);
    }
}
