<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register | Kampung Wisata Kauman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .animated-bg {
            background: linear-gradient(270deg,
                    #dbeafe,
                    #d1fae5,
                    #ccfbf1);
            background-size: 400% 400%;
            animation: gradientMove 16s ease infinite;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center animated-bg px-4">

    <!-- CARD -->
    <div class="w-full max-w-sm bg-white/80 backdrop-blur-lg
            rounded-2xl shadow-lg px-6 py-7">

        <!-- LOGO -->
        <div class="flex flex-col items-center mb-4">
            <img src="<?= base_url('uploads/logo/logo kamwis.png'); ?>" class="w-12 h-12 object-contain mb-2">
            <h1 class="text-base font-semibold text-gray-800">
                Kampung Wisata Kauman
            </h1>
            <p class="text-xs text-gray-500">
                Sistem Informasi Wisata
            </p>
        </div>

        <!-- TITLE -->
        <div class="text-center mb-5">
            <h2 class="text-xl font-bold text-gray-800">
                Buat Akun Baru
            </h2>
            <p class="text-xs text-gray-600 mt-1">
                Lengkapi data untuk mendaftar
            </p>
        </div>

        <!-- FORM -->
        <form action="<?= site_url('auth/register_process'); ?>" method="post" class="space-y-3">

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">
                    Nama Lengkap
                </label>
                <input type="text" name="nama" required class="w-full h-10 px-3 rounded-lg border border-gray-300
                          focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input type="email" name="email" required placeholder="contoh@email.com" class="w-full h-10 px-3 rounded-lg border border-gray-300
                          focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">
                    No HP
                </label>
                <input type="text" name="no_hp" required placeholder="08xxxxxxxxxx" class="w-full h-10 px-3 rounded-lg border border-gray-300
                          focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">
                    Password
                </label>
                <input type="password" name="password" required class="w-full h-10 px-3 rounded-lg border border-gray-300
                          focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">
                    Konfirmasi Password
                </label>
                <input type="password" name="password2" required class="w-full h-10 px-3 rounded-lg border border-gray-300
                          focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <button type="submit" class="w-full h-10 mt-3 rounded-lg font-semibold text-white
                       bg-gradient-to-r from-blue-600 to-emerald-500
                       hover:opacity-90 transition active:scale-95">
                Daftar
            </button>
        </form>

        <p class="text-center text-xs text-gray-600 mt-4">
            Sudah punya akun?
            <a href="<?= site_url('auth/login'); ?>" class="text-blue-600 font-semibold hover:underline">
                Login
            </a>
        </p>

    </div>

</body>

</html>