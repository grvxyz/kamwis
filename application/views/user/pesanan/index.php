<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Reservasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#F4F8FB]">

<?php $this->load->view('partials/header'); ?>
<?php if (!empty($pesanan)) : ?>
    <?php foreach ($pesanan as $row) : ?>

        <div class="card mb-3">
            <div class="card-body">

                <h5><?= $row->nama_paket ?></h5>

                <span class="badge bg-warning">
                    <?= ucfirst($row->status) ?>
                </span>

                <small class="d-block text-muted">
                    <?= date('d M Y', strtotime($row->tanggal)) ?> •
                    Kode: <?= $row->kode_booking ?>
                </small>

                <strong>
                    Total: Rp <?= number_format($row->total, 0, ',', '.') ?>
                </strong>

                <div class="mt-2">
                    <a href="<?= base_url('user/pesanan/detail/'.$row->id_pesanan) ?>"
                       class="btn btn-outline-primary btn-sm">
                        Detail
                    </a>
                </div>

            </div>
        </div>

    <?php endforeach; ?>
<?php else : ?>
    <div class="alert alert-info">
        Belum ada pesanan.
    </div>
<?php endif; ?>
