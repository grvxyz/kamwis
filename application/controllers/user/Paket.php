<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paket extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Paket_model');
        $this->load->model('Review_model');
        $this->load->helper(['url','form']);
        $this->load->library('session');
    }

    /* =====================
       LIST PAKET WISATA
    ===================== */
    public function index(){
        $data['paket'] = $this->Paket_model->get_all_paket();
        $this->load->view('user/paket/index', $data);
    }

    /* =====================
       DETAIL PAKET + REVIEW
    ===================== */
  public function detail($id_paket)
{
    $data['paket'] = $this->Paket_model->get_paket_by_id($id_paket);
    if (!$data['paket']) {
        show_404();
    }

    $id_user = $this->session->userdata('id_user');

    // REVIEW & RATING
    $data['reviews'] = $this->Review_model->get_review_by_paket($id_paket);
    $data['rating']  = $this->Review_model->get_avg_rating($id_paket);

    // ✅ DEFAULT: BELUM PERNAH PESAN
    $data['pernah_pesan'] = false;

    // ✅ CEK JIKA USER LOGIN
    if ($id_user) {
        $data['pernah_pesan'] = $this->Review_model
            ->cek_pernah_pesan($id_paket, $id_user);
    }

    $this->load->view('user/paket/detail', $data);
}


    /* =====================
       SIMPAN REVIEW PAKET
    ===================== */
    public function simpan_review(){

        if(!$this->session->userdata('id_user')){
            redirect('auth/login');
        }

        $id_paket = $this->input->post('id_paket');
        $id_user  = $this->session->userdata('id_user');

        // CEK REVIEW GANDA
        $cek = $this->Review_model->cek_review_user($id_paket, $id_user);
        if($cek){
            $this->session->set_flashdata('error','Anda sudah memberi review');
            redirect('user/paket/detail/'.$id_paket);
        }

        $data = [
            'id_paket'   => $id_paket,
            'id_user'    => $id_user,
            'rating'     => $this->input->post('rating'),
            'komentar'     => $this->input->post('komentar'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->Review_model->insert_review($data);
        $this->Review_model->update_rating_paket($id_paket);

        $this->session->set_flashdata('success','Review berhasil dikirim');
        redirect('user/paket/detail/'.$id_paket);
    }
}
