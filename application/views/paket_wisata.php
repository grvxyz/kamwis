<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Paket Wisata</title>

    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- BOOTSTRAP -->
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
            transition: transform .2s ease;
        }
        .paket-card:hover {
            transform: translateY(-4px);
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
            color: #000;
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
            font-weight: 500;
        }
        .detail-btn:hover {
            opacity: 0.85;
        }
        .star {
            color: #e5e7eb;
            font-size: 14px;
        }
        .star.active {
            color: #ffb300;
        }
    </style>
</head>

<body>

<!-- ================= HEADER ================= -->
<?php $this->load->view('partials/header-awal'); ?>

<!-- ================= HERO ================= -->
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

<!-- ================= LIST PAKET ================= -->
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
                        <?php if(!empty($p->kategori)): ?>
                            <span class="badge-kategori"><?= $p->kategori ?></span>
                        <?php endif; ?>

                        <div class="p-3">

                            <!-- Nama Paket -->
                            <h5 class="fw-bold mb-1"><?= $p->nama_paket ?></h5>

                            <!-- Rating -->
                            <div class="d-flex align-items-center gap-1 mb-2">
                                <?php
                                    $rating = round($p->rating ?? 0);
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<span class="star active">★</span>';
                                        } else {
                                            echo '<span class="star">★</span>';
                                        }
                                    }
                                ?>
                                <span class="text-muted small ms-1">
                                    <?= number_format($p->rating ?? 0, 1) ?>
                                </span>
                            </div>

                            <!-- Deskripsi -->
                            <p class="text-muted small">
                                <?= word_limiter(strip_tags($p->deskripsi), 20) ?>
                            </p>

                            <!-- Info -->
                            <div class="d-flex justify-content-between mb-2 small text-muted">
                                <?php if(!empty($p->durasi)): ?>
                                    <span><?= $p->durasi ?> Jam</span>
                                <?php endif; ?>

                                <?php if(!empty($p->max_orang)): ?>
                                    <span>Max <?= $p->max_orang ?> orang</span>
                                <?php endif; ?>
                            </div>

                            <!-- Harga -->
                            <h5 class="text-danger fw-bold mb-3">
                                Rp <?= number_format($p->harga, 0, ',', '.') ?>
                            </h5>

                            <!-- Button -->
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
