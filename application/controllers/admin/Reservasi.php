<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Reservasi_model');
              if (
            !$this->session->userdata('logged_in') ||
            $this->session->userdata('role') !== 'admin'
        ) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['reservasi'] = $this->Reservasi_model->get_all_admin();
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/reservasi/index', $data);
        $this->load->view('admin/layout/footer');
    }

   public function update_status()
{
    $id = $this->input->post('id_reservasi');

    $data = [
        'status' => $this->input->post('status')
    ];

    $this->Reservasi_model->update_by_id($id, $data);

    echo json_encode(['status' => 'success']);
}


    public function hapus()
    {
        $id = $this->input->post('id');
        $this->Reservasi_model->delete($id);

        echo json_encode(['status' => 'success']);
    }
}
