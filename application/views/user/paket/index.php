<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Paket Wisata</title>

    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- BOOTSTRAP (UNTUK KONTEN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f6f6f6;
            font-family: "Inter", sans-serif;
        }
        .paket-card {
            border-radius: 12px;
            overflow: hidden;
            background: white;
            box-shadow: 0px 3px 7px rgba(0,0,0,0.1);
        }
        .paket-img {
            height: 180px;
            width: 100%;
            object-fit: cover;
        }
        .badge-kategori {
            position: absolute;
            background: #ffb300;
            padding: 5px 12px;
            top: 10px;
            right: 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }
        .detail-btn {
            background: #000;
            color: white;
            padding: 10px;
            border-radius: 8px;
            width: 100%;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        .detail-btn:hover {
            opacity: 0.85;
        }
        .rating {
            color: #ffb300;
        }
    </style>
</head>

<body>

<!-- ✅ HEADER -->
<?php $this->load->view('partials/header'); ?>

<!-- ✅ HERO (SAMA DENGAN TENTANG KAMI) -->
<div class="max-w-7xl mx-auto px-4 mt-6">

    <div class="bg-gradient-to-r from-blue-600 to-green-600 text-white
                px-8 py-10 rounded-[18px] text-center shadow-lg mb-6">

        <h3 class="text-2xl font-bold mb-2">
            Paket Wisata
        </h3>

        <p class="text-base opacity-95">
            Pilih paket wisata yang sesuai dengan minat dan kebutuhan Anda
        </p>

    </div>

</div>

<!-- LIST PAKET -->
<div class="container pb-5 mt-4">
    <div class="row g-4">

        <?php if(!empty($paket)): ?>
            <?php foreach ($paket as $p): ?>
                <div class="col-md-4">
                    <div class="paket-card position-relative">

                        <!-- Gambar -->
                        <img src="<?= base_url('uploads/paket/' . $p->foto) ?>"
                             class="paket-img"
                             alt="<?= $p->nama_paket ?>">

                        <!-- Badge kategori -->
                        <?php if($p->kategori): ?>
                            <span class="badge-kategori"><?= $p->kategori ?></span>
                        <?php endif; ?>

                        <div class="p-3">
                            <h5 class="fw-bold"><?= $p->nama_paket ?></h5>

                            <p class="text-muted small">
                                <?= word_limiter(strip_tags($p->deskripsi), 20) ?>
                            </p>

                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="rating">⭐ <?= number_format($p->rating, 1) ?></span>

                                <?php if($p->durasi): ?>
                                    <span class="text-muted"><?= $p->durasi ?> Jam</span>
                                <?php endif; ?>

                                <?php if($p->max_orang): ?>
                                    <span class="text-muted">Max <?= $p->max_orang ?> orang</span>
                                <?php endif; ?>
                            </div>

                            <h5 class="text-danger fw-bold mb-3">
                                Rp <?= number_format($p->harga, 0, ',', '.') ?>
                            </h5>

                            <a href="<?= site_url('user/paket/detail/' . $p->id_paket) ?>"
                               class="detail-btn">
                                Lihat Detail
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Paket wisata belum tersedia
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

</body>
</html>
