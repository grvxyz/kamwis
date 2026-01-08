<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Review_model');
        $this->load->library('session');
    }

    public function submit()
    {
        // 1. HARUS LOGIN
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }

        $id_paket = $this->input->post('id_paket');
        $rating   = $this->input->post('rating');
        $komentar = $this->input->post('komentar');
        $id_user  = $this->session->userdata('id_user');

        // 2. CEK SUDAH PERNAH PESAN (INI YANG KAMU TANYA)
        $pesanan = $this->Review_model->cek_pernah_pesan($id_paket, $id_user);
        if (!$pesanan) {
            $this->session->set_flashdata(
                'error',
                'Review hanya bisa diberikan setelah memesan paket'
            );
            redirect($_SERVER['HTTP_REFERER']);
        }

        // 3. CEK REVIEW GANDA
        $cek = $this->Review_model->cek_review_user($id_paket, $id_user);
        if ($cek) {
            $this->session->set_flashdata(
                'error',
                'Kamu sudah memberi review untuk paket ini'
            );
            redirect($_SERVER['HTTP_REFERER']);
        }

        // 4. SIMPAN REVIEW
        $data = [
            'id_paket'   => $id_paket,
            'id_user'    => $id_user,
            'rating'     => $rating,
            'komentar'   => $komentar,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->Review_model->insert_review($data);

        // 5. UPDATE RATING PAKET
        $this->Review_model->update_rating_paket($id_paket);

        $this->session->set_flashdata(
            'success',
            'Review berhasil dikirim'
        );

        redirect($_SERVER['HTTP_REFERER']);
    }
}
