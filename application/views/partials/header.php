<style>
/* NAV LINK */
.nav-link {
    position: relative;
    text-decoration: none;
    color: #2563eb;
    font-size: 15px;
    font-weight: 500;
    padding-bottom: 6px;
    transition: color .3s;
}
.nav-link:hover {
    color: #16a34a;
}
.nav-link.active::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(to right, #2563eb, #16a34a);
    border-radius: 2px;
}
</style>

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
            <a href="<?= base_url('user/dashboard'); ?>"
               class="nav-link <?= ($this->uri->segment(2)=='dashboard')?'active':'' ?>">
                Beranda
            </a>

            <a href="<?= base_url('user/tentang_kami'); ?>"
               class="nav-link <?= ($this->uri->segment(2)=='tentang_kami')?'active':'' ?>">
                Tentang Kami
            </a>

            <a href="<?= base_url('user/paket'); ?>"
               class="nav-link <?= ($this->uri->segment(2)=='paket')?'active':'' ?>">
                Paket Wisata
            </a>

            <a href="<?= base_url('artikel'); ?>"
               class="nav-link <?= ($this->uri->segment(1)=='artikel')?'active':'' ?>">
                Artikel
            </a>

            <a href="<?= base_url('user/reservasi/riwayat'); ?>"
               class="nav-link <?= ($this->uri->segment(3)=='riwayat')?'active':'' ?>">
                Pesanan Saya
            </a>
        </nav>

        <!-- USER -->
        <div class="hidden md:flex items-center gap-4">
            <span class="text-gray-700">
                👤 <?= $this->session->userdata('nama'); ?>
            </span>

            <a href="<?= base_url('auth/logout'); ?>"
               class="px-5 py-2 rounded-full text-white font-medium
                      bg-gradient-to-r from-blue-600 to-green-600
                      hover:opacity-90 transition">
                Keluar
            </a>
        </div>

        <!-- MOBILE -->
        <button onclick="toggleMobileMenu()" class="md:hidden text-2xl text-blue-600">
            ☰
        </button>
    </div>

    <!-- MOBILE MENU -->
    <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
        <a href="<?= base_url('user/dashboard'); ?>" class="block px-6 py-3">Beranda</a>
        <a href="<?= base_url('user/tentang_kami'); ?>" class="block px-6 py-3">Tentang Kami</a>
        <a href="<?= base_url('user/paket'); ?>" class="block px-6 py-3">Paket Wisata</a>
        <a href="<?= base_url('artikel'); ?>" class="block px-6 py-3">Artikel</a>
        <a href="<?= base_url('user/reservasi/riwayat'); ?>" class="block px-6 py-3">Pesanan Saya</a>
        <a href="<?= base_url('auth/logout'); ?>"
           class="block px-6 py-3 text-red-600 font-medium border-t">
            Keluar
        </a>
    </div>
</header>

<script>
function toggleMobileMenu() {
    document.getElementById('mobileMenu').classList.toggle('hidden');
}
</script>
