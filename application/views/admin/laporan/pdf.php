<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Wisata</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @media print {
            body {
                background: white;
            }

            .no-print {
                display: none !important;
            }

            @page {
                size: A4;
                margin: 20mm;
            }
        }
    </style>
</head>

<body class="bg-white text-sm text-gray-800">

<?php
// ============================
// AMBIL KOTA DARI IP
// ============================
function getCityFromIP() {
    $ip = $_SERVER['REMOTE_ADDR'];

    if ($ip === '127.0.0.1' || $ip === '::1') {
        return 'Yogyakarta';
    }

    $json = @file_get_contents("http://ip-api.com/json/$ip");
    if (!$json) {
        return 'Yogyakarta';
    }

    $data = json_decode($json, true);
    return $data['city'] ?? 'Yogyakarta';
}

$kota = getCityFromIP();
?>

<div class="max-w-4xl mx-auto p-6">

    <!-- ================= TOMBOL CETAK ================= -->
    <div class="no-print flex justify-end mb-4">
        <button
            onclick="window.print()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm"
        >
            🖨️ Cetak Laporan
        </button>
    </div>

    <!-- ================= KOP SURAT ================= -->
    <div class="border-b-2 border-gray-800 pb-4 mb-6">
        <div class="flex items-center gap-4">

            <!-- Logo -->
            <img
                src="<?= base_url('uploads/logo/logo kamwis.png'); ?>"
                alt="Logo"
                class="h-16 w-auto"
            >

            <!-- Identitas -->
            <div class="text-center flex-1">
                <h1 class="text-xl font-bold uppercase text-gray-900">
                    Kampung Wisata Kauman
                </h1>

                <p class="text-sm text-gray-700 leading-tight">
                    Gg. KH. Zamhari, Ngupasan, Gondomanan, Yogyakarta
                </p>

                <p class="text-sm text-gray-700">
                    Telp: +62 851 6181 3489 | Email: kamwis.kaumanjogja@gmail.com
                </p>
            </div>

        </div>
    </div>

    <!-- ================= JUDUL LAPORAN ================= -->
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold uppercase">Laporan Wisata</h2>
        <p class="text-gray-600 mt-1">
            Periode:
            <span class="font-semibold">
                <?php
                    if (!empty($bulan)) {
                        $nama_bulan = [
                            1=>'Januari','Februari','Maret','April','Mei','Juni',
                            'Juli','Agustus','September','Oktober','November','Desember'
                        ];
                        echo $nama_bulan[(int)$bulan];
                    } else {
                        echo 'Semua Bulan';
                    }

                    if (!empty($tahun)) {
                        echo ' ' . $tahun;
                    }
                ?>
            </span>
        </p>
    </div>

    <!-- ================= TABEL DATA ================= -->
    <table class="w-full border border-gray-400 text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border border-gray-400 px-3 py-2 text-left">Nama Paket</th>
                <th class="border border-gray-400 px-3 py-2 text-center">Pemesanan</th>
                <th class="border border-gray-400 px-3 py-2 text-right">Pendapatan</th>
            </tr>
        </thead>

        <tbody>
            <?php
                $total_pemesanan  = 0;
                $total_pendapatan = 0;
            ?>

            <?php if (!empty($performa_paket)): ?>
                <?php foreach ($performa_paket as $p): ?>
                    <?php
                        $total_pemesanan  += (int)$p->pemesanan;
                        $total_pendapatan += (int)$p->pendapatan;
                    ?>
                    <tr>
                        <td class="border border-gray-400 px-3 py-2">
                            <?= $p->nama_paket ?>
                        </td>
                        <td class="border border-gray-400 px-3 py-2 text-center">
                            <?= $p->pemesanan ?>
                        </td>
                        <td class="border border-gray-400 px-3 py-2 text-right">
                            Rp <?= number_format($p->pendapatan, 0, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="border border-gray-400 px-3 py-4 text-center text-gray-500">
                        Tidak ada data
                    </td>
                </tr>
            <?php endif ?>
        </tbody>

        <?php if (!empty($performa_paket)): ?>
        <tfoot class="bg-gray-100 font-semibold">
            <tr>
                <td class="border border-gray-400 px-3 py-2 text-left">Total</td>
                <td class="border border-gray-400 px-3 py-2 text-center">
                    <?= $total_pemesanan ?>
                </td>
                <td class="border border-gray-400 px-3 py-2 text-right">
                    Rp <?= number_format($total_pendapatan, 0, ',', '.') ?>
                </td>
            </tr>
        </tfoot>
        <?php endif ?>
    </table>

    <!-- ================= TTD ================= -->
    <div class="mt-12 flex justify-end">
        <div class="text-center">
            <p><?= $kota ?>, <?= date('d F Y') ?></p>
            <p class="mt-16 font-semibold">( ___________________ )</p>
            <p class="text-sm">Pengelola Kampung Wisata Kauman</p>
        </div>
    </div>

</div>

</body>
</html>
