<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reservasi_model');

        // Proteksi admin
        if (
            !$this->session->userdata('logged_in') ||
            $this->session->userdata('role') !== 'admin'
        ) {
            redirect('auth/login');
        }
    }

    /* =====================
       LIST RESERVASI (ADMIN)
    ===================== */
    public function index()
    {
        $data['reservasi'] = $this->Reservasi_model->get_all_admin();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/reservasi/index', $data);
        $this->load->view('admin/layout/footer');
    }

    /* =====================
       DETAIL RESERVASI (AJAX)
       UNTUK MODAL
    ===================== */
    public function detail($id_reservasi)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $data = $this->Reservasi_model->get_by_id($id_reservasi);

        if (!$data) {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
            return;
        }

        echo json_encode([
            'status' => 'success',
            'data'   => $data
        ]);
    }

    /* =====================
       UPDATE STATUS RESERVASI
       (MANUAL ADMIN - TERBATAS)
    ===================== */
    public function update_status()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id     = $this->input->post('id_reservasi');
        $status = $this->input->post('status');

        // Status yang DIIZINKAN admin
        $allowed_status = ['Dikonfirmasi', 'Dibatalkan'];

        if (!in_array($status, $allowed_status)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Status tidak valid'
            ]);
            return;
        }

        $this->Reservasi_model->update_by_id($id, [
            'status' => $status
        ]);

        echo json_encode(['status' => 'success']);
    }

    /* =====================
       BATALKAN RESERVASI
       (SOFT DELETE)
    ===================== */
    public function batalkan()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = $this->input->post('id_reservasi');

        $this->Reservasi_model->cancel($id);

        echo json_encode(['status' => 'success']);
    }
}
