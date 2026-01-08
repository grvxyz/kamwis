<!DOCTYPE html>
<html lang="id" data-theme="cupcake">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | Kampung Wisata Kauman</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            plugins: [daisyui],
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/daisyui@4.12.10"></script>


    <style>
        /* ================= SKELETON ================= */
        .skeleton {
            background: linear-gradient(90deg,
                    #e5e7eb 25%,
                    #f3f4f6 37%,
                    #e5e7eb 63%);
            background-size: 400% 100%;
            animation: shimmer 1.4s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -400px 0;
            }

            100% {
                background-position: 400px 0;
            }
        }

        /* ================= SCROLL REVEAL ================= */
        .reveal {
            opacity: 0;
            transform: translateY(60px) scale(0.96);
            transition: all 0.9s cubic-bezier(.22, 1, .36, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: none;
        }

        /* ================= ROUTE LINE ================= */
        .route-line {
            height: 0;
            transform-origin: top;
        }

        /* ================= FACILITY ================= */
        .facility-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            border-radius: 9999px;
            background: #dcfce7;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #16a34a;
        }

        .facility-title {
            font-weight: 600;
            color: #1f2937;
        }
    </style>

</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>


<body class="bg-gray-50">

    <?php $this->load->view('partials/header-awal'); ?>


    <!-- ================= HERO SLIDER EVENT ================= -->
    <?php if (!empty($event_slider)): ?>
        <section class="relative h-[520px] overflow-hidden">
            <div id="slider" class="flex h-full transition-transform duration-700">

                <?php foreach ($event_slider as $e): ?>
                    <div class="min-w-full relative bg-cover bg-center"
                        style="background-image:url('<?= base_url('uploads/event/' . $e->foto) ?>')">

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
                                    <span> - </span>
                                    <span><?= date('d M Y', strtotime($e->tanggal_selesai)) ?></span>
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
                    <img src="<?= base_url('uploads/aboutus/5356.jpg'); ?>" alt="Kampung Wisata Kauman"
                        class="rounded-2xl shadow-lg object-cover w-full h-[320px]">
                </div>

            </div>
        </div>
    </section>

    <!-- ================= PAKET UNGGULAN ================= -->
    <section class="py-20 reveal bg-white">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-3">
                    Paket Wisata Unggulan
                </h2>
                <p class="text-gray-600">
                    Paket yang paling sering dipesan pengunjung
                </p>
            </div>

            <?php if (!empty($paket_unggulan)): ?>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

                    <?php foreach ($paket_unggulan as $p): ?>
                        <a href="<?= site_url('user/paket/detail/' . $p->id_paket) ?>"
                            class="block bg-white rounded-2xl shadow hover:shadow-2xl transition overflow-hidden group active:scale-[0.98]">

                            <div class="relative">
                                <img src="<?= base_url('uploads/paket/' . $p->foto) ?>"
                                    class="h-52 w-full object-cover group-hover:scale-105 transition duration-500">

                                <div
                                    class="absolute top-4 right-4 bg-orange-500 text-white text-xs px-3 py-1 rounded-full shadow">
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
            <?php else: ?>
                <p class="text-center italic text-gray-500">
                    Belum ada paket unggulan.
                </p>
            <?php endif; ?>

        </div>
    </section>
    <!-- ================= DAFTAR PAKET WISATA ================= -->
    <section class="py-20 reveal bg-white">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-3">
                    Daftar Paket Wisata
                </h2>
                <p class="text-white-600">
                    Pilihan paket wisata Kampung Wisata Kauman
                </p>
            </div>

            <?php if (!empty($paket_wisata)): ?>
                <div class="flex gap-6 overflow-x-auto snap-x snap-mandatory pb-4">

                    <?php foreach ($paket_wisata as $p): ?>
                        <div class="min-w-[280px] max-w-[280px] snap-start
                bg-white rounded-2xl shadow hover:shadow-xl
                transition overflow-hidden flex-shrink-0">

                            <img src="<?= base_url('uploads/paket/' . $p->foto) ?>" class="h-48 w-full object-cover">

                            <div class="p-6">
                                <h3 class="font-semibold text-lg text-gray-800 mb-2">
                                    <?= $p->nama_paket ?>
                                </h3>

                                <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                                    <?= word_limiter(strip_tags($p->deskripsi), 25) ?>
                                </p>

                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-orange-600">
                                        Rp <?= number_format($p->harga, 0, ',', '.') ?>
                                    </span>

                                    <a href="<?= site_url('user/paket/detail/' . $p->id_paket) ?>"
                                        class="text-sm text-orange-600 hover:underline">
                                        Detail →
                                    </a>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>

                </div>
            <?php else: ?>
                <p class="text-center text-gray-500 italic">
                    Paket wisata belum tersedia.
                </p>
            <?php endif; ?>

        </div>
    </section>

    <!-- ================= FASILITAS ================= -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-14 reveal">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">
                    Fasilitas Kampung Wisata
                </h2>
                <p class="text-gray-600 text-sm">
                    Fasilitas pendukung kenyamanan pengunjung
                </p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-8">

                <!-- Item -->
                <div class="facility-card bg-white rounded-2xl p-6 text-center shadow-sm">
                    <div class="facility-icon">🅿</div>
                    <h4 class="facility-title">Area Parkir Luas</h4>
                </div>

                <div class="facility-card bg-white rounded-2xl p-6 text-center shadow-sm">
                    <div class="facility-icon">🕌</div>
                    <h4 class="facility-title">Mushola</h4>
                </div>

                <div class="facility-card bg-white rounded-2xl p-6 text-center shadow-sm">
                    <div class="facility-icon">🎨</div>
                    <h4 class="facility-title">Workshop Batik</h4>
                </div>

                <div class="facility-card bg-white rounded-2xl p-6 text-center shadow-sm">
                    <div class="facility-icon">ℹ</div>
                    <h4 class="facility-title">Pusat Informasi</h4>
                </div>

                <div class="facility-card bg-white rounded-2xl p-6 text-center shadow-sm">
                    <div class="facility-icon">🚻</div>
                    <h4 class="facility-title">Toilet Bersih</h4>
                </div>

                <div class="facility-card bg-white rounded-2xl p-6 text-center shadow-sm">
                    <div class="facility-icon">🏬</div>
                    <h4 class="facility-title">Galeri Batik</h4>
                </div>

                <div class="facility-card bg-white rounded-2xl p-6 text-center shadow-sm">
                    <div class="facility-icon">☕</div>
                    <h4 class="facility-title">Warung Tradisional</h4>
                </div>

                <div class="facility-card bg-white rounded-2xl p-6 text-center shadow-sm">
                    <div class="facility-icon">📸</div>
                    <h4 class="facility-title">Spot Foto</h4>
                </div>

            </div>
        </div>
    </section>




    <!-- ================= RUTE PAKET ================= -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-6">

            <h3 class="text-2xl font-bold text-gray-800 mb-14 text-center">
                Rute Paket Wisata
            </h3>

            <div class="space-y-12">

                <!-- 1 -->
                <div class="relative flex gap-6 route-item">
                    <span class="route-line absolute left-6 top-12 w-0.5 bg-orange-200"></span>
                    <div
                        class="route-dot z-10 w-12 h-12 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold shadow">
                        1
                    </div>
                    <div class="route-card bg-white rounded-xl shadow p-5 w-full">
                        <h4 class="font-semibold text-gray-800">Masjid Gedhe Kauman</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            Masjid Gedhe Kauman merupakan masjid Kasultanan Ngayogyakarta Hadiningrat yang berdiri pada
                            tahun 1773 atas perintah Sri Sultan Hamengku Buwono I. Masjid ini memiliki nilai sejarah,
                            keagamaan, dan budaya tinggi serta menjadi simbol perpaduan Islam dan budaya Jawa.
                        </p>
                    </div>
                </div>

                <!-- 2 -->
                <div class="relative flex gap-6 route-item">
                    <span class="route-line absolute left-6 top-12 w-0.5 bg-orange-200"></span>
                    <div
                        class="route-dot z-10 w-12 h-12 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold shadow">
                        2
                    </div>
                    <div class="route-card bg-white rounded-xl shadow p-5 w-full">
                        <h4 class="font-semibold text-gray-800">Pengulon Kauman</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            Merupakan tempat tinggal dan pusat kegiatan para pejabat penghulu Kesultanan Yogyakarta
                            (ulama Keraton) sejak tahun 1775, berfungsi sebagai pusat ritual keagamaan dan pelayanan
                            nikah, kini menjadi cagar budaya yang terdiri dari pendopo, pringgitan, dan rumah induk,
                            mencerminkan peran penting Kauman sebagai kampung religi penegak agama Islam di Yogyakarta
                        </p>
                    </div>
                </div>

                <!-- 3 -->
                <div class="relative flex gap-6 route-item">
                    <span class="route-line absolute left-6 top-12 w-0.5 bg-orange-200"></span>
                    <div
                        class="route-dot z-10 w-12 h-12 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold shadow">
                        3
                    </div>
                    <div class="route-card bg-white rounded-xl shadow p-5 w-full">
                        <h4 class="font-semibold text-gray-800">TK ABA ‘Aisyiyah</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            Pendirian pendidikan anak usia dini oleh ‘Aisyiyah berawal dari kepedulian Nyai Dahlan
                            terhadap anak-anak pribumi di Kauman yang kurang mendapatkan bimbingan. Upaya ini diwujudkan
                            melalui pendirian Frobel Kindergarten ‘Aisyiyah pada 24 Agustus 1919 atas prakarsa Siti
                            Umniyah, yang kemudian berkembang menjadi ‘Aisyiyah Bustanul Athfal pada tahun 1922.
                            Inisiatif ini menjadi tonggak penting dalam sejarah pendidikan anak dan perempuan, serta
                            menegaskan peran ‘Aisyiyah dalam membangun fondasi pendidikan sejak usia dini di Indonesia.
                        </p>
                    </div>
                </div>

                <!-- 4 -->
                <div class="relative flex gap-6 route-item">
                    <span class="route-line absolute left-6 top-12 w-0.5 bg-orange-200"></span>
                    <div
                        class="route-dot z-10 w-12 h-12 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold shadow">
                        4
                    </div>
                    <div class="route-card bg-white rounded-xl shadow p-5 w-full">
                        <h4 class="font-semibold text-gray-800">Mushola ‘Aisyiyah</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            Musholla ‘Aisyiyah yang didirikan pada 1922 di Yogyakarta merupakan musala perempuan pertama
                            di dunia dan menjadi tonggak penting perjuangan hak serta pendidikan keagamaan perempuan.
                            Berawal dari gerakan Sapa Tresna yang kemudian menjadi ‘Aisyiyah, musholla ini tidak hanya
                            berfungsi sebagai tempat ibadah, tetapi juga pusat pembinaan, pendidikan, dan pemberdayaan
                            perempuan. Dari sinilah lahir tokoh-tokoh perempuan berpengaruh yang mendorong kemajuan
                            perempuan Indonesia, termasuk pelaksanaan Kongres Perempuan pertama tahun 1928, sehingga
                            menegaskan peran strategis ‘Aisyiyah dalam sejarah gerakan perempuan dan Islam di Indonesia.
                        </p>
                    </div>
                </div>

                <!-- 5 -->
                <div class="relative flex gap-6 route-item">
                    <span class="route-line absolute left-6 top-12 w-0.5 bg-orange-200"></span>
                    <div
                        class="route-dot z-10 w-12 h-12 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold shadow">
                        5
                    </div>
                    <div class="route-card bg-white rounded-xl shadow p-5 w-full">
                        <h4 class="font-semibold text-gray-800">Pendopo Tabligh (Langgar Dhuwur)</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            Pendopo Tabligh memiliki peran penting dalam sejarah dakwah dan lahirnya organisasi
                            Muhammadiyah. Tempat ini menjadi pusat diskusi Kyai Dahlan dan murid-muridnya yang
                            melahirkan gagasan pendirian Muhammadiyah pada 18 November 1912, dengan nama yang diusulkan
                            oleh Kyai Sangidu. Selain itu, kawasan ini juga berkaitan erat dengan perencanaan lahirnya
                            organisasi otonom Muhammadiyah seperti IMM dan IPM, yang mengalami dinamika nama hingga
                            kembali menggunakan IPM pada 28 Oktober 2008, menegaskan perannya sebagai pusat pemikiran
                            dan gerakan kaderisasi Muhammadiyah.
                        </p>
                    </div>
                </div>

                <!-- 6 -->
                <div class="relative flex gap-6 route-item">
                    <span class="route-line absolute left-6 top-12 w-0.5 bg-orange-200"></span>
                    <div
                        class="route-dot z-10 w-12 h-12 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold shadow">
                        6
                    </div>
                    <div class="route-card bg-white rounded-xl shadow p-5 w-full">
                        <h4 class="font-semibold text-gray-800">Langgar KH. Ahmad Dahlan</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            Langgar Kidul KH Ahmad Dahlan memiliki peran penting sebagai pusat ibadah, dakwah, dan
                            pendidikan masyarakat Kauman. Meski sempat dirobohkan akibat perbedaan pandangan keagamaan,
                            langgar ini dibangun kembali dan berkembang menjadi tempat pembaruan pemikiran Islam,
                            termasuk koreksi arah kiblat dan pengajaran madrasah yang menjadi cikal bakal sekolah
                            Muhammadiyah. Perjuangan KH Ahmad Dahlan, bahkan hingga melelang harta pribadi demi
                            keberlangsungan pendidikan, menunjukkan keteguhan dan pengorbanannya dalam menyebarkan
                            dakwah dan mencerdaskan umat.
                        </p>
                    </div>
                </div>

                <!-- 7 -->
                <div class="relative flex gap-6 route-item">
                    <span class="route-line absolute left-6 top-12 w-0.5 bg-orange-200"></span>
                    <div
                        class="route-dot z-10 w-12 h-12 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold shadow">
                        7
                    </div>
                    <div class="route-card bg-white rounded-xl shadow p-5 w-full">
                        <h4 class="font-semibold text-gray-800">Makam Nyai Ahmad Dahlan</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            Nyai Dahlan yang bernama asli Siti Walidah merupakan tokoh perempuan penting dalam sejarah
                            Muhammadiyah dan bangsa Indonesia. Lahir tahun 1872 dan wafat pada 1946, beliau dikenal atas
                            kesederhanaan, keteguhan prinsip, serta perjuangannya dalam pendidikan dan sosial keagamaan.
                            Pendiri organisasi perempuan Sapa Tresna yang kemudian menjadi ‘Aisyiyah, beliau ditetapkan
                            sebagai Pahlawan Nasional pada 22 September 1971 atas jasanya bagi umat dan bangsa.
                        </p>
                    </div>
                </div>

                <!-- 8 (TERAKHIR - TANPA GARIS) -->
                <div class="relative flex gap-6 route-item">
                    <div
                        class="route-dot z-10 w-12 h-12 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold shadow">
                        8
                    </div>
                    <div class="route-card bg-white rounded-xl shadow p-5 w-full">
                        <h4 class="font-semibold text-gray-800">SD Muhammadiyah Kauman</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            Kyai Ahmad Dahlan merintis pembaruan pendidikan Islam dengan mendirikan Madrasah Ibtidaiyah
                            Diniyah Islamiyah (MIDI) pada 1 Desember 1911, yang memadukan ilmu agama dan ilmu umum.
                            Meski awalnya mendapat penolakan masyarakat Kauman, sekolah ini berkembang pesat berkat
                            keteguhan Kyai Dahlan, dukungan guru dari Budi Utomo, serta perhatian Kasultanan Yogyakarta.
                            Perjuangan beliau yang membiayai sekolah secara mandiri, bahkan hingga melelang harta
                            pribadi, menunjukkan komitmen besar dalam mencerdaskan umat dan menjadi fondasi penting bagi
                            berkembangnya pendidikan Muhammadiyah.
                        </p>
                    </div>
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

            <?php if (!empty($artikel)): ?>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

                    <?php foreach ($artikel as $a): ?>
                        <?php if ($a->status !== 'publish')
                            continue; ?>
                        <div class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden">

                            <?php if (!empty($a->foto)): ?>
                                <img src="<?= base_url('uploads/artikel/' . $a->foto) ?>" class="h-48 w-full object-cover">
                            <?php endif; ?>

                            <div class="p-5">
                                <h3 class="font-semibold text-lg text-gray-800 mb-2">
                                    <?= $a->judul ?>
                                </h3>

                                <p class="text-sm text-gray-600 line-clamp-3">
                                    <?= nl2br(htmlspecialchars($a->isi)) ?>
                                </p>

                                <a href="<?= site_url('artikel/' . $a->slug) ?>"
                                    class="inline-block mt-3 text-sm text-orange-600 hover:underline">
                                    Baca Selengkapnya →
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            <?php else: ?>
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

                <?php foreach ($galeri as $g): ?>
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm cursor-pointer gallery-item"
                        data-type="<?= $g->jenis ?>" data-src="<?= base_url('uploads/galeri/' . $g->file) ?>"
                        data-desc="<?= htmlspecialchars($g->deskripsi ?? 'Tidak ada deskripsi') ?>">

                        <?php if ($g->jenis === 'foto'): ?>
                            <img src="<?= base_url('uploads/galeri/' . $g->file) ?>"
                                class="w-full aspect-square object-cover transition-transform duration-300 hover:scale-105">
                        <?php else: ?>
                            <div class="aspect-square bg-black">
                                <video class="w-full h-full object-cover pointer-events-none">
                                    <source src="<?= base_url('uploads/galeri/' . $g->file) ?>" type="video/mp4">
                                </video>
                            </div>
                        <?php endif; ?>

                        <div class="p-3">
                            <p class="text-lg font-bold text-gray-800 line-clamp-2">
                                <?= $g->heading ?? 'Tidak ada deskripsi' ?>
                            </p>

                            <p class="text-sm text-gray-700 line-clamp-2">
                                <?= $g->deskripsi ?? 'Tidak ada deskripsi' ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>


    <!-- ================= MODAL GALERI ================= -->
    <dialog id="galleryModal" class="modal">
        <div class="modal-box max-w-4xl p-0 overflow-hidden rounded-xl">

            <!-- Close button -->
            <form method="dialog">
                <button class="btn btn-sm btn-circle absolute right-3 top-3 z-10 bg-white text-black hover:bg-gray-200">
                    ✕
                </button>
            </form>

            <!-- Media (image / video) -->
            <div id="modalContent" class="bg-black flex items-center justify-center max-h-[70vh]"></div>

            <!-- Description -->
            <div class="p-5 bg-white">
                <p id="modalDesc" class="text-base text-gray-700 leading-relaxed"></p>
            </div>

        </div>
    </dialog>


    <script>
        document.addEventListener("DOMContentLoaded", () => {

            /* =====================================================
               GALLERY MODAL (DaisyUI)
            ===================================================== */
            const modal = document.getElementById('galleryModal');
            const modalContent = document.getElementById('modalContent');
            const modalDesc = document.getElementById('modalDesc');

            document.querySelectorAll('.gallery-item').forEach(item => {
                item.addEventListener('click', () => {

                    const { type, src, desc } = item.dataset;
                    if (!type || !src) return;

                    modalContent.innerHTML = '';

                    if (type === 'foto') {
                        modalContent.innerHTML = `
          <img src="${src}" class="w-full max-h-[70vh] object-contain bg-black">
        `;
                    } else {
                        modalContent.innerHTML = `
          <video controls autoplay class="w-full max-h-[70vh] bg-black">
            <source src="${src}" type="video/mp4">
          </video>
        `;
                    }

                    modalDesc.textContent = desc || '';
                    modal.showModal();
                });
            });

            /* =====================================================
               SLIDER
            ===================================================== */
            const slider = document.getElementById('slider');
            let index = 0;

            if (slider) {
                setInterval(() => {
                    index = (index + 1) % slider.children.length;
                    slider.style.transform = `translateX(-${index * 100}%)`;
                }, 5000);
            }

            /* =====================================================
               SCROLL REVEAL
            ===================================================== */
            const reveals = document.querySelectorAll('.reveal');

            const revealOnScroll = () => {
                const trigger = window.innerHeight * 0.85;
                reveals.forEach(el => {
                    if (el.getBoundingClientRect().top < trigger) {
                        el.classList.add('active');
                    }
                });
            };

            window.addEventListener('scroll', revealOnScroll);
            revealOnScroll();

            /* =====================================================
               FACILITY CARD (Anime.js)
            ===================================================== */
            if (window.anime) {
                anime({
                    targets: '.facility-card',
                    opacity: [0, 1],
                    translateY: [40, 0],
                    delay: anime.stagger(100),
                    duration: 700,
                    easing: 'easeOutExpo'
                });
            }

            /* =====================================================
               ROUTE ITEM OBSERVER
            ===================================================== */
            const routeItems = document.querySelectorAll('.route-item');

            if (routeItems.length && window.IntersectionObserver && window.anime) {
                const routeObserver = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting) return;

                        const line = entry.target.querySelector('.route-line');
                        const dot = entry.target.querySelector('.route-dot');
                        const card = entry.target.querySelector('.route-card');

                        if (line) {
                            anime({
                                targets: line,
                                height: ['0px', '100%'],
                                duration: 600,
                                easing: 'easeOutQuad'
                            });
                        }

                        anime({
                            targets: dot,
                            scale: [0, 1],
                            opacity: [0, 1],
                            duration: 500,
                            delay: 150,
                            easing: 'easeOutBack'
                        });

                        anime({
                            targets: card,
                            translateX: [40, 0],
                            opacity: [0, 1],
                            duration: 600,
                            delay: 250,
                            easing: 'easeOutExpo'
                        });

                        routeObserver.unobserve(entry.target);
                    });
                }, { threshold: 0.4 });

                routeItems.forEach(item => routeObserver.observe(item));
            }

        });
    </script>





    <a href="https://wa.me/6285161813489?text=Halo%2C%20saya%20ingin%20mendapatkan%20informasi%20lebih%20lanjut"
        target="_blank" rel="noopener noreferrer" aria-label="Chat WhatsApp" class="group fixed bottom-5 right-5 z-50
          flex items-center justify-center
          w-14 h-14 rounded-full
          bg-green-500
          shadow-lg hover:bg-green-600
          transition-all duration-300">

        <img src="https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/whatsapp.svg" alt="WhatsApp"
            class="w-7 h-7 invert" />

        <!-- TOOLTIP -->
        <span class="absolute right-16 opacity-0 group-hover:opacity-100
               bg-black text-white text-xs px-3 py-1 rounded
               whitespace-nowrap transition">
            Chat via WhatsApp
        </span>
    </a>

</body>

</html>