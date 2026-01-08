<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Artikel_model');
    }

    /**
     * LIST ARTIKEL
     * Mendukung filter search dan status (publish/draft)
     */
    public function index() {
        // Ambil input GET untuk filter/search
        $q      = $this->input->get('q');       // search judul
        $status = $this->input->get('status');  // filter status: publish/draft/all

        // Ambil artikel sesuai filter
        $data['artikel'] = $this->Artikel_model->get_filtered($q, $status);

        // Simpan keyword & status ke view agar tetap tampil di input
        $data['q']      = $q;
        $data['status'] = $status;

        // Load view
        $this->load->view('partials/header', $data);
        $this->load->view('artikel/index', $data);
        $this->load->view('partials/footer');
    }

    /**
     * DETAIL ARTIKEL
     * Menampilkan detail berdasarkan slug
     */
    public function detail($slug) {

        // Ambil artikel berdasar slug, hanya publish
        $artikel = $this->Artikel_model->get_by_slug($slug);

        if (!$artikel) {
            show_404();
        }

        $data['artikel'] = $artikel;
        $this->load->view('artikel/detail', $data);
        $this->load->view('partials/footer');
    }
}
