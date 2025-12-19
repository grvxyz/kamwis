<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservasi_model extends CI_Model {

    private $table = 'reservasi';

    /* =====================
       INSERT RESERVASI (USER)
       RETURN ID RESERVASI
    ===================== */
    public function insert($data)
    {
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /* =====================
       RIWAYAT RESERVASI USER
    ===================== */
    public function get_by_user($id_user)
    {
        return $this->db
            ->select('r.*, p.nama_paket, p.harga')
            ->from($this->table . ' r')
            ->join('paket_wisata p', 'p.id_paket = r.id_paket')
            ->where('r.id_user', $id_user)
            ->order_by('r.created_at', 'DESC')
            ->get()
            ->result();
    }

    /* =====================
       LIST RESERVASI (ADMIN)
    ===================== */
    public function get_all_admin()
    {
        return $this->db
            ->select('r.*, u.nama AS nama_user, p.nama_paket')
            ->from($this->table . ' r')
            ->join('users u', 'u.id_user = r.id_user')
            ->join('paket_wisata p', 'p.id_paket = r.id_paket')
            ->order_by('r.created_at', 'DESC')
            ->get()
            ->result();
    }

    /* =====================
       DETAIL RESERVASI
    ===================== */
    public function get_by_id($id_reservasi)
    {
        return $this->db
            ->where('id_reservasi', $id_reservasi)
            ->get($this->table)
            ->row();
    }

    /* =====================
       UPDATE DATA RESERVASI
    ===================== */
    public function update_by_id($id_reservasi, $data)
    {
        return $this->db
            ->where('id_reservasi', $id_reservasi)
            ->update($this->table, $data);
    }

    /* =====================
       UPDATE DARI WEBHOOK MIDTRANS
       (PALING BENAR & AMAN)
    ===================== */
    public function update_by_order_id($order_id, $data)
    {
        return $this->db
            ->where('order_id', $order_id)
            ->update($this->table, $data);
    }

    /* =====================
       DETAIL BY ORDER ID
    ===================== */
    public function get_by_order_id($order_id)
    {
        return $this->db
            ->where('order_id', $order_id)
            ->get($this->table)
            ->row();
    }

    /* =====================
       HAPUS RESERVASI
    ===================== */
    public function delete($id_reservasi)
    {
        return $this->db
            ->where('id_reservasi', $id_reservasi)
            ->delete($this->table);
    }
}
