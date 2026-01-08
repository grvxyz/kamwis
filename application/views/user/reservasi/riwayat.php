<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Reservasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#F4F8FB]">

<?php $this->load->view('partials/header'); ?>

<div class="max-w-6xl mx-auto px-4 py-8">

    <!-- ================= JUDUL ================= -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Riwayat Reservasi
        </h1>
        <p class="text-sm text-gray-500">
            Daftar reservasi paket wisata yang pernah Anda buat
        </p>
    </div>

    <!-- ================= FILTER ================= -->
    <div class="mb-4 flex flex-wrap gap-3 items-center">
        <label class="text-sm text-gray-600 font-medium">
            Filter Status:
        </label>

        <select id="filterStatus"
            class="rounded-lg border px-4 py-2 text-sm focus:ring focus:ring-blue-200">
            <option value="all">Semua</option>
            <option value="Pending">Pending</option>
            <option value="Dikonfirmasi">Dikonfirmasi</option>
            <option value="Dibatalkan">Dibatalkan</option>
            <option value="Selesai">Selesai</option>
        </select>
    </div>

    <!-- ================= LIST (AJAX TARGET) ================= -->
    <div id="reservasiList">
        <?php $this->load->view('user/reservasi/_list', ['reservasi' => $reservasi]); ?>
    </div>

</div>

<script>
document.getElementById('filterStatus').addEventListener('change', function () {

    fetch("<?= site_url('user/reservasi/ajax_filter') ?>", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "status=" + this.value
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('reservasiList').innerHTML = html;
    })
    .catch(() => {
        alert('Gagal memuat data');
    });

});
</script>

</body>
</html>
