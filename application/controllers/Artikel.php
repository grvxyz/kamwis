<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Artikel_model');
    }

    // LIST ARTIKEL
    public function index() {
        $data['artikel'] = $this->Artikel_model->get_publish();
        $this->load->view('partials/header', $data);
        $this->load->view('artikel/index', $data);
    }

    // DETAIL ARTIKEL
    public function detail($slug) {

        $artikel = $this->Artikel_model->get_by_slug($slug);

        if(!$artikel){
            show_404();
        }

        $data['artikel'] = $artikel;
        $this->load->view('artikel/detail', $data);
    }
}
            