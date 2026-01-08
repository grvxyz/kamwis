<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preview Export CSV</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">

<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">

    <!-- Title -->
    <h1 class="text-2xl font-bold mb-1">Preview Laporan CSV</h1>

    <!-- Periode -->
    <p class="text-sm text-gray-500 mb-6">
        Periode:
        <span class="font-semibold">
            <?php
                $nama_bulan = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                    4 => 'April',   5 => 'Mei',      6 => 'Juni',
                    7 => 'Juli',    8 => 'Agustus',  9 => 'September',
                    10 => 'Oktober',11 => 'November',12 => 'Desember'
                ];

                echo !empty($bulan)
                    ? $nama_bulan[(int)$bulan]
                    : 'Semua Bulan';

                if (!empty($tahun)) {
                    echo ' ' . $tahun;
                }
            ?>
        </span>
    </p>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-left">Nama Paket</th>
                    <th class="border px-3 py-2 text-center">Pemesanan</th>
                    <th class="border px-3 py-2 text-right">Pendapatan</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($laporan)): ?>
                    <?php
                        $total_pemesanan  = 0;
                        $total_pendapatan = 0;
                    ?>
                    <?php foreach ($laporan as $p): ?>
                        <?php
                            $total_pemesanan  += (int) $p->pemesanan;
                            $total_pendapatan += (int) $p->pendapatan;
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2"><?= $p->nama_paket ?></td>
                            <td class="border px-3 py-2 text-center"><?= $p->pemesanan ?></td>
                            <td class="border px-3 py-2 text-right">
                                Rp <?= number_format($p->pendapatan, 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="border px-3 py-4 text-center text-gray-500">
                            Tidak ada data
                        </td>
                    </tr>
                <?php endif ?>
            </tbody>

            <?php if (!empty($laporan)): ?>
            <tfoot class="bg-gray-100 font-semibold">
                <tr>
                    <td class="border px-3 py-2 text-left">Total Pemesanan</td>
                    <td class="border px-3 py-2 text-center"><?= $total_pemesanan ?></td>
                    <td class="border px-3 py-2"></td>
                </tr>
                <tr>
                    <td colspan="2" class="border px-3 py-2 text-left">Total Pendapatan</td>
                    <td class="border px-3 py-2 text-right">
                        Rp <?= number_format($total_pendapatan, 0, ',', '.') ?>
                    </td>
                </tr>
            </tfoot>
            <?php endif ?>
        </table>
    </div>

    <!-- Actions -->
    <div class="flex justify-between mt-6">
        <a href="<?= site_url('admin/laporan') ?>"
           class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition">
            Kembali
        </a>

        <a href="<?= site_url(
            'admin/laporan/download_csv?bulan=' . ($bulan ?? '') .
            '&tahun=' . ($tahun ?? '') .
            '&preset=' . ($preset ?? '')
        ) ?>"
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            Download CSV
        </a>
    </div>

</div>

</body>
</html>
