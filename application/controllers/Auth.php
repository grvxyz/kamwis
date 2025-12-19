<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
    }

    /* ===========================
       REGISTER
    ============================ */

    public function register() {
        $this->load->view('auth/register');
    }

    public function register_process() {

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 
            'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password2', 'Konfirmasi Password', 
            'required|matches[password]');
            $this->form_validation->set_rules(
    'no_hp',
    'No HP',
    'required|trim|numeric|min_length[10]|max_length[15]'
);


        if ($this->form_validation->run() == FALSE) {
            $this->register();
            return;
        }

        $data = [
    'nama'     => $this->input->post('nama', TRUE),
    'email'    => $this->input->post('email', TRUE),
    'no_hp'    => $this->input->post('no_hp', TRUE),
    'password' => password_hash(
        $this->input->post('password'),
        PASSWORD_DEFAULT
    ),
    'role'     => 'user',
    'status'   => 'aktif'
];


        $this->User_model->insert($data);

        $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
        redirect('auth/login');
    }

    /* ===========================
       LOGIN
    ============================ */

    public function login() {

        if ($this->session->userdata('logged_in')) {
            if ($this->session->userdata('role') == 'admin') {
                redirect('admin/dashboard');
            } else {
                redirect('user/dashboard');
            }
        }

        $this->load->view('auth/login');
    }   

    public function login_process() {

        $email    = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->User_model->get_by_email($email);

        if (!$user) {
            $this->session->set_flashdata('error', 'Email tidak ditemukan!');
            redirect('auth/login');
        }

        if ($user->status != 'aktif') {
            $this->session->set_flashdata('error', 'Akun anda nonaktif.');
            redirect('auth/login');
        }

        if (!password_verify($password, $user->password)) {
            $this->session->set_flashdata('error', 'Password salah!');
            redirect('auth/login');
        }

        $userdata = [
            'id_user'   => $user->id_user,
            'nama'      => $user->nama,
            'email'     => $user->email,
            'role'      => $user->role,
            'logged_in' => TRUE
        ];

        $this->session->set_userdata($userdata);

        if ($user->role == 'admin') {

    $this->session->set_flashdata(
        'success',
        'Selamat datang, ' . $user->nama . ' 👋<br>di panel admin Kampung Wisata Kauman'
    );

    redirect('admin/dashboard');

} else {

    $this->session->set_flashdata(
        'success',
        'Selamat datang, ' . $user->nama . ' 👋'
    );

    redirect('user/dashboard');
}
    }

    /* ===========================
       LOGOUT
    ============================ */

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

}
