<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reservasi Paket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
<?php $this->load->view('partials/header'); ?>

<form action="<?= site_url('user/reservasi/simpan') ?>" method="post" onsubmit="return validasiPeserta()">
<input type="hidden" name="id_paket" value="<?= $paket->id_paket ?>">

<div class="max-w-6xl mx-auto py-6 sm:py-12 px-4 sm:px-6 grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- ================= KIRI ================= -->
    <div class="md:col-span-2 bg-white rounded-xl shadow p-4 sm:p-6">

        <h2 class="text-lg sm:text-xl font-bold mb-4">Paket Dipesan</h2>

        <div class="flex flex-col sm:flex-row gap-4">

            <img src="<?= base_url('uploads/paket/'.$paket->foto) ?>"
                 class="w-full sm:w-28 h-48 sm:h-28 object-cover rounded-lg">

            <div class="flex-1">
                <h3 class="font-semibold text-base sm:text-lg">
                    <?= $paket->nama_paket ?>
                </h3>

                <p class="text-xs sm:text-sm text-gray-500 mb-2">
                    <?= $paket->kategori ?>
                </p>

                <p class="text-xs sm:text-sm">Harga / orang</p>
                <p class="font-bold text-[#592300]">
                    Rp <?= number_format($paket->harga,0,',','.') ?>
                </p>

                <!-- JUMLAH PESERTA -->
                <div class="mt-4">
                    <label class="text-sm block mb-1">Jumlah Peserta</label>
                    <input type="number"
                           name="jumlah_peserta"
                           id="jumlah"
                           value="20"
                           min="20"
                           class="w-full sm:w-24 border rounded p-2 text-center"
                           onchange="hitungTotal()">

                    <p class="text-xs text-gray-500 mt-1">
                        Minimal 20 orang
                    </p>
                </div>

                <p class="mt-4 font-semibold">
                    Subtotal:
                    <span id="subtotal">
                        Rp <?= number_format($paket->harga * 20,0,',','.') ?>
                    </span>
                </p>
            </div>
        </div>
    </div>

    <!-- ================= KANAN ================= -->
    <div class="bg-white rounded-xl shadow p-4 sm:p-6">

        <h3 class="font-bold mb-4">Ringkasan Reservasi</h3>

        <label class="text-sm">Tanggal Kunjungan</label>
        <input type="date" name="tanggal_kunjungan" required
               class="w-full border rounded p-2 mb-4">

        <label class="text-sm">Jam Kunjungan</label>
        <input type="time" name="jam_kunjungan" required
               class="w-full border rounded p-2 mb-4">

        <div class="border-t pt-4">
            <div class="flex justify-between">
                <span>Total Harga</span>
                <span id="total" class="font-bold text-green-600">
                    Rp <?= number_format($paket->harga * 20,0,',','.') ?>
                </span>
            </div>
        </div>

        <button type="submit"
                class="w-full mt-6 bg-green-600 text-white py-3 rounded-lg font-semibold hover:opacity-90">
            Buat Reservasi
        </button>

        <a href="<?= site_url('user/paket') ?>"
           class="block text-center mt-4 text-sm text-gray-500">
            Lanjut pilih paket
        </a>
    </div>

</div>
</form>

<script>
const harga = <?= $paket->harga ?>;

function hitungTotal(){
    const jumlah = document.getElementById('jumlah').value;
    const total  = jumlah * harga;

    document.getElementById('subtotal').innerText =
        'Rp ' + total.toLocaleString('id-ID');

    document.getElementById('total').innerText =
        'Rp ' + total.toLocaleString('id-ID');
}

function validasiPeserta(){
    const jumlah = document.getElementById('jumlah').value;

    if(jumlah < 20){
        alert('Minimal pemesanan adalah 20 orang');
        return false;
    }
    return true;
}
</script>

</body>
</html>
