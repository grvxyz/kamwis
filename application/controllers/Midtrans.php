<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Midtrans extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('Reservasi_model');

        require_once APPPATH . 'libraries/Midtrans/Midtrans.php';
        \Midtrans\Config::$serverKey = 'SB-Mid-server-S1U1lqPi4DV1MUoLoAF8kMPN';
        \Midtrans\Config::$isProduction = false;
    }

    /* =====================
       WEBHOOK / CALLBACK
    ===================== */
    public function callback()
{
    $json = file_get_contents("php://input");
    $notification = json_decode($json);

    if (!$notification) {
        show_error('Invalid payload', 400);
    }

    $order_id = $notification->order_id;
    $status   = $notification->transaction_status;
    $fraud    = $notification->fraud_status;

    if ($status == 'settlement' || $status == 'capture') {
        if ($fraud == 'accept') {
            $this->Reservasi_model->update_by_order_id($order_id, [
                'status' => 'Paid'
            ]);
        }
    }
    elseif ($status == 'pending') {
        $this->Reservasi_model->update_by_order_id($order_id, [
            'status' => 'Pending'
        ]);
    }
    elseif (in_array($status, ['deny', 'expire', 'cancel'])) {
        $this->Reservasi_model->update_by_order_id($order_id, [
            'status' => 'Cancel'
        ]);
    }

    http_response_code(200);
}

}
