<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservasi extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model(['Reservasi_model','Paket_model']);
        $this->load->helper(['url','form']);
        $this->load->library('session');

        // MIDTRANS CONFIG
        require_once APPPATH . 'libraries/Midtrans/Midtrans.php';

        \Midtrans\Config::$serverKey    = 'SB-Mid-server-S1U1lqPi4DV1MUoLoAF8kMPN';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;
    }

    /* =====================
       FORM RESERVASI
    ===================== */
    public function form($id_paket){
        if(!$this->session->userdata('id_user')){
            redirect('auth/login');
        }

        $data['paket'] = $this->Paket_model->get_paket_by_id($id_paket);
        if(!$data['paket']) show_404();

        $this->load->view('user/reservasi/form', $data);
    }

    /* =====================
       SIMPAN RESERVASI + MIDTRANS
    ===================== */
    public function simpan(){

        if(!$this->session->userdata('id_user')){
            redirect('auth/login');
        }

        $id_user  = $this->session->userdata('id_user');
        $id_paket = $this->input->post('id_paket');
        $jumlah   = (int)$this->input->post('jumlah_peserta');

        $paket = $this->Paket_model->get_paket_by_id($id_paket);
        if(!$paket) show_404();

        if($jumlah < 1){
            $this->session->set_flashdata('error','Jumlah peserta minimal 1 orang');
            redirect('user/reservasi/form/'.$id_paket);
        }

        $total = $jumlah * $paket->harga;

        // SIMPAN RESERVASI
        $id_reservasi = $this->Reservasi_model->insert([
            'id_user'           => $id_user,
            'id_paket'          => $id_paket,
            'tanggal_kunjungan' => $this->input->post('tanggal_kunjungan'),
            'jam_kunjungan'     => $this->input->post('jam_kunjungan'),
            'jumlah_peserta'    => $jumlah,
            'total_harga'       => $total,
            'status'            => 'Pending',
            'payment_status'    => 'pending'
        ]);

        // ORDER ID
        $order_id = 'RES-'.$id_reservasi.'-'.time();

        // SIMPAN ORDER ID
        $this->Reservasi_model->update_by_id($id_reservasi, [
            'order_id' => $order_id
        ]);

        // MIDTRANS PARAMS
        $params = [
            'transaction_details' => [
                'order_id'     => $order_id,
                'gross_amount' => $total
            ],
            'item_details' => [
                [
                    'id'       => $paket->id_paket,
                    'price'    => (int)$paket->harga,
                    'quantity' => $jumlah,
                    'name'     => $paket->nama_paket
                ]
            ],
            'customer_details' => [
                'first_name' => $this->session->userdata('nama'),
                'email'      => $this->session->userdata('email')
            ]
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        redirect('user/reservasi/pembayaran/'.$id_reservasi.'?token='.$snapToken);
    }

    /* =====================
       HALAMAN PEMBAYARAN
    ===================== */
    public function pembayaran($id_reservasi){

        if(!$this->session->userdata('id_user')){
            redirect('auth/login');
        }

        $data['reservasi'] = $this->Reservasi_model->get_by_id($id_reservasi);
        if(!$data['reservasi']) show_404();

        $this->load->view('user/reservasi/pembayaran', $data);
    }

    /* =====================
       RIWAYAT
    ===================== */
    public function riwayat(){
        if(!$this->session->userdata('id_user')){
            redirect('auth/login');
        }

        $data['reservasi'] = $this->Reservasi_model
            ->get_by_user($this->session->userdata('id_user'));

        $this->load->view('user/reservasi/riwayat', $data);
    }
}
