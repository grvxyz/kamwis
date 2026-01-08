<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rating extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Rating_model');

        // Proteksi admin
        if (!$this->session->userdata('logged_in') ||
            $this->session->userdata('role') != 'admin') {
            redirect('auth/login');
        }
    }

    /**
     * Halaman tabel rating / komentar
     */
    public function index()
    {
        // Untuk load awal (opsional, realtime pakai AJAX)
        $data['ratings'] = [];
        $this->load->view('admin/rating/index', $data);
    }

    /**
     * 🔥 REALTIME AJAX LIST
     */
    public function ajax_list()
{
    $filter = [
        'rating'      => $this->input->get('rating'),
        'nama_paket'  => $this->input->get('nama_paket'),
        'tanggal'     => $this->input->get('tanggal'),
        'order'       => $this->input->get('order'),
    ];

    $data = $this->Rating_model->get_filtered($filter);

    header('Content-Type: application/json');
    echo json_encode($data);
}

    

    /**
     * Hapus komentar / rating
     */
    public function delete($id_review)
    {
        $this->Rating_model->delete($id_review);
        $this->session->set_flashdata('success', 'Rating berhasil dihapus');
        redirect('admin/rating');
    }
}
