<main class="flex-1 p-8 bg-gray-50">

    <!-- WELCOME -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="mb-6">
            <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl">
                Selamat datang,
                <span class="font-semibold">
                    <?= $this->session->userdata('nama') ?>
                </span>
                di panel admin Kampung Wisata Kauman 👋
            </div>
        </div>
    <?php endif; ?>

    <!-- HEADER -->
    <div class="mb-8">
    <h1 class="text-2xl font-bold">Dashboard Admin</h1>
    <p class="text-gray-500 mt-1">
        Selamat datang,
        <span class="font-semibold">
            <?= $this->session->userdata('nama') ?>
        </span>
        di panel admin Kampung Wisata Kauman
    </p>
</div>


    <!-- STAT CARD GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Total Pengguna</p>
            <h2 class="text-3xl font-bold mt-2"><?= $total_users ?></h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Total Paket Wisata</p>
            <h2 class="text-3xl font-bold mt-2"><?= $total_paket ?></h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Total Artikel</p>
            <h2 class="text-3xl font-bold mt-2"><?= $total_artikel ?></h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Total Reservasi</p>
            <h2 class="text-3xl font-bold mt-2"><?= $total_reservasi ?></h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Reservasi Pending</p>
            <h2 class="text-3xl font-bold mt-2"><?= $pending ?></h2>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Total Pendapatan</p>
            <h2 class="text-2xl font-bold mt-2">
                Rp <?= number_format($pendapatan, 0, ',', '.') ?>
            </h2>
        </div>

    </div>

    <!-- RESERVASI TERBARU -->
<div class="bg-white p-6 rounded-xl shadow">
    <h2 class="text-xl font-bold mb-6">Reservasi Terbaru</h2>

    <?php if(empty($reservasi)): ?>
        <p class="text-gray-500 text-sm">Belum ada reservasi.</p>
    <?php endif; ?>

    <?php foreach ($reservasi as $r): ?>
        <div class="flex justify-between items-center border-b py-4 last:border-0">

            <div>
                <!-- NAMA USER -->
                <p class="font-semibold">
                    <?= $r->nama_user ?>
                </p>

                <!-- NAMA PAKET -->
                <p class="text-sm text-gray-500">
                    <?= $r->nama_paket ?>
                </p>

                <!-- TANGGAL & JUMLAH -->
                <p class="text-xs text-gray-400">
                    <?= date('d/m/Y', strtotime($r->tanggal_kunjungan)) ?>
                    • <?= $r->jumlah_peserta ?> peserta
                </p>
            </div>

            <div class="text-right">
                <!-- STATUS -->
                <?php if ($r->status == 'Selesai'): ?>
                    <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs">
                        Selesai
                    </span>
                <?php elseif ($r->status == 'Pending'): ?>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs">
                        Menunggu
                    </span>
                <?php else: ?>
                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs">
                        Dikonfirmasi
                    </span>
                <?php endif; ?>

                <!-- TOTAL -->
                <p class="font-bold mt-2 text-sm">
                    Rp <?= number_format($r->total_harga, 0, ',', '.') ?>
                </p>
            </div>

        </div>
    <?php endforeach; ?>
</div>
