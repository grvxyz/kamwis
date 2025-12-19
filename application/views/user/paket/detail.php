<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $paket->nama_paket ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

<?php $this->load->view('partials/header'); ?>

<section class="py-16">
    <div class="mx-auto max-w-4xl px-6">

        <div class="overflow-hidden rounded-xl bg-white shadow">

            <!-- ================= FOTO PAKET ================= -->
            <img
                src="<?= base_url('uploads/paket/' . $paket->foto) ?>"
                alt="<?= $paket->nama_paket ?>"
                class="h-64 w-full object-cover"
            >

            <div class="p-6">

                <!-- ================= NAMA PAKET ================= -->
                <h1 class="text-3xl font-bold text-gray-800">
                    <?= $paket->nama_paket ?>
                </h1>

                <!-- ================= RATING ================= -->
                <p class="mt-2 text-lg text-yellow-500">
                    ⭐ <?= number_format($paket->rating, 1) ?> / 5
                </p>

                <!-- ================= DESKRIPSI ================= -->
                <p class="mt-4 leading-relaxed text-gray-700">
                    <?= nl2br($paket->deskripsi) ?>
                </p>

                <!-- ================= FASILITAS ================= -->
                <?php if (!empty($paket->fasilitas)) : ?>
                    <div class="mt-6">
                        <h3 class="mb-2 text-lg font-semibold text-gray-800">
                            Fasilitas
                        </h3>
                        <ul class="list-inside list-disc space-y-1 text-gray-700">
                            <?php foreach (explode("\n", $paket->fasilitas) as $f) : ?>
                                <?php if (trim($f)) : ?>
                                    <li><?= trim($f) ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- ================= INFO TAMBAHAN ================= -->
                <ul class="mt-4 space-y-1 text-sm text-gray-600">
                    <?php if ($paket->durasi) : ?>
                        <li>⏱ Durasi: <?= $paket->durasi ?> Jam</li>
                    <?php endif; ?>

                    <?php if ($paket->max_orang) : ?>
                        <li>👥 Maksimal Peserta: <?= $paket->max_orang ?> orang</li>
                    <?php endif; ?>

                    <?php if ($paket->kategori) : ?>
                        <li>🏷 Kategori: <?= $paket->kategori ?></li>
                    <?php endif; ?>
                </ul>

                <!-- ================= HARGA ================= -->
                <p class="mt-6 text-2xl font-bold text-[#592300]">
                    Rp <?= number_format($paket->harga, 0, ',', '.') ?>
                </p>

                <!-- ================= TOMBOL PESAN ================= -->
                <a
                    href="<?= site_url('user/reservasi/form/' . $paket->id_paket) ?>"
                    class="mt-6 inline-block rounded-lg bg-[#592300] px-6 py-3 text-white transition hover:opacity-90"
                >
                    Pesan Paket
                </a>

            </div>
        </div>

        <!-- ================= KEMBALI ================= -->
<a
    href="<?= site_url('user/paket') ?>"
    class="mt-6 inline-flex items-center gap-2 rounded-lg
           bg-[#f6eee8] px-4 py-2 text-sm font-semibold
           text-[#592300] hover:bg-[#ecd8c8]
           transition"
>
    ← Kembali ke daftar paket
</a>


    </div>
</section>

</body>
</html>
