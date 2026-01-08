<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    protected $table = 'users';

    /* =========================
       CREATE
    ========================== */
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /* =========================
       READ
    ========================== */

    // Ambil user berdasarkan email (LOGIN / PROFILE)
    public function get_by_email($email)
    {
        return $this->db
            ->where('email', $email)
            ->limit(1)
            ->get($this->table)
            ->row();
    }

    // Ambil semua user (ADMIN)
    public function get_all_users()
    {
        return $this->db
            ->order_by('created_at', 'DESC')
            ->get($this->table)
            ->result();
    }

    /* =========================
       UPDATE
    ========================== */

    // Update profil USER (TANPA ROLE, STATUS)
    public function update_by_email($email, $data)
{
    // WHITELIST FIELD (PENGAMAN)
    $allowed = [
        'nama',
        'no_hp',
        'password',
        'foto'      
    ];

    $filtered = array_intersect_key($data, array_flip($allowed));

    if (empty($filtered)) {
        return false;
    }

    return $this->db
        ->where('email', $email)
        ->update($this->table, $filtered);
}

    // Update oleh ADMIN (boleh role & status)
    public function admin_update($email, $data)
    {
        return $this->db
            ->where('email', $email)
            ->update($this->table, $data);
    }

    /* =========================
       DELETE (ADMIN)
    ========================== */
    public function delete_by_email($email)
    {
        return $this->db
            ->where('email', $email)
            ->delete($this->table);
    }
    public function upload_foto($field_name = 'foto')
    {
        $config['upload_path']   = './uploads/profile/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048; // 2 MB
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($field_name)) {
            return [
                'status' => false,
                'error'  => $this->upload->display_errors('', '')
            ];
        }

        $upload = $this->upload->data();

        // ================= RESIZE =================
        $config_resize = [
            'image_library'  => 'gd2',
            'source_image'   => $upload['full_path'],
            'maintain_ratio' => TRUE,
            'width'          => 500,
            'height'         => 500,
            'quality'        => '80%'
        ];

        $this->load->library('image_lib', $config_resize);
        $this->image_lib->resize();
        $this->image_lib->clear();

        return [
            'status'   => true,
            'file'     => $upload['file_name']
        ];
    }

    /* =========================
       HAPUS FOTO LAMA
    ========================== */
    public function delete_foto($filename)
    {
        if ($filename && $filename !== 'default.png') {
            $path = './uploads/profile/' . $filename;
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}

