<main class="flex-1 p-4 sm:p-6 md:p-8 overflow-x-auto bg-gray-50">

<!-- ================= HEADER ================= -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">
        Kelola Reservasi
    </h1>
    <p class="text-sm text-gray-500">
        Status reservasi dan pembayaran dikelola otomatis oleh sistem
    </p>
</div>

<!-- ================= TABLE CARD ================= -->
<div class="bg-white rounded-2xl shadow overflow-x-auto">

<table class="min-w-full text-sm">
<thead class="bg-gray-100 border-b text-gray-700">
<tr>
    <th class="px-4 py-3 text-left">User</th>
    <th class="px-4 py-3 text-left">Paket</th>
    <th class="px-4 py-3 text-left">Tanggal</th>
    <th class="px-4 py-3 text-left">Jam</th>
    <th class="px-4 py-3 text-center">Peserta</th>
    <th class="px-4 py-3 text-right">Total</th>
    <th class="px-4 py-3 text-left">Status Reservasi</th>
    <th class="px-4 py-3 text-left">Status Pembayaran</th>
    <th class="px-4 py-3 text-center">Aksi</th>
</tr>
</thead>

<tbody class="divide-y">

<?php if(!empty($reservasi)): ?>
<?php foreach($reservasi as $r): ?>

<?php
    $is_today = date('Y-m-d') === $r->tanggal_kunjungan;
?>

<tr class="hover:bg-gray-50 <?= $is_today ? 'bg-blue-50 border-l-4 border-blue-500' : '' ?>">

    <!-- USER -->
    <td class="px-4 py-3 font-medium">
        <?= $r->nama_user ?>
    </td>

    <!-- PAKET -->
    <td class="px-4 py-3">
        <?= $r->nama_paket ?>
    </td>

    <!-- TANGGAL -->
    <td class="px-4 py-3">
        <?= date('d M Y', strtotime($r->tanggal_kunjungan)) ?>
        <?php if($is_today): ?>
            <span class="ml-2 text-xs font-semibold text-blue-600">
                Hari Ini
            </span>
        <?php endif; ?>
    </td>

    <!-- JAM -->
    <td class="px-4 py-3">
        <?= date('H:i', strtotime($r->jam_kunjungan)) ?>
    </td>

    <!-- PESERTA -->
    <td class="px-4 py-3 text-center">
        <?= $r->jumlah_peserta ?>
    </td>

    <!-- TOTAL -->
    <td class="px-4 py-3 text-right font-semibold">
        Rp <?= number_format($r->total_harga,0,',','.') ?>
    </td>

    <!-- STATUS RESERVASI -->
    <td class="px-4 py-3">
        <?php if($r->payment_status == 'settlement'): ?>
            <span class="px-3 py-1 text-xs rounded-full font-semibold bg-green-100 text-green-700">
                Dikonfirmasi Otomatis
            </span>
        <?php else: ?>
            <span class="px-3 py-1 text-xs rounded-full font-semibold bg-yellow-100 text-yellow-700">
                Pending
            </span>
        <?php endif; ?>
    </td>

    <!-- STATUS PEMBAYARAN -->
    <td class="px-4 py-3">
        <span class="px-3 py-1 text-xs rounded-full
        <?= $r->payment_status=='settlement'?'bg-green-100 text-green-700':
           ($r->payment_status=='pending'?'bg-yellow-100 text-yellow-700':
           'bg-gray-100 text-gray-600') ?>">
            <?= ucfirst($r->payment_status ?? 'Belum Bayar') ?>
        </span>
    </td>

    <!-- AKSI (DINONAKTIFKAN TOTAL) -->
    <td class="px-4 py-3 text-center">
        <span class="text-xs text-gray-500 italic">
            Otomatis oleh sistem
        </span>
    </td>

</tr>

<?php endforeach; ?>
<?php else: ?>

<tr>
    <td colspan="9" class="py-14 text-center text-gray-500">
        <p class="font-medium">Belum ada data reservasi</p>
        <p class="text-sm text-gray-400 mt-1">
            Data akan muncul setelah pengguna melakukan pemesanan
        </p>
    </td>
</tr>

<?php endif; ?>

</tbody>
</table>
</div>

</main>
