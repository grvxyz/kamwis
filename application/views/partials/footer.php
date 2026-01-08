<footer class="bg-white/70 backdrop-blur-lg text-gray-700 border-t border-gray-200">

  <div class="max-w-7xl mx-auto px-6 py-14
              grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4
              gap-10 lg:gap-12">

    <!-- LOGO & DESKRIPSI -->
    <div class="text-center sm:text-left">
      <div class="flex items-center justify-center sm:justify-start gap-3 mb-4">
        <img src="<?= base_url('uploads/logo/logo kamwis.png'); ?>" class="h-11 w-auto">
        <span class="font-semibold text-lg tracking-wide text-gray-800">
          Kampung Wisata Kauman
        </span>
      </div>
      <p class="text-sm leading-relaxed text-gray-600 max-w-md mx-auto sm:mx-0">
        Kampung Wisata Kauman adalah kampung bersejarah di Yogyakarta
        yang berdiri sejak 1773 di sekitar Masjid Gedhe Kauman dan
        dikenal sebagai living museum.
      </p>
    </div>

    <!-- MENU -->
    <div class="text-center sm:text-left">
      <h4 class="font-semibold mb-4 text-gray-800 tracking-wide">
        Menu
      </h4>
      <ul class="space-y-2 text-sm text-gray-600">
        <li><a href="<?= base_url('user/dashboard'); ?>" class="hover:text-gray-900 transition">Beranda</a></li>
        <li><a href="<?= base_url('user/tentang_kami'); ?>" class="hover:text-gray-900 transition">Tentang Kami</a></li>
        <li><a href="<?= base_url('user/paket'); ?>" class="hover:text-gray-900 transition">Paket Wisata</a></li>
        <li><a href="<?= base_url('artikel'); ?>" class="hover:text-gray-900 transition">Artikel</a></li>
      </ul>
    </div>

    <!-- KONTAK -->
    <div class="text-center sm:text-left">
      <h4 class="font-semibold mb-4 text-gray-800 tracking-wide">
        Informasi Kontak
      </h4>

      <ul class="space-y-3 text-sm text-gray-600">

        <li>
          <a href="https://www.google.com/maps/search/?api=1&query=Gg.+KH.+Zamhari,+Ngupasan,+Gondomanan,+Yogyakarta"
             target="_blank"
             class="flex items-start sm:items-center justify-center sm:justify-start gap-3 hover:text-gray-900 transition">
            <i class="bi bi-geo-alt-fill text-gray-500 mt-0.5 sm:mt-0"></i>
            <span>Gg. KH. Zamhari, Ngupasan, Gondomanan, Yogyakarta</span>
          </a>
        </li>

        <li>
          <a href="tel:+6285161813489"
             class="flex items-center justify-center sm:justify-start gap-3 hover:text-gray-900 transition">
            <i class="bi bi-telephone-fill text-gray-500"></i>
            <span>+62 851 6181 3489</span>
          </a>
        </li>

        <li>
          <a href="https://wa.me/6285161813489"
             target="_blank"
             class="group flex items-center justify-center sm:justify-start gap-3 hover:text-gray-900 transition">
            <i class="bi bi-whatsapp text-gray-500 group-hover:text-green-500"></i>
            <span>WhatsApp</span>
          </a>
        </li>

        <li>
          <a href="mailto:kamwis.kaumanjogja@gmail.com"
             class="flex items-center justify-center sm:justify-start gap-3 hover:text-gray-900 transition">
            <i class="bi bi-envelope-fill text-gray-500"></i>
            <span>kamwis.kaumanjogja@gmail.com</span>
          </a>
        </li>

      </ul>
    </div>

    <!-- JAM OPERASIONAL -->
    <div class="text-center sm:text-left">
      <h4 class="font-semibold mb-4 text-gray-800 tracking-wide">
        Jam Operasional
      </h4>
      <div class="bg-white/80 border border-gray-200 rounded-2xl p-4 text-sm space-y-2 shadow-sm max-w-sm mx-auto sm:mx-0">
        <div class="flex justify-between text-gray-700">
          <span>Shift Pagi</span>
          <span class="font-medium">07.00 – 11.00 WIB</span>
        </div>
        <div class="flex justify-between text-gray-700">
          <span>Shift Siang</span>
          <span class="font-medium">12.00 – 15.00 WIB</span>
        </div>
        <div class="flex justify-between text-gray-700">
          <span>Shift Sore</span>
          <span class="font-medium">15.00 – 17.00 WIB</span>
        </div>
      </div>
      <p class="text-xs text-gray-500 mt-3">
        *Jam operasional dapat berubah pada hari besar atau acara khusus.
      </p>
    </div>

  </div>

  <!-- COPYRIGHT -->
  <div class="border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-5 text-center text-sm text-gray-500">
      © <?= date('Y'); ?> Kampung Wisata Kauman Yogyakarta. All rights reserved.
    </div>
  </div>

</footer>
