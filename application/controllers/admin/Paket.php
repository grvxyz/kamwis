<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paket extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Paket_model');
        $this->load->helper(['url','form']);
              if (
            !$this->session->userdata('logged_in') ||
            $this->session->userdata('role') !== 'admin'
        ) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['paket'] = $this->Paket_model->get_all_paket();
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/paket/index', $data);
        $this->load->view('admin/layout/footer');
    }

    public function ajax_simpan() {

        $id = $this->input->post('id_paket');

        $data = [
            'nama_paket' => $this->input->post('nama_paket'),
            'deskripsi'  => $this->input->post('deskripsi'),
            'fasilitas'  => $this->input->post('fasilitas'),
            'harga'      => $this->input->post('harga'),
            'status'     => $this->input->post('status')
        ];

        // UPLOAD FOTO
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path']   = './uploads/paket/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['encrypt_name']  = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $data['foto'] = $this->upload->data('file_name');
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => strip_tags($this->upload->display_errors())
                ]);
                return;
            }
        }

        if ($id) {
            $this->Paket_model->update($id, $data);
        } else {
            $this->Paket_model->insert($data);
        }

        echo json_encode(['status' => 'success']);
    }

    public function ajax_hapus() {
        $this->Paket_model->delete($this->input->post('id_paket'));
        echo json_encode(['status' => 'success']);
    }
}
