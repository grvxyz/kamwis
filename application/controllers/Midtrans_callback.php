<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Midtrans_callback extends CI_Controller {

    public function index()
    {
        // Read raw input and validate
        $input = file_get_contents('php://input');
        // Debug: log raw payload for diagnostics (file + CI log)
        file_put_contents(APPPATH . 'logs/midtrans_payload.log', date('Y-m-d H:i:s') . ' - Raw payload: ' . $input . PHP_EOL, FILE_APPEND);
        if (function_exists('log_message')) { log_message('info', 'Midtrans callback payload: ' . $input); }

        if (empty($input)) {
            // If the request is not a POST, return 405 Method Not Allowed
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo 'Method Not Allowed';
                return;
            }

            http_response_code(400);
            echo 'Empty payload';
            return;
        }

        $raw = json_decode($input, true);
        if (!is_array($raw) || !isset($raw['transaction_id'])) {
            // Log invalid payload so we can inspect what Midtrans / client actually sent
            $err = date('Y-m-d H:i:s') . ' - Invalid payload received: ' . $input . PHP_EOL;
            file_put_contents(APPPATH . 'logs/midtrans_callback.log', $err, FILE_APPEND);
            if (function_exists('log_message')) { log_message('error', 'Midtrans callback invalid payload: ' . $input); }

            http_response_code(400);
            // Echo raw payload back to caller to aid debugging (remove after fixed)
            echo 'Invalid payload: ' . $input;
            return;
        }

        try {
            // Load Midtrans library and config only when we need to contact Midtrans API
            require_once APPPATH . 'libraries/Midtrans/Midtrans.php';

            \Midtrans\Config::$serverKey = 'SB-Mid-server-S1U1lqPi4DV1MUoLoAF8kMPN';
            \Midtrans\Config::$isProduction = false;

            // Log that we will query Midtrans (helps debug outbound issues)
            if (function_exists('log_message')) { log_message('info', 'Midtrans: querying status for transaction_id ' . $raw['transaction_id']); }

            // Query Midtrans for the authoritative transaction status
            $status_response = \Midtrans\Transaction::status($raw['transaction_id']);

            $order_id = isset($status_response->order_id) ? $status_response->order_id : null;
            $transaction_status = isset($status_response->transaction_status) ? $status_response->transaction_status : null;
            $payment_type = isset($status_response->payment_type) ? $status_response->payment_type : null;
            $transaction_id = isset($status_response->transaction_id) ? $status_response->transaction_id : null;

            $data = [
                'payment_type'   => $payment_type,
                'transaction_id' => $transaction_id,
                'order_id'       => $order_id,
                'payment_status' => $transaction_status
            ];

            // Jika pembayaran sukses
            if ($transaction_status == 'settlement') {
                $data['status'] = 'Dikonfirmasi';
            }

            $this->load->model('Reservasi_model');
            $this->Reservasi_model->update_by_order_id($order_id, $data);

            // Success logging
            $success = date('Y-m-d H:i:s') . ' - Midtrans callback success: order_id=' . $order_id . ' status=' . $transaction_status . PHP_EOL;
            @file_put_contents(APPPATH . 'logs/midtrans_callback.log', $success, FILE_APPEND);
            if (function_exists('log_message')) { log_message('info', 'Midtrans callback success: order_id=' . $order_id . ' status=' . $transaction_status); }

            echo 'OK';
        } catch (\Exception $e) {
            // Enhanced error logging (CI log + file)
            $err = date('Y-m-d H:i:s') . ' - Midtrans callback error: ' . $e->getMessage() . ' | payload: ' . $input . PHP_EOL;
            file_put_contents(APPPATH . 'logs/midtrans_callback.log', $err, FILE_APPEND);
            if (function_exists('log_message')) { log_message('error', 'Midtrans callback error: ' . $e->getMessage()); }

            http_response_code(500);
            echo 'Error';
        }
    }
}
