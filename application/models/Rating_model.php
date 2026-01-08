<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rating_model extends CI_Model {

    private $table = 'paket_review';

    public function get_all()
    {
        $this->db->select('
            r.id_review,
            r.id_paket,
            p.nama_paket,
            r.id_user,
            r.rating,
            r.komentar,
            r.created_at
        ');
        $this->db->from('paket_review r');

        // ✅ JOIN SESUAI kampung.sql
        $this->db->join(
            'paket_wisata p',
            'p.id_paket = r.id_paket',
            'left'
        );

        $this->db->order_by('r.created_at', 'DESC');
        return $this->db->get()->result();
    }

   public function get_filtered($filter = [])
{
    $this->db->select('
        r.id_review,
        r.id_paket,
        p.nama_paket,
        r.id_user,
        r.rating,
        r.komentar,
        r.created_at
    ');
    $this->db->from('paket_review r');
    $this->db->join('paket_wisata p', 'p.id_paket = r.id_paket', 'left');

    if (!empty($filter['rating'])) {
        $this->db->where('r.rating', $filter['rating']);
    }

    if (!empty($filter['nama_paket'])) {
        $this->db->like('p.nama_paket', $filter['nama_paket']);
    }

    if (!empty($filter['tanggal'])) {
        $this->db->where('DATE(r.created_at)', $filter['tanggal']);
    }

    // 🔥 ORDERING
    if (!empty($filter['order']) && $filter['order'] === 'oldest') {
        $this->db->order_by('r.created_at', 'ASC');
    } else {
        $this->db->order_by('r.created_at', 'DESC'); // default terbaru
    }

    return $this->db->get()->result();
}


    public function delete($id_review)
    {
        return $this->db->delete($this->table, [
            'id_review' => $id_review
        ]);
    }
    
}
