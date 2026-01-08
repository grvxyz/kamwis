<header class="w-full bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- LOGO -->
        <div class="flex items-center gap-3">
            <img src="<?= base_url('uploads/logo/logo kamwis.png'); ?>" class="h-10">
            <span class="text-blue-600 font-bold text-lg">
                Kampung Wisata Kauman
            </span>
        </div>

        <!-- NAV DESKTOP -->
        <nav class="hidden md:flex gap-8">
            <a href="<?= base_url('welcome'); ?>" class="nav-link active">Beranda</a>
            <a href="<?= base_url('welcome/tentang_kami'); ?>" class="nav-link">Tentang Kami</a>
            <a href="<?= base_url('welcome/paket_wisata'); ?>" class="nav-link">Paket Wisata</a>
            <a href="<?= base_url('index'); ?>" class="nav-link">Artikel</a>

            <!-- PESANAN (ALERT) -->
            <a href="javascript:void(0)" onclick="loginAlert()" class="nav-link">
                Pesanan Saya
            </a>
        </nav>

        <!-- AUTH BUTTON -->
        <div class="hidden md:flex gap-3">
            <a href="<?= base_url('auth/login'); ?>"
               class="px-5 py-2 rounded-full border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition">
                Masuk
            </a>

            <a href="<?= base_url('auth/register'); ?>"
               class="px-5 py-2 rounded-full text-white font-medium bg-gradient-to-r from-blue-600 to-green-600 hover:opacity-90 transition">
                Daftar
            </a>
        </div>

        <!-- MOBILE -->
        <button onclick="toggleMobileMenu()" class="md:hidden text-2xl text-blue-600">☰</button>
    </div>

    <!-- MOBILE MENU -->
    <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
        <a href="<?= base_url('welcome'); ?>" class="block px-6 py-3">Beranda</a>
        <a href="<?= base_url('tentang_kami'); ?>" class="block px-6 py-3">Tentang Kami</a>
        <a href="<?= base_url('paket_wisata'); ?>" class="block px-6 py-3">Paket Wisata</a>
        <a href="<?= base_url('index'); ?>" class="block px-6 py-3">Artikel</a>

        <a href="javascript:void(0)" onclick="loginAlert()"
           class="block px-6 py-3 border-t">
            Pesanan Saya
        </a>
    </div>
</header>

<script>
function toggleMobileMenu() {
    document.getElementById('mobileMenu').classList.toggle('hidden');
}

function loginAlert() {
    alert('Silakan login terlebih dahulu untuk melihat pesanan Anda.');
    window.location.href = "<?= base_url('auth/login'); ?>";
}
</script>
