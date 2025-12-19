<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kampung Wisata Kauman</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons (ICON SAJA, AMAN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-[#f4f8fb] font-sans">

<div class="max-w-7xl mx-auto px-4 mt-6 mb-10">

    <!-- HERO -->
    <div class="bg-gradient-to-r from-blue-600 to-green-600 text-white
                px-8 py-10 rounded-[18px] text-center shadow-lg mb-6">
        <h3 class="text-2xl font-bold mb-2">
            Tentang Kampung Wisata Kauman
        </h3>
        <p class="text-base leading-relaxed opacity-95">
            Kampung Wisata Kauman adalah kampung bersejarah di Yogyakarta yang berdiri sejak 1773 di sekitar Masjid Gedhe Kauman.
            Kampung ini menjadi pusat kehidupan keagamaan Islam, tempat tinggal abdi dalem dan ulama keraton, serta tempat lahirnya
            Muhammadiyah, sehingga dikenal sebagai living museum, kampung religi, dan wisata sejarah.
        </p>
    </div>

    <!-- IMAGE -->
    <div class="bg-white rounded-[18px] overflow-hidden shadow-md mb-6">
        <img
            src="<?= base_url('uploads/aboutus/5356.jpg'); ?>"
            alt="Tentang Kampung Wisata Kauman"
            class="w-full h-[320px] object-cover block">
    </div>

    <!-- SEJARAH -->
    <div class="bg-white rounded-[18px] p-8 shadow-md mb-6">
        <h5 class="text-lg font-bold text-gray-800 mb-3">
            Sejarah Kampung Kauman
        </h5>

        <p class="text-gray-600 leading-relaxed mb-3">
            Kampung Wisata Kauman merupakan salah satu kampung tertua di Daerah Istimewa Yogyakarta yang berdiri sejak tahun 1773,
            bersamaan dengan didirikannya Masjid Gedhe Kauman oleh Sri Sultan Hamengku Buwono I.
        </p>

        <p class="text-gray-600 leading-relaxed">
            Pada awal abad ke-20, Kampung Kauman semakin memiliki arti penting dalam sejarah nasional dengan lahir dan berkembangnya
            organisasi Muhammadiyah yang didirikan oleh KH. Ahmad Dahlan pada tahun 1912.
        </p>
    </div>

    <!-- FASILITAS -->
    <div class="bg-white rounded-[18px] p-8 shadow-md mb-6">
        <h5 class="text-lg font-bold text-gray-800 mb-5">
            Fasilitas
        </h5>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <!-- ITEM -->
            <div class="bg-gray-50 rounded-xl p-4 text-center shadow hover:-translate-y-1 hover:shadow-lg transition">
                <i class="bi bi-p-circle-fill text-2xl text-green-600 mb-2 block"></i>
                <span class="text-sm font-semibold text-gray-700">Area Parkir Luas</span>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 text-center shadow hover:-translate-y-1 hover:shadow-lg transition">
                <i class="bi bi-moon-stars-fill text-2xl text-green-600 mb-2 block"></i>
                <span class="text-sm font-semibold text-gray-700">Mushola</span>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 text-center shadow hover:-translate-y-1 hover:shadow-lg transition">
                <i class="bi bi-brush-fill text-2xl text-green-600 mb-2 block"></i>
                <span class="text-sm font-semibold text-gray-700">Workshop Batik</span>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 text-center shadow hover:-translate-y-1 hover:shadow-lg transition">
                <i class="bi bi-info-circle-fill text-2xl text-green-600 mb-2 block"></i>
                <span class="text-sm font-semibold text-gray-700">Pusat Informasi</span>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 text-center shadow hover:-translate-y-1 hover:shadow-lg transition">
                <i class="bi bi-droplet-fill text-2xl text-green-600 mb-2 block"></i>
                <span class="text-sm font-semibold text-gray-700">Toilet Bersih</span>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 text-center shadow hover:-translate-y-1 hover:shadow-lg transition">
                <i class="bi bi-shop text-2xl text-green-600 mb-2 block"></i>
                <span class="text-sm font-semibold text-gray-700">Galeri Batik</span>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 text-center shadow hover:-translate-y-1 hover:shadow-lg transition">
                <i class="bi bi-cup-hot-fill text-2xl text-green-600 mb-2 block"></i>
                <span class="text-sm font-semibold text-gray-700">Warung Tradisional</span>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 text-center shadow hover:-translate-y-1 hover:shadow-lg transition">
                <i class="bi bi-camera-fill text-2xl text-green-600 mb-2 block"></i>
                <span class="text-sm font-semibold text-gray-700">Spot Foto</span>
            </div>

        </div>
    </div>

    <!-- KONTAK -->
    <div class="bg-white rounded-[18px] p-8 shadow-md">
        <h5 class="text-lg font-bold text-gray-800 mb-4">
            Informasi Kontak
        </h5>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">

            <div>
                <p class="mb-3">
                    <strong class="text-blue-600">Alamat:</strong><br>
                    Gg. KH. Zamhari, Ngupasan, Gondomanan, Yogyakarta
                </p>
                <p class="mb-3">
                    <strong class="text-blue-600">Telepon:</strong><br>
                    +62 851 6181 3489
                </p>
                <p>
                    <strong class="text-blue-600">Instagram:</strong><br>
                    kamwis.kaumanjogja
                </p>
            </div>

            <div>
                <p class="font-semibold mb-2">Jam Operasional</p>
                <p>07.00 – 11.00 WIB</p>
                <p>12.00 – 15.00 WIB</p>
                <p>15.00 – 17.00 WIB</p>
                <small class="text-gray-400">
                    *Jam dapat berubah saat hari besar.
                </small>
            </div>

        </div>
    </div>

</div>

</body>
</html>
