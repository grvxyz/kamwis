<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Galeri_model');
        $this->load->library('upload');
              if (
            !$this->session->userdata('logged_in') ||
            $this->session->userdata('role') !== 'admin'
        ) {
            redirect('auth/login');
        }
    }

    public function index(){
        $data['galeri'] = $this->Galeri_model->get_all();
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/galeri/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function ajax_simpan(){
        echo json_encode(
            $this->Galeri_model->simpan($this->input, $_FILES)
        );
    }

    public function ajax_hapus(){
        $this->Galeri_model->delete($this->input->post('id'));
        echo json_encode(['status'=>'success']);
    }
}
