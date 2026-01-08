<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Artikel_model');
		$this->load->model('Paket_model');
		$this->load->model('Dashboard_model');
	}
    public function index()
    {
        $data = [
            'event_slider'   => $this->Dashboard_model->get_event_slider(),
            'paket_unggulan' => $this->Dashboard_model->get_paket_unggulan(),
            'artikel'        => $this->Dashboard_model->get_artikel_terbaru(),
            'paket_wisata'   => $this->Dashboard_model->get_all_paket(),
            'galeri'         => $this->Dashboard_model->get_galeri()
        ];

        $this->load->view('welcome_message', $data);
        $this->load->view('partials/footer');
    }
	

    public function artikel()
    {
        // Ambil filter GET
        $q      = $this->input->get('q');
        $status = $this->input->get('status');

        // Ambil data dari model
        $data['artikel'] = $this->Artikel_model->get_filtered($q, $status);
        $data['q']       = $q;
        $data['status']  = $status;

        // Load view lengkap
        $this->load->view('partials/header-awal', $data);
        $this->load->view('artikel/index', $data);
        $this->load->view('partials/footer');
    }

    public function detail_artikel($slug)
    {
        $artikel = $this->Artikel_model->get_by_slug($slug);

        if (!$artikel) {
            show_404();
        }

        $data['artikel'] = $artikel;
        $this->load->view('partials/header-awal', $data);
        $this->load->view('artikel/detail', $data);
        $this->load->view('partials/footer');
    }

    public function tentang_kami()
    {
        $this->load->view('tentang_kami');
    }

    public function paket_wisata()
    {
        $data['title'] = 'Paket Wisata';
        $data['paket'] = $this->Paket_model->get_all_paket();

        $this->load->view('paket_wisata', $data);
        $this->load->view('partials/footer');
    }
}
