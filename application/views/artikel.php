<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Artikel & Berita</title>
    <meta name="description" content="Kumpulan artikel dan berita terbaru. Informasi, tips, dan wawasan menarik.">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Optional: Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- ================= CONTAINER ================= -->
<div class="max-w-5xl mx-auto px-4 py-10">

    <!-- ================= HEADER ================= -->
    <header class="mb-10">
        <h1 class="text-3xl font-bold mb-2">Artikel & Berita</h1>
        <p class="text-gray-600">
            Temukan artikel terbaru seputar informasi, tips, dan insight menarik.
        </p>
    </header>

    <!-- ================= LIST ARTIKEL ================= -->
    <?php if(!empty($artikel)): ?>
        <div class="grid md:grid-cols-2 gap-6">

            <?php foreach($artikel as $a): ?>
            <article class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                <!-- FOTO -->
                <?php if($a->foto): ?>
                    <img src="<?= base_url('uploads/artikel/'.$a->foto) ?>"
                         alt="<?= $a->judul ?>"
                         class="w-full h-48 object-cover">
                <?php endif; ?>

                <!-- CONTENT -->
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">
                        <a href="<?= site_url('artikel/'.$a->slug) ?>"
                           class="hover:text-orange-600 transition">
                           <?= $a->judul ?>
                        </a>
                    </h2>

                    <p class="text-sm text-gray-500 mb-3">
                        Dipublikasikan <?= date('d M Y', strtotime($a->created_at)) ?>
                    </p>

                    <p class="text-gray-700 text-sm leading-relaxed line-clamp-3">
                        <?= strip_tags(substr($a->isi, 0, 180)) ?>...
                    </p>

                    <a href="<?= site_url('artikel/'.$a->slug) ?>"
                       class="inline-block mt-4 text-sm text-orange-600 hover:underline font-medium">
                       Baca Selengkapnya →
                    </a>
                </div>
            </article>
            <?php endforeach; ?>

        </div>
    <?php else: ?>
        <div class="text-center py-20 text-gray-500">
            Belum ada artikel yang dipublikasikan.
        </div>
    <?php endif; ?>

</div>

</body>
</html>
