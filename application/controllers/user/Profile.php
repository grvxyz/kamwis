<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');

        // Proteksi login
        if (
            !$this->session->userdata('logged_in') ||
            $this->session->userdata('role') !== 'user'
        ) {
            redirect('auth/login');
        }
    }

    /**
     * Halaman profil user
     */
    public function index()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->User_model->get_by_email($email);

        if (!$data['user']) {
            show_error('User tidak ditemukan');
        }

        $this->load->view('user/profile/index', $data);
    }

    /**
     * Update profil (nama & no_hp)
     */
    public function update_profile()
    {
        $email = $this->session->userdata('email');
        $user  = $this->User_model->get_by_email($email);

        if (!$user) show_error('User tidak ditemukan');

        $data = [
            'nama'  => $this->input->post('nama', true),
            'no_hp' => $this->input->post('no_hp', true)
        ];

        $this->User_model->update_by_email($email, $data);

        $this->session->set_flashdata('success', 'Profil berhasil diperbarui');
        redirect('user/profile');
    }

    /**
     * Update password
     */
    public function update_password()
    {
        $email = $this->session->userdata('email');
        $user  = $this->User_model->get_by_email($email);

        if (!$user) show_error('User tidak ditemukan');

        $password         = $this->input->post('password', false);
        $password_confirm = $this->input->post('password_confirm', false);

        if (empty($password)) {
            $this->session->set_flashdata('error','Password baru wajib diisi');
            redirect('user/profile');
        }

        if (strlen($password) < 6) {
            $this->session->set_flashdata('error','Password minimal 6 karakter');
            redirect('user/profile');
        }

        if ($password !== $password_confirm) {
            $this->session->set_flashdata('error','Password dan konfirmasi password tidak sama');
            redirect('user/profile');
        }

        if (password_verify($password, $user->password)) {
            $this->session->set_flashdata('error','Password baru tidak boleh sama dengan password lama');
            redirect('user/profile');
        }

        // update password
        $this->User_model->update_by_email($email, [
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        $this->session->set_flashdata('success','Password berhasil diubah, silakan login ulang');
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    /**
     * Update foto profil
     */
    public function update_photo()
    {
        $email = $this->session->userdata('email');
        $user  = $this->User_model->get_by_email($email);

        if (!$user) show_error('User tidak ditemukan');

        if (empty($_FILES['foto']['name'])) {
            $this->session->set_flashdata('error','Pilih foto terlebih dahulu');
            redirect('user/profile');
        }

        $config = [
            'upload_path'   => './uploads/profile/',
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 2048,
            'file_name'     => 'user_' . time(),
        ];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto')) {
            $this->session->set_flashdata('error',$this->upload->display_errors());
            redirect('user/profile');
        }

        $upload = $this->upload->data();

        // hapus foto lama
        if ($user->foto && $user->foto !== 'default.png') {
            @unlink('./uploads/profile/'.$user->foto);
        }

        // update database
        $this->User_model->update_by_email($email, [
            'foto' => $upload['file_name']
        ]);

        $this->session->set_flashdata('success','Foto profil berhasil diperbarui');
        redirect('user/profile');
    }

}
