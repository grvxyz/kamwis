<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservasi_model extends CI_Model {

    protected $table = 'reservasi';

    /* =====================
       INSERT RESERVASI (USER)
       RETURN ID RESERVASI
    ===================== */
    public function insert($data)
    {
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        if (!isset($data['status'])) {
            $data['status'] = 'Pending';
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
            ->select('
                r.*,
                p.nama_paket,
                p.harga,
                p.rating
            ')
            ->from($this->table . ' r')
            ->join('paket_wisata p', 'p.id_paket = r.id_paket')
            ->where('r.id_user', $id_user)
            ->order_by('r.created_at', 'DESC')
            ->get()
            ->result();
    }
    public function get_by_user_and_status($id_user, $status)
{
    return $this->db
        ->select('r.*, p.nama_paket')
        ->from($this->table . ' r')
        ->join('paket_wisata p', 'p.id_paket = r.id_paket')
        ->where('r.id_user', $id_user)
        ->where('r.payment_status', $status)
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
            ->select('
                r.*,
                u.nama AS nama_user,
                p.nama_paket
            ')
            ->from($this->table . ' r')
            ->join('users u', 'u.id_user = r.id_user')
            ->join('paket_wisata p', 'p.id_paket = r.id_paket')
            ->order_by('r.created_at', 'DESC')
            ->get()
            ->result();
    }

    /* =====================
       DETAIL RESERVASI (ADMIN / MODAL)
    ===================== */
    public function get_by_id($id_reservasi)
    {
        return $this->db
            ->select('
                r.*,
                u.nama AS nama_user,
                u.email,
                p.nama_paket,
                p.harga
            ')
            ->from($this->table . ' r')
            ->join('users u', 'u.id_user = r.id_user')
            ->join('paket_wisata p', 'p.id_paket = r.id_paket')
            ->where('r.id_reservasi', $id_reservasi)
            ->get()
            ->row();
    }

    /* =====================
       UPDATE RESERVASI BY ID
    ===================== */
    public function update_by_id($id_reservasi, $data)
    {
        return $this->db
            ->where('id_reservasi', $id_reservasi)
            ->update($this->table, $data);
    }

    /* =====================
       UPDATE DARI WEBHOOK MIDTRANS
       (PALING AMAN)
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
       SET RESERVASI SELESAI
       (SETELAH SETTLEMENT)
    ===================== */
    public function set_selesai($order_id)
    {
        return $this->db
            ->where('order_id', $order_id)
            ->update($this->table, [
                'status'         => 'Selesai',
                'payment_status' => 'settlement'
            ]);
    }

    /* =====================
       BATALKAN RESERVASI
       (SOFT CANCEL)
    ===================== */
    public function cancel($id_reservasi)
    {
        return $this->db
            ->where('id_reservasi', $id_reservasi)
            ->update($this->table, [
                'status' => 'Dibatalkan'
            ]);
    }

    /* =====================
       AUTO EXPIRE (CRON)
       Pending > 24 jam
    ===================== */
    public function auto_expire()
    {
        return $this->db
            ->where('status', 'Pending')
            ->where('created_at <', date('Y-m-d H:i:s', strtotime('-24 hours')))
            ->update($this->table, [
                'status' => 'Dibatalkan'
            ]);
    }

    /* =====================
       CEK USER PERNAH SELESAI
       (UNTUK REVIEW)
    ===================== */
    public function cek_user_selesai($id_paket, $id_user)
    {
        return $this->db
            ->where('id_paket', $id_paket)
            ->where('id_user', $id_user)
            ->where('status', 'Selesai')
            ->where('payment_status', 'settlement')
            ->get($this->table) 
            ->row();
    }
}
