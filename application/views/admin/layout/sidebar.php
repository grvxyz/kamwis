<aside class="w-64 bg-white border-r p-6 flex flex-col">

    <!-- LOGO + TITLE -->
    <div class="mb-10 flex items-center gap-3">
        <img src="<?= base_url('uploads/logo/logo kamwis.png'); ?>"
             alt="Logo Kampung Kauman"
             class="w-10 h-10 object-contain">

        <div>
            <h2 class="text-lg font-bold leading-tight">Admin Panel</h2>
            <p class="text-sm text-gray-500">Kampung Kauman</p>
        </div>
    </div>

    <!-- MENU -->
    <nav class="flex flex-col gap-2 text-sm flex-1">

        <a href="<?= base_url('admin/dashboard') ?>"
           class="px-4 py-3 rounded-lg <?= uri_string()=='admin/dashboard'
           ? 'bg-orange-100 text-orange-700 font-semibold'
           : 'hover:bg-gray-100' ?>">
            Dashboard
        </a>

        <a href="<?= base_url('admin/user') ?>"
           class="px-4 py-3 rounded-lg <?= uri_string()=='admin/user'
           ? 'bg-orange-100 text-orange-700 font-semibold'
           : 'hover:bg-gray-100' ?>">
            Kelola Akun
        </a>

        <a href="<?= base_url('admin/paket/index') ?>" class="px-4 py-3 rounded-lg hover:bg-gray-100">Kelola Paket</a>
        <a href="<?= base_url('admin/artikel/index') ?>" class="px-4 py-3 rounded-lg hover:bg-gray-100">Kelola Artikel</a>
        <a href="<?= base_url('admin/event/index') ?>" class="px-4 py-3 rounded-lg hover:bg-gray-100">Kelola Event</a>
        <a href="<?= base_url('admin/galeri/index') ?>" class="px-4 py-3 rounded-lg hover:bg-gray-100">Kelola Galeri</a>
        <a href="<?= base_url('admin/reservasi/index') ?>" class="px-4 py-3 rounded-lg hover:bg-gray-100">Kelola Reservasi</a>
        <a href="<?= base_url('admin/laporan/index') ?>" class="px-4 py-3 rounded-lg hover:bg-gray-100">Laporan</a>
    </nav>

    <!-- LOGOUT -->
    <hr class="my-4">

    <a href="<?= base_url('auth/logout') ?>"
       onclick="return confirm('Yakin ingin logout?')"
       class="px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 font-semibold">
        Logout
    </a>

</aside>
