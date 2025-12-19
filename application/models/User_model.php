<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    /* =========================
       CREATE
    ========================== */
    public function insert($data) {
        return $this->db->insert('users', $data);
    }

    /* =========================
       READ
    ========================== */
    public function get_by_email($email) {
        return $this->db
                    ->where('email', $email)
                    ->limit(1)
                    ->get('users')
                    ->row();
    }

    public function get_by_id($id_user) {
        return $this->db
                    ->where('id_user', $id_user)
                    ->limit(1)
                    ->get('users')
                    ->row();
    }

    public function get_all_users() {
        return $this->db
                    ->order_by('id_user', 'DESC')
                    ->get('users')
                    ->result();
    }

    /* =========================
       UPDATE
    ========================== */
    public function update($id_user, $data) {
        return $this->db
                    ->where('id_user', $id_user)
                    ->update('users', $data);
    }

    /* =========================
       DELETE
    ========================== */
    public function delete($id_user) {
        return $this->db
                    ->where('id_user', $id_user)
                    ->delete('users');
    }
}
