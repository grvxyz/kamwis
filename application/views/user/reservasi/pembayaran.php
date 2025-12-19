<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Reservasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Anime.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    <!-- MIDTRANS SNAP -->
    <script 
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-xxxxxxxxxxxx">
    </script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-green-50 min-h-screen">

<?php $this->load->view('partials/header'); ?>

<!-- ================= CARD ================= -->
<div id="payment-card"
     class="max-w-xl mx-auto mt-14 bg-white p-6 sm:p-8 rounded-2xl shadow-lg">

    <!-- ICON -->
    <div class="flex justify-center mb-4">
        <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-8 w-8 text-green-600"
                 fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8c-1.657 0-3 .895-3 2v2c0 1.105 1.343 2 3 2s3-.895 3-2v-2c0-1.105-1.343-2-3-2z" />
            </svg>
        </div>
    </div>

    <!-- TITLE -->
    <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800 mb-2">
        Pembayaran Reservasi
    </h2>

    <p class="text-sm text-center text-gray-500 mb-6">
        Silakan selesaikan pembayaran untuk mengonfirmasi reservasi Anda
    </p>

    <!-- INFO -->
    <div class="space-y-2 text-sm bg-gray-50 rounded-xl p-4 mb-6">
        <div class="flex justify-between">
            <span class="text-gray-500">ID Reservasi</span>
            <span class="font-semibold"><?= $reservasi->id_reservasi ?></span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Total Bayar</span>
            <span class="font-bold text-green-600">
                Rp <?= number_format($reservasi->total_harga,0,',','.') ?>
            </span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Status</span>
            <span class="px-3 py-1 rounded-full text-xs font-semibold
            <?= $reservasi->payment_status == 'settlement'
                ? 'bg-green-100 text-green-700'
                : 'bg-yellow-100 text-yellow-700' ?>">
                <?= ucfirst($reservasi->payment_status ?? 'pending') ?>
            </span>
        </div>
    </div>

    <!-- BUTTON -->
    <button id="pay-button"
            class="w-full bg-gradient-to-r from-green-600 to-emerald-500
                   text-white py-3 rounded-xl font-semibold
                   hover:opacity-90 active:scale-95 transition">
        Bayar Sekarang
    </button>

    <a href="<?= site_url('user/reservasi/riwayat') ?>"
       class="block text-center mt-4 text-sm text-gray-500 hover:text-gray-700">
        Bayar nanti
    </a>

</div>

<!-- ================= JS ================= -->
<script>
// ANIMASI MASUK
anime({
    targets: '#payment-card',
    opacity: [0, 1],
    translateY: [40, 0],
    duration: 800,
    easing: 'easeOutExpo'
});

// BUTTON CLICK EFFECT
document.getElementById('pay-button').addEventListener('mouseenter', () => {
    anime({
        targets: '#pay-button',
        scale: 1.03,
        duration: 200,
        easing: 'easeOutQuad'
    });
});

document.getElementById('pay-button').addEventListener('mouseleave', () => {
    anime({
        targets: '#pay-button',
        scale: 1,
        duration: 200,
        easing: 'easeOutQuad'
    });
});

// MIDTRANS
document.getElementById('pay-button').onclick = function () {

    snap.pay("<?= $_GET['token'] ?>", {

        onSuccess: function(result){
            window.location.href = "<?= site_url('user/reservasi/riwayat') ?>";
        },

        onPending: function(result){
            window.location.href = "<?= site_url('user/reservasi/riwayat') ?>";
        },

        onError: function(result){
            alert("Pembayaran gagal");
            console.log(result);
        },

        onClose: function(){
            alert("Pembayaran belum diselesaikan");
        }
    });
};
</script>

</body>
</html>
