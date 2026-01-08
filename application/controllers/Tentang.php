<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tentang extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = "Tentang Kampung Wisata Kauman";

        // Jika kamu pakai header footer user
        $this->load->view('partials/header', $data);
        $this->load->view('user/tentang_kami', $data);
        $this->load->view('partials/footer', $data);

    }
    
}
