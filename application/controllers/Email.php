<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {

    public function __construct()
    {
        parent::__construct(); // ✅ WAJIB DI ATAS

        // optional: cek login
        if (!$this->session->userdata('email')) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'unauthorized',
                'message' => 'Harus login'
            ]);
            exit;
        }

        $this->load->library('email');
    }

    public function pembayaran_berhasil()
    {
        header('Content-Type: application/json');

        // ===== AMBIL POST =====
        $id_reservasi = $this->input->post('id_reservasi');
        $email        = $this->input->post('email');
        $nama         = $this->input->post('nama');
        $total        = $this->input->post('total');

        // ===== DEBUG (PENTING) =====
        if (!$id_reservasi || !$email || !$nama || !$total) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak lengkap',
                'post' => $_POST,
                'session' => [
                    'email' => $this->session->userdata('email'),
                    'nama'  => $this->session->userdata('nama')
                ]
            ]);
            return;
        }

        // ===== EMAIL =====
        $this->email->from('scenecraft73@gmail.com', 'Kampung Wisata Kauman');
        $this->email->to($email);
        $this->email->subject('Pembayaran Reservasi Berhasil');

        $this->email->message("
            <h3>✅ Pembayaran Berhasil</h3>
            <p>Halo <b>$nama</b>,</p>
            <p>Pembayaran reservasi Anda telah <b>BERHASIL</b>.</p>
            <p>ID Reservasi: <b>$id_reservasi</b></p>
            <p>Total: <b>Rp ".number_format($total,0,',','.')."</b></p>
        ");

        if ($this->email->send()) {
            echo json_encode(['status' => 'ok']);
        } else {
            echo json_encode([
                'status' => 'error',
                'debug' => $this->email->print_debugger()
            ]);
        }
    }
}
