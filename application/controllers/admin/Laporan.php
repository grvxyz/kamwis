<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth/login');
        }

        $this->load->model('AdminLaporan_model');
    }

    public function index() {

        $data = [
            'total_pendapatan' => $this->AdminLaporan_model->total_pendapatan_bulan_ini(),
            'total_reservasi'  => $this->AdminLaporan_model->total_reservasi_bulan_ini(),
            'total_peserta'    => $this->AdminLaporan_model->total_peserta_bulan_ini(),
            'status_reservasi' => $this->AdminLaporan_model->status_reservasi(),
            'paket_terlaris'   => $this->AdminLaporan_model->paket_terlaris(),
            'performa_paket'   => $this->AdminLaporan_model->performa_paket(),
        ];

        $this->load->view('admin/layout/header');
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/laporan/index', $data);
        $this->load->view('admin/layout/footer');
    }
}
