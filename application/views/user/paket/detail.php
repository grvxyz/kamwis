<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= $paket->nama_paket ?></title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .star {
            font-size: 28px;
            cursor: pointer;
            color: #e5e7eb;
        }

        .star.active {
            color: #facc15;
        }
    </style>
</head>

<body class="bg-gray-50">

    <?php $this->load->view('partials/header'); ?>

    <section class="py-16">
        <div class="mx-auto max-w-4xl px-6">

            <!-- FLASH MESSAGE -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="mb-4 rounded bg-red-100 p-3 text-red-700 text-sm">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="mb-4 rounded bg-green-100 p-3 text-green-700 text-sm">
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- CARD PAKET -->
            <div class="overflow-hidden rounded-xl bg-white shadow">
                <img src="<?= base_url('uploads/paket/' . $paket->foto) ?>" class="h-64 w-full object-cover">

                <div class="p-6">
                    <h1 class="text-3xl font-bold text-gray-800">
                        <?= $paket->nama_paket ?>
                    </h1>

                    <p class="mt-2 text-yellow-500 text-lg">
                        ⭐ <?= number_format($rating, 1) ?> / 5
                    </p>

                    <p class="mt-4 text-gray-700 leading-relaxed">
                        <?= nl2br(htmlspecialchars($paket->deskripsi)) ?>
                    </p>

                    <p class="mt-6 text-2xl font-bold text-[#592300]">
                        Rp <?= number_format($paket->harga, 0, ',', '.') ?>
                    </p>

                    <div class="mt-6 flex gap-3 flex-wrap">
                        <a href="<?= site_url('user/reservasi/form/' . $paket->id_paket) ?>"
                            class="rounded-lg bg-[#592300] px-6 py-3 text-white hover:opacity-90">
                            Pesan Paket
                        </a>

                        <?php if ($this->session->userdata('id_user')): ?>
                            <button onclick="openModal()" class="rounded-lg border border-[#592300]
                                       px-6 py-3 text-[#592300]
                                       hover:bg-[#592300] hover:text-white transition">
                                ⭐ Beri Review
                            </button>
                        <?php else: ?>
                            <a href="<?= site_url('auth/login') ?>" class="rounded-lg border border-[#592300]
                                  px-6 py-3 text-[#592300]
                                  hover:bg-[#592300] hover:text-white transition">
                                🔒 Login untuk memberi review
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- LIST REVIEW -->
            <div class="mt-10">
                <h3 class="mb-4 text-xl font-bold text-gray-800">
                    Ulasan Pengunjung
                </h3>

                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $r): ?>
                        <div class="mb-4 rounded-lg bg-white p-4 shadow">
                            <div class="flex items-start gap-3">

                                <img src="<?= base_url('uploads/profile/' . (!empty($r->foto) ? $r->foto : 'default.png')) ?>"
                                    alt="Foto Profil" class="w-10 h-10 rounded-full object-cover border shadow">


                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <strong><?= $r->nama ?></strong>
                                        <span class="text-xs text-gray-500">
                                            <?= date('d M Y', strtotime($r->created_at)) ?>
                                        </span>
                                    </div>

                                    <div class="text-yellow-500 text-sm">
                                        <?= str_repeat('★', $r->rating) ?>
                                        <?= str_repeat('☆', 5 - $r->rating) ?>
                                    </div>

                                    <p class="mt-1 text-sm text-gray-600">
                                        <?= $r->komentar ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="italic text-gray-500">
                        Belum ada review untuk paket ini.
                    </p>
                <?php endif; ?>
            </div>

            <a href="<?= site_url('user/paket') ?>" class="mt-8 inline-flex text-sm text-[#592300] hover:underline">
                ← Kembali ke daftar paket
            </a>
        </div>
    </section>

    <!-- MODAL REVIEW -->
    <div id="reviewModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center">

        <div class="w-full max-w-md rounded-xl bg-white p-6">
            <h3 class="mb-3 text-lg font-bold">Beri Rating & Review</h3>

            <form action="<?= site_url('user/paket/simpan_review') ?>" method="post">
                <!-- CSRF -->
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                    value="<?= $this->security->get_csrf_hash(); ?>">

                <input type="hidden" name="id_paket" value="<?= $paket->id_paket ?>">
                <input type="hidden" name="rating" id="ratingValue">

                <div class="mb-4 text-center">
                    <span class="star" data-val="1">★</span>
                    <span class="star" data-val="2">★</span>
                    <span class="star" data-val="3">★</span>
                    <span class="star" data-val="4">★</span>
                    <span class="star" data-val="5">★</span>
                </div>

                <textarea name="komentar" class="w-full rounded-lg border p-2" rows="3"
                    placeholder="Tulis komentar (opsional)"></textarea>

                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="rounded px-4 py-2 text-sm">
                        Batal
                    </button>
                    <button type="submit" onclick="return ratingInput.value !== ''"
                        class="rounded bg-[#592300] px-4 py-2 text-sm text-white">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('ratingValue');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const val = star.dataset.val;
                ratingInput.value = val;
                stars.forEach(s =>
                    s.classList.toggle('active', s.dataset.val <= val)
                );
            });
        });

        function openModal() {
            document.getElementById('reviewModal').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('reviewModal').classList.add('hidden');
        }
    </script>

</body>

</html>