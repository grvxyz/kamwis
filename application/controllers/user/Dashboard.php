<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();

        if(!$this->session->userdata('id_user')){
            redirect('auth/login');
        }

        $this->load->model('Dashboard_model');
    }

    public function index()
{
    $data = [
        'event_slider'   => $this->Dashboard_model->get_event_slider(),
        'paket_unggulan' => $this->Dashboard_model->get_paket_unggulan(),
        'artikel'        => $this->Dashboard_model->get_artikel_terbaru(),
        'paket_wisata'   => $this->Dashboard_model->get_all_paket(),
        'galeri'         => $this->Dashboard_model->get_galeri() // 🔥 FIX

    ];

    $this->load->view('user/dashboard/index', $data);
}

}
