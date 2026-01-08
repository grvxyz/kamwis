<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth/login');
        }

        $this->load->model('AdminLaporan_model');
    }

    public function index()
    {

        $data = [
            'total_pendapatan' => $this->AdminLaporan_model->total_pendapatan_bulan_ini(),
            'total_reservasi' => $this->AdminLaporan_model->total_reservasi_bulan_ini(),
            'total_peserta' => $this->AdminLaporan_model->total_peserta_bulan_ini(),
            'status_reservasi' => $this->AdminLaporan_model->status_reservasi(),
            'paket_terlaris' => $this->AdminLaporan_model->paket_terlaris(),
            'performa_paket' => $this->AdminLaporan_model->performa_paket(),
        ];

        $this->load->view('admin/layout/header');
        $this->load->view('admin/layout/sidebar');
        $this->load->view('admin/laporan/index', $data);
        $this->load->view('admin/layout/footer');
    }
   public function filter()
{
    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);

    $bulan  = $input['bulan'] ?? null;
    $tahun  = $input['tahun'] ?? date('Y');
    $preset = $input['preset'] ?? null;

    /* ================= TOTAL ================= */
    $total_pendapatan = $this->AdminLaporan_model
        ->total_pendapatan_filter($bulan, $tahun, $preset);

    $total_reservasi_now = $this->AdminLaporan_model
        ->total_reservasi_filter($bulan, $tahun, $preset);

    $total_peserta_now = $this->AdminLaporan_model
        ->total_peserta_filter($bulan, $tahun, $preset);

    /* ================= STATUS ================= */
    $status = $this->AdminLaporan_model
        ->status_reservasi_filter($bulan, $tahun, $preset);

    /* ================= PERFORMA ================= */
    $performa = $this->AdminLaporan_model
        ->performa_paket_filter($bulan, $tahun, $preset);

    /* ================= CHART ================= */
    $chart_paket = [
        'labels' => array_column($performa, 'nama_paket'),
        'data'   => array_map(function($p) { return (int)$p->pendapatan; }, $performa)
    ];

    $chart_status = [
        'labels' => array_column($status, 'status'),
        'data'   => array_map(function($s) { return (int)$s->total; }, $status)
    ];

    /* ================= DELTA ================= */
    $prev_bulan = $bulan ? $bulan - 1 : null;
    $prev_tahun = $tahun;

    if ($prev_bulan === 0) {
        $prev_bulan = 12;
        $prev_tahun--;
    }

    $total_reservasi_prev = $this->AdminLaporan_model
        ->total_reservasi_filter($prev_bulan, $prev_tahun, null);

    $total_peserta_prev = $this->AdminLaporan_model
        ->total_peserta_filter($prev_bulan, $prev_tahun, null);

    $delta_reservasi = $total_reservasi_now - $total_reservasi_prev;
    $delta_peserta   = $total_peserta_now - $total_peserta_prev;

    /* ================= TABLE ================= */
    $tabel = '';
    foreach ($performa as $p) {
        $tabel .= "
        <tr class='border-b'>
            <td class='py-2'>{$p->nama_paket}</td>
            <td class='text-center'>{$p->pemesanan}</td>
            <td class='text-right'>
                Rp " . number_format($p->pendapatan, 0, ',', '.') . "
            </td>
        </tr>";
    }

    /* ================= GROWTH BULANAN ================= */
    $growth_raw = $this->AdminLaporan_model->growth_bulanan($tahun);

    $bulan_nama = [
        1=>'Jan','Feb','Mar','Apr','Mei','Jun',
        7=>'Jul','Agu','Sep','Okt','Nov','Des'
    ];

    $growth = [
        'labels'     => [],
        'pemesanan' => [],
        'peserta'   => []
    ];

    foreach ($growth_raw as $g) {
        $growth['labels'][]     = $bulan_nama[$g->bulan];
        $growth['pemesanan'][] = (int)$g->pemesanan;
        $growth['peserta'][]   = (int)$g->peserta;
    }

    /* ================= RESPONSE ================= */
    echo json_encode([
        'total_pendapatan' => number_format($total_pendapatan, 0, ',', '.'),
        'total_reservasi'  => $total_reservasi_now,
        'total_peserta'    => $total_peserta_now,

        'delta_reservasi'  => $delta_reservasi,
        'delta_peserta'    => $delta_peserta,

        'conversion_rate'  => $total_peserta_now
            ? round(($total_reservasi_now / $total_peserta_now) * 100, 1)
            : 0,

        'chart_paket'  => $chart_paket,
        'chart_status' => $chart_status,
        'growth'       => $growth,
        'tabel'        => $tabel
    ]);
}




    public function export_pdf()
    {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $preset = $this->input->get('preset');

        $data = [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'performa_paket' => $this->AdminLaporan_model
                ->performa_paket_filter($bulan, $tahun, $preset),
            'total_pendapatan' => $this->AdminLaporan_model
                ->total_pendapatan_filter($bulan, $tahun, $preset),
        ];

        $this->load->view('admin/laporan/pdf', $data);
    }

    public function export_csv()
    {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $preset = $this->input->get('preset');

        $data = [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'preset' => $preset,
            'laporan' => $this->AdminLaporan_model
                ->performa_paket_filter($bulan, $tahun, $preset),
            'total_pendapatan' => $this->AdminLaporan_model
                ->total_pendapatan_filter($bulan, $tahun, $preset),

        ];

        $this->load->view('admin/laporan/export_csv', $data);
    }

    public function download_csv()
    {
        // Bersihkan buffer
        if (ob_get_length()) {
            ob_end_clean();
        }

        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $preset = $this->input->get('preset');

        $laporan = $this->AdminLaporan_model
            ->performa_paket_filter($bulan, $tahun, $preset);

        // Header CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=laporan-wisata-' . date('Ymd') . '.csv');
        header('Pragma: no-cache');
        header('Expires: 0');

        // BOM agar Excel tidak rusak encoding
        echo "\xEF\xBB\xBF";

        $out = fopen('php://output', 'w');

        // Header kolom
        fputcsv($out, ['Nama Paket', 'Pemesanan', 'Pendapatan'], ';');

        $total_pemesanan = 0;
        $total_pendapatan = 0;

        // Data
        foreach ($laporan as $p) {
            $total_pemesanan += (int) $p->pemesanan;
            $total_pendapatan += (int) $p->pendapatan;

            fputcsv($out, [
                $p->nama_paket,
                $p->pemesanan,
                $p->pendapatan
            ], ';');
        }

        // Baris kosong (opsional, biar rapi)
        fputcsv($out, [], ';');

        // Total
        fputcsv($out, ['TOTAL PEMESANAN', $total_pemesanan, ''], ';');
        fputcsv($out, ['TOTAL PENDAPATAN', '', $total_pendapatan], ';');

        fclose($out);
        exit;
    }




}



