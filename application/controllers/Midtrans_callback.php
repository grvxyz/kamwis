<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Midtrans_callback extends CI_Controller {

    public function index()
    {
        require_once APPPATH . 'libraries/Midtrans/Midtrans.php';

        \Midtrans\Config::$serverKey = 'SB-Mid-server-S1U1lqPi4DV1MUoLoAF8kMPN';
        \Midtrans\Config::$isProduction = false;

        $notif = new \Midtrans\Notification();

        $order_id = $notif->order_id;
        $transaction_status = $notif->transaction_status;
        $payment_type = $notif->payment_type;
        $transaction_id = $notif->transaction_id;

        $data = [
            'payment_type'   => $payment_type,
            'transaction_id'=> $transaction_id,
            'order_id'       => $order_id,
            'payment_status' => $transaction_status
        ];

        // Jika pembayaran sukses
        if ($transaction_status == 'settlement') {
            $data['status'] = 'Dikonfirmasi';
        }

        $this->load->model('Reservasi_model');
        $this->Reservasi_model->update_by_order_id($order_id, $data);

        echo 'OK';
    }
}
