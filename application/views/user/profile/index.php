<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Profil Saya</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
<style>
/* ================= ANIMASI Latar ================= */
.animated-bg {
    background: linear-gradient(270deg, #dbeafe, #d1fae5, #ccfbf1);
    background-size: 400% 400%;
    animation: gradientMove 16s ease infinite;
}
@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
</style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center animated-bg px-4 py-8">

<!-- Tombol kembali di atas -->
<div class="w-full max-w-md mb-4">
    <a href="<?= site_url('user/dashboard') ?>" 
       class="text-sm text-[#592300] hover:underline">
        ← Kembali ke dashboard
    </a>
</div>

<?php $foto = !empty($user->foto) ? $user->foto : 'default.png'; ?>

<!-- ================= CARD PROFIL ================= -->
<div class="w-full max-w-md bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg px-8 py-8">
    <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Profil Saya</h1>

    <!-- FLASH MESSAGES -->
    <?php if($this->session->flashdata('success')): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm text-center">
            <?= htmlspecialchars($this->session->flashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('error')): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm text-center">
            <?= htmlspecialchars($this->session->flashdata('error')) ?>
        </div>
    <?php endif; ?>

    <!-- Foto di tengah -->
    <div class="flex flex-col items-center mb-6">
        <img src="<?= base_url('uploads/profile/'.$foto) ?>" 
             alt="Foto Profil" 
             class="w-28 h-28 rounded-full object-cover border shadow-md mb-2">

        <button onclick="openPhotoModal()"
                class="text-xs px-3 py-1 rounded border text-emerald-600 hover:bg-emerald-50 transition">
            Ganti Foto
        </button>
    </div>

    <!-- Info profil rata kiri -->
    <div class="flex flex-col space-y-3 text-gray-800 text-sm">
        <div>
            <p class="text-gray-500">Nama</p>
            <p class="font-semibold"><?= htmlspecialchars($user->nama ?? '-') ?></p>
        </div>

        <div>
            <p class="text-gray-500">Email</p>
            <p class="font-semibold"><?= htmlspecialchars($user->email) ?></p>
        </div>

        <div>
            <p class="text-gray-500">No HP</p>
            <p class="font-semibold"><?= htmlspecialchars($user->no_hp ?? '-') ?></p>
        </div>

        <div>
            <p class="text-gray-500">Bergabung</p>
            <p class="font-semibold"><?= date('d M Y', strtotime($user->created_at)) ?></p>
        </div>
    </div>

    <!-- Tombol Edit -->
    <div class="flex flex-col gap-3 mt-6">
        <button onclick="openProfileModal()"
                class="w-full py-3 rounded-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-emerald-500 hover:opacity-90 transition">
            Edit Profil
        </button>
        <button onclick="openPasswordModal()"
                class="w-full py-3 rounded-lg font-semibold border hover:bg-gray-100 transition">
            Ganti Password
        </button>
    </div>
</div>

<!-- ================= MODAL PROFIL ================= -->
<div id="profileModal" class="fixed inset-0 hidden z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50" onclick="closeProfileModal()"></div>
    <div class="relative z-10 w-full max-w-md bg-white rounded-2xl p-6">
        <h2 class="text-lg font-bold mb-2 text-center text-gray-800">Edit Profil</h2>
        <!-- Keterangan -->
        <p class="text-sm text-gray-500 mb-4 text-center">
            Ubah nama dan nomor HP Anda. Email tidak dapat diubah.
        </p>
        <form action="<?= site_url('user/profile/update_profile') ?>" method="post" class="space-y-4">
            <input type="text" name="nama" required
                   value="<?= htmlspecialchars($user->nama ?? '') ?>"
                   class="w-full h-10 px-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            <input type="text" name="no_hp"
                   value="<?= htmlspecialchars($user->no_hp ?? '') ?>"
                   class="w-full h-10 px-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            <div class="flex gap-2 pt-4">
                <button type="button" onclick="closeProfileModal()"
                        class="w-1/2 border rounded-lg py-2 hover:bg-gray-100 transition">
                    Batal
                </button>
                <button class="w-1/2 bg-blue-600 text-white rounded-lg py-2 hover:opacity-90 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL PASSWORD ================= -->
<div id="passwordModal" class="fixed inset-0 hidden z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50" onclick="closePasswordModal()"></div>
    <div class="relative z-10 w-full max-w-md bg-white rounded-2xl p-6">
        <h2 class="text-lg font-bold mb-2 text-center text-gray-800">Ganti Password</h2>
        <!-- Keterangan -->
        <p class="text-sm text-gray-500 mb-4 text-center">
            Masukkan password baru minimal 6 karakter dan konfirmasi password.
        </p>
        <form action="<?= site_url('user/profile/update_password') ?>" method="post" class="space-y-4">
            <input type="password" name="password" required placeholder="Password baru"
                   class="w-full h-10 px-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400">
            <input type="password" name="password_confirm" required placeholder="Konfirmasi password"
                   class="w-full h-10 px-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400">
            <div class="flex gap-2 pt-4">
                <button type="button" onclick="closePasswordModal()"
                        class="w-1/2 border rounded-lg py-2 hover:bg-gray-100 transition">
                    Batal
                </button>
                <button class="w-1/2 bg-red-600 text-white rounded-lg py-2 hover:opacity-90 transition">
                    Ubah
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL FOTO ================= -->
<div id="photoModal" class="fixed inset-0 hidden z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50" onclick="closePhotoModal()"></div>
    <div class="relative z-10 w-full max-w-sm bg-white rounded-2xl p-6 text-center">
        <h2 class="text-lg font-bold mb-2 text-gray-800">Ganti Foto</h2>
        <!-- Keterangan -->
        <p class="text-sm text-gray-500 mb-4">
            Pilih foto baru maksimal 2 MB. Format yang diperbolehkan: JPG, JPEG, PNG.
        </p>
        <form action="<?= site_url('user/profile/update_photo') ?>" method="post" enctype="multipart/form-data" class="space-y-4">
            <img id="photoPreview" src="<?= base_url('uploads/profile/'.$foto) ?>" class="w-28 h-28 rounded-full mx-auto object-cover mb-2">
            <input type="file" name="foto" accept="image/*" required onchange="previewPhoto(this)"
                   class="w-full text-sm">
            <div class="flex gap-2 pt-4">
                <button type="button" onclick="closePhotoModal()"
                        class="w-1/2 border rounded-lg py-2 hover:bg-gray-100 transition">
                    Batal
                </button>
                <button class="w-1/2 bg-emerald-600 text-white rounded-lg py-2 hover:opacity-90 transition">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>


<script>
const profileModal  = document.getElementById('profileModal');
const passwordModal = document.getElementById('passwordModal');
const photoModal    = document.getElementById('photoModal');
const photoPreview  = document.getElementById('photoPreview');

function openProfileModal() { profileModal.classList.remove('hidden'); }
function closeProfileModal() { profileModal.classList.add('hidden'); }
function openPasswordModal() { passwordModal.classList.remove('hidden'); }
function closePasswordModal() { passwordModal.classList.add('hidden'); }
function openPhotoModal() { photoModal.classList.remove('hidden'); }
function closePhotoModal() { photoModal.classList.add('hidden'); }

function previewPhoto(input){
    const file = input.files[0];
    if(!file) return;
    if(file.size > 2 * 1024 * 1024){
        alert('Ukuran maksimal 2 MB');
        input.value = '';
        return;
    }
    const reader = new FileReader();
    reader.onload = e => { photoPreview.src = e.target.result; };
    reader.readAsDataURL(file);
}
</script>

</body>
</html>
