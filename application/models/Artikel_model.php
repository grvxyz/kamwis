<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel_model extends CI_Model {

    private $table = 'artikel';

    /* ===================== GET ===================== */

    public function get_all() {
        return $this->db
            ->order_by('created_at', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function get_publish() {
        return $this->db
            ->where('status', 'publish')
            ->order_by('created_at', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function get_by_id($id) {
        return $this->db
            ->where('id_artikel', $id)
            ->get($this->table)
            ->row();
    }

    public function get_by_slug($slug) {
        return $this->db
            ->where('slug', $slug)
            ->where('status', 'publish')
            ->get($this->table)
            ->row();
    }

    /* ===================== INSERT ===================== */

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    /* ===================== UPDATE ===================== */

    public function update($id, $data) {
        return $this->db
            ->where('id_artikel', $id)
            ->update($this->table, $data);
    }

    /* ===================== DELETE ===================== */

    public function delete($id) {
        $artikel = $this->get_by_id($id);

        // hapus foto jika ada
        if ($artikel && !empty($artikel->foto)) {
            $path = FCPATH . 'uploads/artikel/' . $artikel->foto;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        return $this->db
            ->where('id_artikel', $id)
            ->delete($this->table);
    }
    
}
