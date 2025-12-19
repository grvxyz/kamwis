<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Kampung Wisata Kauman</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">


    <!-- HERO SECTION -->
    <section class="bg-gradient-to-b from-[#592300] to-[#7a3b00] text-white py-24 px-6">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-4xl font-bold mb-4">Selamat Datang di Kampung Wisata Kauman</h1>
            <p class="text-lg max-w-2xl mb-6 text-gray-200">
                Jelajahi warisan budaya, seni batik, dan kuliner tradisional dalam satu destinasi wisata yang menakjubkan.
            </p>

            <div class="flex gap-4">
                <a href="#" class="px-6 py-3 bg-blue-900 hover:bg-blue-800 rounded-lg text-white font-medium">
                    Lihat Paket Wisata
                </a>
                <a href="<?= base_url('user/tentang_kami'); ?>" class="px-6 py-3 border border-white text-white rounded-lg hover:bg-white hover:text-[#592300] transition">
                    Tentang Kami
                </a>
            </div>
        </div>
    </section>

    <!-- FITUR UNGGULAN -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-6">
                
                <div class="bg-gray-50 p-6 rounded-xl shadow-sm text-center">
                    <div class="text-4xl mb-3">📦</div>
                    <h3 class="font-semibold text-lg mb-2">Paket Wisata Beragam</h3>
                    <p class="text-gray-600 text-sm">
                        Pilihan paket wisata yang disesuaikan dengan minat Anda.
                    </p>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl shadow-sm text-center">
                    <div class="text-4xl mb-3">📍</div>
                    <h3 class="font-semibold text-lg mb-2">Lokasi Strategis</h3>
                    <p class="text-gray-600 text-sm">
                        Terletak di pusat kota Yogyakarta dengan fasilitas lengkap.
                    </p>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl shadow-sm text-center">
                    <div class="text-4xl mb-3">⭐</div>
                    <h3 class="font-semibold text-lg mb-2">Pengalaman Berkesan</h3>
                    <p class="text-gray-600 text-sm">
                        Pengalaman wisata budaya yang autentik dan tak terlupakan.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- PAKET WISATA UNGGULAN -->
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-2xl font-bold mb-3">Paket Wisata Unggulan</h2>
            <p class="text-gray-600 mb-10">Temukan pengalaman wisata terbaik kami</p>

            <div class="grid md:grid-cols-3 gap-6">

                <!-- Paket 1 -->
                <div class="bg-white shadow rounded-xl overflow-hidden">
                    <img src="https://source.unsplash.com/600x400/?batik" class="w-full h-48 object-cover">
                    <div class="p-4 text-left">
                        <h3 class="font-semibold text-lg">Paket Wisata Batik Heritage</h3>
                        <p class="text-gray-600 text-sm mt-1">
                            Pelajari batik Kauman dalam workshop membatik langsung.
                        </p>
                        <p class="font-bold mt-3">Rp 250.000</p>
                        <a href="#" class="mt-3 inline-block px-4 py-2 bg-black text-white rounded-lg text-sm">Lihat Detail</a>
                    </div>
                </div>

                <!-- Paket 2 -->
                <div class="bg-white shadow rounded-xl overflow-hidden">
                    <img src="https://source.unsplash.com/600x400/?food" class="w-full h-48 object-cover">
                    <div class="p-4 text-left">
                        <h3 class="font-semibold text-lg">Paket Wisata Kuliner Nusantara</h3>
                        <p class="text-gray-600 text-sm mt-1">
                            Nikmati cita rasa kuliner tradisional khas Kauman!
                        </p>
                        <p class="font-bold mt-3">Rp 200.000</p>
                        <a href="#" class="mt-3 inline-block px-4 py-2 bg-black text-white rounded-lg text-sm">Lihat Detail</a>
                    </div>
                </div>

                <!-- Paket 3 -->
                <div class="bg-white shadow rounded-xl overflow-hidden">
                    <img src="https://source.unsplash.com/600x400/?village" class="w-full h-48 object-cover">
                    <div class="p-4 text-left">
                        <h3 class="font-semibold text-lg">Paket Heritage Walking Tour</h3>
                        <p class="text-gray-600 text-sm mt-1">
                            Menelusuri sejarah Kauman dengan berjalan kaki.
                        </p>
                        <p class="font-bold mt-3">Rp 150.000</p>
                        <a href="#" class="mt-3 inline-block px-4 py-2 bg-black text-white rounded-lg text-sm">Lihat Detail</a>
                    </div>
                </div>

            </div>

            <a href="#" class="mt-10 inline-block px-5 py-2 border rounded-lg text-gray-700 hover:bg-gray-100 transition">
                Lihat Semua Paket
            </a>
        </div>
    </section>

    <!-- ARTIKEL TERBARU -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6 text-center">

            <h2 class="text-2xl font-bold mb-3">Artikel Terbaru</h2>
            <p class="text-gray-600 mb-10">Baca cerita dan tips wisata dari kami</p>

            <div class="grid md:grid-cols-3 gap-6">

                <!-- Artikel 1 -->
                <div class="bg-white shadow rounded-xl overflow-hidden text-left">
                    <img src="https://source.unsplash.com/600x400/?culture" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg">Sejarah Kampung Kauman</h3>
                        <p class="text-gray-600 text-sm mt-1">
                            Kenali akar budaya dan warisan Kauman yang kaya.
                        </p>
                    </div>
                </div>

                <!-- Artikel 2 -->
                <div class="bg-white shadow rounded-xl overflow-hidden text-left">
                    <img src="https://source.unsplash.com/600x400/?batik" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg">5 Motif Batik Khas Kauman</h3>
                        <p class="text-gray-600 text-sm mt-1">
                            Motif batik legendaris yang wajib kamu tahu!
                        </p>
                    </div>
                </div>

                <!-- Artikel 3 -->
                <div class="bg-white shadow rounded-xl overflow-hidden text-left">
                    <img src="https://source.unsplash.com/600x400/?cooking" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-lg">Tips Wisata Kuliner Kauman</h3>
                        <p class="text-gray-600 text-sm mt-1">
                            Rekomendasi makanan tradisional terbaik!
                        </p>
                    </div>
                </div>

            </div>

            <a href="#" class="mt-10 inline-block px-5 py-2 border rounded-lg text-gray-700 hover:bg-gray-100 transition">
                Baca Artikel Lainnya
            </a>

        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="bg-gradient-to-b from-[#592300] to-[#7a3b00] text-white py-16 mt-16 text-center px-6">
        <h2 class="text-2xl font-bold mb-3">Siap Menjelajahi Kampung Kauman?</h2>
        <p class="text-gray-200 mb-6">Pesan paket wisata Anda sekarang dan dapatkan pengalaman tak terlupakan.</p>

        <a href="#" class="px-6 py-3 bg-white text-[#592300] font-semibold rounded-lg shadow hover:bg-gray-200 transition">
            Pesan Sekarang
        </a>
    </section>

</body>
</html>
