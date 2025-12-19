<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Cek login user
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
{
    $data['title'] = 'Pesanan Saya';

    $data['pesanan'] = $this->db
        ->select('
            reservasi.id_reservasi AS id_pesanan,
            reservasi.order_id AS kode_booking,
            reservasi.tanggal_kunjungan AS tanggal,
            reservasi.total_harga AS total,
            reservasi.status,
            paket_wisata.nama_paket
        ')
        ->from('reservasi')
        ->join('paket_wisata', 'paket_wisata.id_paket = reservasi.id_paket')
        ->where('reservasi.id_user', $this->session->userdata('id_user'))
        ->order_by('reservasi.id_reservasi', 'DESC')
        ->get()
        ->result();

    $this->load->view('user/pesanan/index', $data);
}


}
