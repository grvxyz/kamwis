<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Kampung Wisata Kauman</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* ================= SKELETON ================= */
        .skeleton {
            background: linear-gradient(
                90deg,
                #e5e7eb 25%,
                #f3f4f6 37%,
                #e5e7eb 63%
            );
            background-size: 400% 100%;
            animation: shimmer 1.4s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -400px 0; }
            100% { background-position: 400px 0; }
        }

        /* ================= SCROLL REVEAL ================= */
        .reveal {
            opacity: 0;
            transform: translateY(60px) scale(.96);
            transition: all .9s cubic-bezier(.22, 1, .36, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: none;
        }
    </style>
</head>

<body class="bg-gray-50">

<?php $this->load->view('partials/header'); ?>

<!-- ================= HERO SLIDER EVENT ================= -->
<?php if (!empty($event_slider)) : ?>
<section class="relative h-[520px] overflow-hidden">
    <div id="slider" class="flex h-full transition-transform duration-700">

        <?php foreach ($event_slider as $e) : ?>
        <div class="min-w-full relative bg-cover bg-center"
             style="background-image:url('<?= base_url('uploads/event/'.$e->foto) ?>')">

            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>

            <div class="relative h-full flex items-center">
                <div class="max-w-7xl mx-auto px-6 text-white">

                    <span class="inline-block mb-3 px-3 py-1 text-xs bg-white/20 rounded-full">
                        📅 Event
                    </span>

                    <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                        <?= $e->nama_event ?>
                    </h1>

                    <p class="max-w-2xl mb-6 text-gray-200">
                        <?= word_limiter(strip_tags($e->deskripsi), 30) ?>
                    </p>

                    <div class="flex items-center gap-4 text-sm text-gray-300">
                        <span>📍 <?= $e->lokasi ?></span>
                        <span>•</span>
                        <span><?= date('d M Y', strtotime($e->tanggal_mulai)) ?></span>
                    </div>

                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</section>
<?php endif; ?>

<!-- ================= TENTANG KAMI ================= -->
<section class="py-16 bg-white reveal">
    <div class="max-w-7xl mx-auto px-6">

        <div class="grid md:grid-cols-2 gap-12 items-center">

            <!-- TEXT -->
            <div>
                <span class="inline-block mb-3 px-4 py-1 text-sm bg-orange-100 text-orange-700 rounded-full">
                    Tentang Kami
                </span>

                <h2 class="text-3xl font-bold text-gray-800 mb-4 leading-tight">
                    Kampung Wisata Kauman Yogyakarta
                </h2>

                <p class="text-gray-600 mb-4 leading-relaxed">
                    Kampung Wisata Kauman merupakan salah satu kampung tertua di Yogyakarta
                    yang memiliki nilai sejarah, religi, dan budaya yang kuat. Terletak
                    di kawasan Masjid Gedhe Kauman, kampung ini menjadi saksi perkembangan
                    peradaban Islam dan lahirnya Muhammadiyah.
                </p>

                <p class="text-gray-600 line-clamp-3">
                    Kauman dikenal sebagai living museum yang menyimpan jejak sejarah,
                    tradisi masyarakat, serta aktivitas wisata edukatif yang masih
                    lestari hingga kini.
                </p>

                <a href="<?= site_url('user/tentang_kami') ?>"
                   class="inline-block mt-6 text-orange-600 font-medium hover:underline">
                    Selengkapnya →
                </a>
            </div>

            <!-- IMAGE -->
            <div class="relative">
                <img src="<?= base_url('uploads/aboutus/5356.jpg'); ?>"
                     alt="Kampung Wisata Kauman"
                     class="rounded-2xl shadow-lg object-cover w-full h-[320px]">
            </div>

        </div>
    </div>
</section>

<!-- ================= PAKET UNGGULAN ================= -->
<section class="py-20 reveal">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-3">
                Paket Wisata Unggulan
            </h2>
            <p class="text-gray-600">
                Paket yang paling sering dipesan pengunjung
            </p>
        </div>

        <?php if (!empty($paket_unggulan)) : ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

            <?php foreach ($paket_unggulan as $p) : ?>
            <a href="<?= site_url('user/paket/detail/'.$p->id_paket) ?>"
               class="block bg-white rounded-2xl shadow hover:shadow-2xl transition overflow-hidden group active:scale-[0.98]">

                <div class="relative">
                    <img src="<?= base_url('uploads/paket/'.$p->foto) ?>"
                         class="h-52 w-full object-cover group-hover:scale-105 transition duration-500">

                    <div class="absolute top-4 right-4 bg-orange-500 text-white text-xs px-3 py-1 rounded-full shadow">
                        🔥 Terlaris
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="font-semibold text-xl text-gray-800 mb-2">
                        <?= $p->nama_paket ?>
                    </h3>

                    <p class="text-sm text-gray-600 line-clamp-2 mb-4">
                        <?= word_limiter(strip_tags($p->deskripsi), 20) ?>
                    </p>

                    <div class="flex items-center justify-between">
                        <span class="font-bold text-lg text-gray-900">
                            Rp <?= number_format($p->harga, 0, ',', '.') ?>
                        </span>

                        <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded">
                            <?= $p->total_dipesan ?>x dipesan
                        </span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>

        </div>
        <?php else : ?>
            <p class="text-center italic text-gray-500">
                Belum ada paket unggulan.
            </p>
        <?php endif; ?>

    </div>
</section>

<!-- ================= FASILITAS ================= -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-xl font-semibold text-gray-800 mb-8">
            Fasilitas
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Area Parkir -->
            <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100">
                    <span class="text-green-600 font-bold text-lg">P</span>
                </div>
                <p class="font-medium text-gray-800">Area Parkir Luas</p>
            </div>

            <!-- Mushola -->
            <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-600 text-lg">
                    ☪
                </div>
                <p class="font-medium text-gray-800">Mushola</p>
            </div>

            <!-- Workshop Batik -->
            <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                    ✒
                </div>
                <p class="font-medium text-gray-800">Workshop Batik</p>
            </div>

            <!-- Pusat Informasi -->
            <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-600 font-bold">
                    i
                </div>
                <p class="font-medium text-gray-800">Pusat Informasi</p>
            </div>

            <!-- Toilet -->
            <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                    💧
                </div>
                <p class="font-medium text-gray-800">Toilet Bersih</p>
            </div>

            <!-- Galeri Batik -->
            <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                    🏬
                </div>
                <p class="font-medium text-gray-800">Galeri Batik</p>
            </div>

            <!-- Warung -->
            <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                    ☕
                </div>
                <p class="font-medium text-gray-800">Warung Tradisional</p>
            </div>

            <!-- Spot Foto -->
            <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                    📷
                </div>
                <p class="font-medium text-gray-800">Spot Foto</p>
            </div>

        </div>

    </div>
</section>


        <!-- LINK -->
        <div class="text-center mt-12">
            <a href="<?= site_url('user/tentang_kami') ?>"
               class="inline-block text-orange-600 font-medium hover:underline">
                Lihat detail fasilitas →
            </a>
        </div>

    </div>
</section>

<!-- ================= RUTE PAKET ================= -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-6">

        <h3 class="text-2xl font-bold text-gray-800 mb-6">
            Rute Paket Wisata
        </h3>

        <div class="relative border-l-2 border-orange-500 pl-6 space-y-6">

            <div class="flex items-start gap-4">
                <span class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold">1</span>
                <p class="text-gray-700 font-medium">Masjid Gedhe Kauman</p>
            </div>

            <div class="flex items-start gap-4">
                <span class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold">2</span>
                <p class="text-gray-700 font-medium">Pengulon Kauman</p>
            </div>

            <div class="flex items-start gap-4">
                <span class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold">3</span>
                <p class="text-gray-700 font-medium">TK ABA ‘Aisyiyah</p>
            </div>

            <div class="flex items-start gap-4">
                <span class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold">4</span>
                <p class="text-gray-700 font-medium">Mushola ‘Aisyiyah</p>
            </div>

            <div class="flex items-start gap-4">
                <span class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold">5</span>
                <p class="text-gray-700 font-medium">Langgar Dhuwur</p>
            </div>

            <div class="flex items-start gap-4">
                <span class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold">6</span>
                <p class="text-gray-700 font-medium">Langgar KH. Ahmad Dahlan</p>
            </div>

            <div class="flex items-start gap-4">
                <span class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold">7</span>
                <p class="text-gray-700 font-medium">Makam Nyai Ahmad Dahlan</p>
            </div>

            <div class="flex items-start gap-4">
                <span class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold">8</span>
                <p class="text-gray-700 font-medium">SD Muhammadiyah Kauman</p>
            </div>

        </div>

    </div>
</section>



<!-- ================= ARTIKEL ================= -->
<section class="py-20 bg-white reveal">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-3">
                Artikel Terbaru
            </h2>
            <p class="text-gray-600">
                Cerita & informasi terbaru seputar Kampung Wisata Kauman
            </p>
        </div>

        <?php if (!empty($artikel)) : ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

            <?php foreach ($artikel as $a) : ?>
            <div class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden">

                <?php if (!empty($a->foto)) : ?>
                <img src="<?= base_url('uploads/artikel/'.$a->foto) ?>"
                     class="h-48 w-full object-cover">
                <?php endif; ?>

                <div class="p-5">
                    <h3 class="font-semibold text-lg text-gray-800 mb-2">
                        <?= $a->judul ?>
                    </h3>

                    <p class="text-sm text-gray-600 line-clamp-3">
                        <?= word_limiter(strip_tags($a->isi), 18) ?>
                    </p>

                    <a href="<?= site_url('artikel/'.$a->slug) ?>"
                       class="inline-block mt-3 text-sm text-orange-600 hover:underline">
                        Baca Selengkapnya →
                    </a>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
        <?php else : ?>
            <p class="text-gray-500 italic text-center">
                Belum ada artikel.
            </p>
        <?php endif; ?>

    </div>
</section>


<!-- ================= GALERI FOTO & VIDEO ================= -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-3xl font-bold text-center mb-12">
            Galeri Kampung Wisata
        </h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">

            <?php foreach ($galeri as $g) : ?>

                <?php if ($g->jenis === 'foto') : ?>
                    <img src="<?= base_url('uploads/galeri/'.$g->file) ?>"
                         class="rounded-xl aspect-square object-cover hover:scale-105 transition">
                <?php else : ?>
                    <div class="aspect-square rounded-xl overflow-hidden bg-black">
                        <video controls class="w-full h-full object-cover">
                            <source src="<?= base_url('uploads/galeri/'.$g->file) ?>" type="video/mp4">
                        </video>
                    </div>
                <?php endif; ?>

            <?php endforeach; ?>

        </div>
    </div>
</section>


<!-- ================= JS ================= -->
<script>
    /* Slider */
    let index = 0;
    const slider = document.getElementById('slider');

    if (slider) {
        setInterval(() => {
            index = (index + 1) % slider.children.length;
            slider.style.transform = `translateX(-${index * 100}%)`;
        }, 5000);
    }

    /* Scroll Reveal */
    const reveals = document.querySelectorAll('.reveal');

    window.addEventListener('scroll', () => {
        const trigger = window.innerHeight * 0.85;

        reveals.forEach(el => {
            if (el.getBoundingClientRect().top < trigger) {
                el.classList.add('active');
            }
        });
    });
</script>

</body>
</html>
