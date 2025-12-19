<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Reservasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#F4F8FB]">

<?php $this->load->view('partials/header'); ?>

<div class="max-w-6xl mx-auto px-4 py-8">

    <!-- ================= JUDUL ================= -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Riwayat Reservasi
        </h1>
        <p class="text-sm text-gray-500">
            Daftar reservasi paket wisata yang pernah Anda buat
        </p>
    </div>

    <!-- ================= FLASH MESSAGE ================= -->
    <?php if ($this->session->flashdata('success')) : ?>
        <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <!-- ================= JIKA DATA KOSONG ================= -->
    <?php if (empty($reservasi)) : ?>
        <div class="rounded-xl bg-white p-6 text-center shadow">
            <p class="text-gray-500">
                Belum ada reservasi.
            </p>

            <a href="<?= site_url('user/paket'); ?>"
               class="mt-4 inline-block rounded-lg bg-gradient-to-r from-blue-600 to-green-500
                      px-6 py-2 text-sm font-semibold text-white">
                Pesan Paket Wisata
            </a>
        </div>

    <?php else : ?>

    <!-- ================= TABEL RIWAYAT ================= -->
    <div class="overflow-x-auto rounded-xl bg-white shadow">
        <table class="w-full text-sm">
            <thead class="bg-gradient-to-r from-blue-600 to-green-500 text-white">
                <tr>
                    <th class="px-4 py-3 text-left">Paket</th>
                    <th class="px-4 py-3 text-center">Tanggal</th>
                    <th class="px-4 py-3 text-center">Jam</th>
                    <th class="px-4 py-3 text-center">Peserta</th>
                    <th class="px-4 py-3 text-center">Total</th>
                    <th class="px-4 py-3 text-center">Status</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($reservasi as $r) : ?>
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-medium text-gray-800">
                        <?= $r->nama_paket ?>
                    </td>

                    <td class="px-4 py-3 text-center">
                        <?= date('d M Y', strtotime($r->tanggal_kunjungan)) ?>
                    </td>

                    <td class="px-4 py-3 text-center">
                        <?= substr($r->jam_kunjungan, 0, 5) ?>
                    </td>

                    <td class="px-4 py-3 text-center">
                        <?= $r->jumlah_peserta ?> org
                    </td>

                    <td class="px-4 py-3 text-center font-semibold text-green-600">
                        Rp <?= number_format($r->total_harga, 0, ',', '.') ?>
                    </td>

                    <td class="px-4 py-3 text-center">
                        <?php
                            $badge = [
                                'Pending'   => 'bg-yellow-100 text-yellow-700',
                                'Disetujui' => 'bg-green-100 text-green-700',
                                'Ditolak'   => 'bg-red-100 text-red-700',
                            ];
                        ?>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold
                                     <?= $badge[$r->status] ?? 'bg-gray-100 text-gray-600' ?>">
                            <?= $r->status ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php endif; ?>

</div>

</body>
</html>
