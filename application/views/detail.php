<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $artikel->meta_title ?: $artikel->judul ?></title>
    <meta name="description" content="<?= $artikel->meta_description ?>">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Typography -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    typography: {
                        DEFAULT: {
                            css: {
                                color: '#374151',
                                lineHeight: '1.9',
                                p: {
                                    marginTop: '1.25em',
                                    marginBottom: '1.25em',
                                },
                                h2: {
                                    marginTop: '2em',
                                    marginBottom: '0.8em',
                                    fontWeight: '700',
                                    color: '#111827',
                                },
                                h3: {
                                    marginTop: '1.6em',
                                    marginBottom: '0.6em',
                                    fontWeight: '600',
                                    color: '#1f2937',
                                },
                                ul: {
                                    marginTop: '1em',
                                    marginBottom: '1em',
                                },
                                li: {
                                    marginTop: '0.5em',
                                    marginBottom: '0.5em',
                                },
                                blockquote: {
                                    borderLeftWidth: '4px',
                                    borderLeftColor: '#3b82f6',
                                    backgroundColor: '#eff6ff',
                                    padding: '1em',
                                    fontStyle: 'normal',
                                },
                                a: {
                                    color: '#2563eb',
                                    textDecoration: 'underline',
                                    '&:hover': {
                                        color: '#1d4ed8',
                                    },
                                },
                            }
                        }
                    }
                }
            },
            plugins: [tailwindcssTypography],
        }
    </script>

    <style>
        /* Skeleton */
        .skeleton {
            background: linear-gradient(
                90deg,
                #e5e7eb 25%,
                #f3f4f6 37%,
                #e5e7eb 63%
            );
            background-size: 400% 100%;
            animation: shimmer 1.4s ease infinite;
        }

        @keyframes shimmer {
            0% { background-position: 100% 0 }
            100% { background-position: -100% 0 }
        }

        /* Reveal */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all .8s ease;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-50 to-slate-100 text-gray-800">
<?php $this->load->view('partials/header-awal'); ?>
<!-- ================= SKELETON ================= -->
<div id="skeleton" class="max-w-3xl mx-auto px-6 py-16 space-y-6">
    <div class="h-10 w-3/4 rounded skeleton"></div>
    <div class="h-64 w-full rounded-xl skeleton"></div>
    <div class="space-y-3">
        <div class="h-4 w-full rounded skeleton"></div>
        <div class="h-4 w-11/12 rounded skeleton"></div>
        <div class="h-4 w-10/12 rounded skeleton"></div>
    </div>
</div>

<!-- ================= CONTENT ================= -->
<main id="content" class="hidden">

<article class="max-w-3xl mx-auto px-6 py-16 reveal">

    <div class="bg-white/80 backdrop-blur-xl border border-white/50
                rounded-3xl shadow-xl p-8 md:p-10">

        <!-- JUDUL -->
        <h1 class="text-3xl md:text-4xl font-bold leading-tight mb-6 text-gray-900">
            <?= $artikel->judul ?>
        </h1>

        <!-- META -->
        <div class="text-sm text-gray-500 mb-8">
            Dipublikasikan • <?= date('d F Y') ?>
        </div>

        <!-- FOTO -->
        <?php if($artikel->foto): ?>
            <img src="<?= base_url('uploads/artikel/'.$artikel->foto) ?>"
                 class="w-full rounded-2xl mb-10 shadow-md object-cover">
        <?php endif ?>

        <!-- ISI ARTIKEL -->
        <div class="prose prose-slate prose-lg max-w-none">
    <?= nl2br(htmlspecialchars($artikel->isi)) ?>
</div>


    </div>

</article>

</main>

<!-- ================= SCRIPT ================= -->
<script>
/* Skeleton Loader */
window.addEventListener('load', () => {
    setTimeout(() => {
        document.getElementById('skeleton').style.display = 'none';
        document.getElementById('content').classList.remove('hidden');
    }, 800);
});

/* Scroll Reveal */
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if(entry.isIntersecting){
            entry.target.classList.add('active');
        }
    });
}, { threshold: 0.2 });

document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>

</body>
</html>
