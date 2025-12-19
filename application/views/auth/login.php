<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Kampung Wisata Kauman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ANIMATION STYLE -->
    <style>
        /* Animated background gradient */
        .animated-bg {
            background: linear-gradient(
                270deg,
                #dbeafe, /* blue-100 */
                #d1fae5, /* emerald-100 */
                #ccfbf1, /* teal-200 */
                #dbeafe
            );
            background-size: 600% 600%;
            animation: gradientMove 18s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating decor animation */
        .float-slow {
            animation: float 10s ease-in-out infinite;
        }
        .float-slower {
            animation: float 14s ease-in-out infinite;
        }

        @keyframes float {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-30px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center animated-bg px-4 relative overflow-hidden">

<!-- BACKGROUND DECOR -->
<div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-300/30 rounded-full blur-3xl float-slow"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-emerald-300/30 rounded-full blur-3xl float-slower"></div>
</div>

<!-- CARD -->
<div class="relative w-full max-w-md bg-white/70 backdrop-blur-xl rounded-3xl shadow-2xl p-8 sm:p-10">

    <!-- LOGO -->
    <div class="flex flex-col items-center mb-6">
        <img src="<?= base_url('uploads/logo/logo kamwis.png'); ?>"
             class="w-16 h-16 object-contain mb-3">
        <h1 class="text-lg font-bold text-gray-800 text-center">
            Kampung Wisata Kauman
        </h1>
        <p class="text-sm text-gray-500 text-center">
            Sistem Informasi Wisata
        </p>
    </div>

    <h2 class="text-2xl font-bold text-gray-800 mb-1 text-center">
        Selamat Datang
    </h2>
    <p class="text-sm text-gray-600 text-center mb-6">
        Silakan login untuk melanjutkan
    </p>

    <!-- FLASH ERROR -->
    <?php if ($this->session->flashdata('error')) : ?>
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm text-center">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('auth/login_process') ?>" method="post" class="space-y-4">

        <!-- EMAIL -->
        <div>
            <label class="text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" required
                   placeholder="contoh@email.com"
                   class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-300
                          bg-white/80 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <!-- PASSWORD -->
        <!-- PASSWORD -->
<div>
    <label class="text-sm font-medium text-gray-700">Password</label>
    <div class="relative mt-1">
        <input type="password" id="password" name="password" required
               placeholder="Masukkan password"
               class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-300
                      bg-white/80 focus:ring-2 focus:ring-emerald-500 focus:outline-none">

        <!-- TOGGLE EYE -->
        <button type="button"
                onclick="togglePassword()"
                class="absolute right-4 top-1/2 -translate-y-1/2
                       text-gray-500 hover:text-emerald-600 transition"
                aria-label="Toggle password">

            <!-- EYE OPEN -->
            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5
                         c4.478 0 8.268 2.943 9.542 7
                         -1.274 4.057-5.064 7-9.542 7
                         -4.477 0-8.268-2.943-9.542-7z" />
            </svg>

            <!-- EYE CLOSED -->
            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13.875 18.825A10.05 10.05 0 0112 19
                         c-4.478 0-8.268-2.943-9.543-7
                         a9.956 9.956 0 012.042-3.368" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6.223 6.223A9.957 9.957 0 0112 5
                         c4.478 0 8.268 2.943 9.543 7
                         a9.97 9.97 0 01-4.132 5.411" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 00-3-3" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3l18 18" />
            </svg>

        </button>
    </div>
</div>


        <!-- BUTTON -->
        <button type="submit"
                class="w-full py-3 mt-2 rounded-xl font-semibold text-white
                       bg-gradient-to-r from-blue-600 to-emerald-500
                       hover:shadow-lg hover:opacity-90 transition active:scale-95">
            Masuk
        </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-6">
        Belum punya akun?
        <a href="<?= site_url('auth/register'); ?>"
           class="text-blue-600 font-semibold hover:underline">
            Daftar
        </a>
    </p>

</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');

    if (input.type === 'password') {
        input.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
    } else {
        input.type = 'password';
        eyeClosed.classList.add('hidden');
        eyeOpen.classList.remove('hidden');
    }
}
</script>


</body>
</html>
