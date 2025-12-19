<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('User_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper('url');

        // 🔐 PROTEKSI ADMIN
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        if ($this->session->userdata('role') !== 'admin') {
            show_error('Akses ditolak', 403);
        }
    }

    /* ======================
       HALAMAN LIST USER
    ====================== */
    public function index() {
        $data['users'] = $this->User_model->get_all_users();
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/user/index', $data);
        $this->load->view('admin/layout/footer');
    }

    /* ======================
       AJAX SIMPAN (ADD & EDIT)
    ====================== */
    public function ajax_simpan() {

        $id = $this->input->post('id_user');

        // VALIDASI
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => 'error',
                'message' => validation_errors()
            ]);
            return;
        }

        $data = [
            'nama'   => $this->input->post('nama', TRUE),
            'email'  => $this->input->post('email', TRUE),
            'role'   => $this->input->post('role', TRUE),
            'status' => $this->input->post('status', TRUE)
        ];

        // EDIT
        if ($id) {
            $this->User_model->update($id, $data);
        }
        // TAMBAH
        else {
            $data['password'] = password_hash('123456', PASSWORD_DEFAULT);
            $this->User_model->insert($data);
        }

        echo json_encode(['status' => 'success']);
    }

    /* ======================
       AJAX HAPUS
    ====================== */
    public function ajax_hapus() {
        $id = $this->input->post('id_user');

        if (!$id) {
            echo json_encode(['status' => 'error']);
            return;
        }

        $this->User_model->delete($id);
        echo json_encode(['status' => 'success']);
    }
}
