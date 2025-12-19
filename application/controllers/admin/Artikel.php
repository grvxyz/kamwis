<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Artikel_model');
        $this->load->library(['upload','image_lib']);
        $this->load->helper(['url','text']);
              if (
            !$this->session->userdata('logged_in') ||
            $this->session->userdata('role') !== 'admin'
        ) {
            redirect('auth/login');
        }
    }

    /* ===================== LIST ===================== */
    public function index(){
        $data['artikel'] = $this->Artikel_model->get_all();
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/artikel/index', $data);
        $this->load->view('admin/layout/footer');
    }

    /* ===================== AJAX SIMPAN ===================== */
    public function ajax_simpan(){

        $id = $this->input->post('id_artikel');

        /* ===== AUTO SLUG (SEO URL) ===== */
        $slug = url_title(
            $this->input->post('judul'),
            'dash',
            TRUE
        );

        $data = [
            'judul'            => $this->input->post('judul'),
            'slug'             => $slug,
            'isi'              => $this->input->post('isi'),
            'meta_title'       => $this->input->post('meta_title'),
            'meta_description' => $this->input->post('meta_description'),
            'status'           => $this->input->post('status'),
            'id_admin'         => 1, // ganti session nanti
            'created_at'       => date('Y-m-d H:i:s')
        ];

        /* ===================== UPLOAD + AUTO RESIZE ===================== */
        if (!empty($_FILES['foto']['name'])) {

            $config['upload_path']   = './uploads/artikel/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name']     = 'artikel_' . time();
            $config['max_size']      = 2048;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto')) {

                $img = $this->upload->data();

                /* === AUTO RESIZE (SEO IMAGE 1200x630) === */
                $resize = [
                    'image_library'  => 'gd2',
                    'source_image'   => $img['full_path'],
                    'maintain_ratio' => TRUE,
                    'width'          => 1200,
                    'height'         => 630
                ];

                $this->image_lib->initialize($resize);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $data['foto'] = $img['file_name'];

            } else {
                echo json_encode([
                    'status'  => 'error',
                    'message' => $this->upload->display_errors()
                ]);
                return;
            }
        }

        /* ===================== INSERT / UPDATE ===================== */
        if ($id) {
            $this->Artikel_model->update($id, $data);
        } else {
            $this->Artikel_model->insert($data);
        }

        echo json_encode(['status' => 'success']);
    }

    /* ===================== AJAX HAPUS ===================== */
    public function ajax_hapus(){
        $id = $this->input->post('id');
        $this->Artikel_model->delete($id);
        echo json_encode(['status'=>'success']);
    }
}
