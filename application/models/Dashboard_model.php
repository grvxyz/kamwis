<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    /* ================= HERO SLIDER EVENT ================= */
    public function get_event_slider()
    {
        return $this->db
            ->where('status', 'aktif')
            ->where('tanggal_selesai >=', date('Y-m-d'))
            ->order_by('tanggal_mulai', 'DESC')
            ->limit(5)
            ->get('event')
            ->result();
    }

    /* ================= PAKET WISATA UNGGULAN ================= */
    public function get_paket_unggulan()
    {
        return $this->db
            ->select('pw.*, COUNT(r.id_reservasi) AS total_dipesan')
            ->from('paket_wisata pw')
            ->join('reservasi r', 'r.id_paket = pw.id_paket', 'left')
            ->where('pw.status', 'aktif')
            ->group_by('pw.id_paket')
            ->order_by('total_dipesan', 'DESC')
            ->limit(3)
            ->get()
            ->result();
    }
    public function get_all_paket()
{
    return $this->db
        ->where('status', 'aktif')
        ->order_by('id_paket', 'DESC')
        ->get('paket_wisata')
        ->result();
}


    /* ================= ARTIKEL TERBARU ================= */
    public function get_artikel_terbaru()
    {
        return $this->db
            ->order_by('created_at', 'DESC')
            ->limit(3)
            ->get('artikel')
            ->result();
    }

    /* ================= GALERI FOTO & VIDEO ================= */
    public function get_galeri()
    {
        return $this->db
            ->order_by('id_galeri', 'DESC')
            ->limit(8)
            ->get('galeri')
            ->result();
    }
}
