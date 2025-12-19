<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('AdminDashboard_model');

        if (
            !$this->session->userdata('logged_in') ||
            $this->session->userdata('role') !== 'admin'
        ) {
            redirect('auth/login');
        }
    }

    public function index() {

        $data = [
            'total_users'     => $this->AdminDashboard_model->count_users(),
            'total_paket'     => $this->AdminDashboard_model->count_paket(),
            'total_artikel'   => $this->AdminDashboard_model->count_artikel(),
            'total_reservasi' => $this->AdminDashboard_model->count_reservasi(),
            'pending'         => $this->AdminDashboard_model->count_pending(),
            'pendapatan'      => $this->AdminDashboard_model->total_pendapatan(),
            'reservasi'       => $this->AdminDashboard_model->latest_reservasi(3)
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/layout/footer');
    }
}