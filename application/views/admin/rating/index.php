<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Rating & Komentar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-7xl mx-auto bg-white rounded shadow p-5">

    <!-- JUDUL -->
    <h1 class="text-xl font-semibold mb-4">Data Rating & Komentar</h1>

    <!-- FLASH MESSAGE -->
    <?php if($this->session->flashdata('success')): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- ================= FILTER ================= -->
    <form onsubmit="return false;" class="grid grid-cols-1 md:grid-cols-5 gap-3 mb-5">

        <!-- Rating -->
        <select id="rating" class="border rounded p-2">
            <option value="">Semua Rating</option>
            <?php for($i=1;$i<=5;$i++): ?>
                <option value="<?= $i ?>"><?= $i ?> ⭐</option>
            <?php endfor; ?>
        </select>

        <!-- Search Nama Paket -->
        <input type="text"
               id="nama_paket"
               placeholder="Cari nama paket..."
               class="border rounded p-2">

        <!-- Tanggal -->
        <input type="date"
               id="tanggal"
               class="border rounded p-2">

        <!-- Urutan -->
        <select id="order" class="border rounded p-2">
            <option value="latest">Terbaru</option>
            <option value="oldest">Terlama</option>
        </select>
    </form>

    <!-- ================= TABEL ================= -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">ID Review</th>
                    <th class="border px-3 py-2">Paket</th>
                    <th class="border px-3 py-2">ID User</th>
                    <th class="border px-3 py-2 text-center">Rating</th>
                    <th class="border px-3 py-2">Komentar</th>
                    <th class="border px-3 py-2">Tanggal</th>
                    <th class="border px-3 py-2 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody id="ratingBody">
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        Memuat data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<!-- ================= JAVASCRIPT ================= -->
<script>
const ajaxUrl = "<?= site_url('admin/rating/ajax_list') ?>";

function loadRatings() {
    const rating     = document.getElementById('rating').value;
    const nama_paket = document.getElementById('nama_paket').value;
    const tanggal    = document.getElementById('tanggal').value;
    const order      = document.getElementById('order').value;

    const params = new URLSearchParams({
        rating: rating,
        nama_paket: nama_paket,
        tanggal: tanggal,
        order: order
    });

    fetch(ajaxUrl + '?' + params.toString(), {
        headers: { 'Accept': 'application/json' }
    })
    .then(res => {
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.json();
    })
    .then(data => {
        let html = '';

        if (!Array.isArray(data) || data.length === 0) {
            html = `
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        Data rating belum tersedia
                    </td>
                </tr>`;
        } else {
            data.forEach(r => {
                html += `
                <tr class="hover:bg-gray-50">
                    <td class="border px-3 py-2">${r.id_review}</td>
                    <td class="border px-3 py-2">
                        <span class="font-medium">${r.nama_paket ? r.nama_paket : '-'}</span>
                        <div class="text-xs text-gray-500">
                            ID: ${r.id_paket}
                        </div>
                    </td>
                    <td class="border px-3 py-2 text-center">${r.id_user}</td>
                    <td class="border px-3 py-2 text-center">
                        <span class="${r.rating <= 2 ? 'text-red-500' : 'text-yellow-500'}">
                            ${r.rating} ⭐
                        </span>
                    </td>
                    <td class="border px-3 py-2 max-w-md break-words">
                        ${escapeHtml(r.komentar)}
                    </td>
                    <td class="border px-3 py-2">
                        ${formatDate(r.created_at)}
                    </td>
                    <td class="border px-3 py-2 text-center">
                        <a href="<?= site_url('admin/rating/delete/') ?>${r.id_review}"
                           onclick="return confirm('Hapus rating ini?')"
                           class="text-red-600 hover:underline">
                           Hapus
                        </a>
                    </td>
                </tr>`;
            });
        }

        document.getElementById('ratingBody').innerHTML = html;
    })
    .catch(err => {
        console.error(err);
        document.getElementById('ratingBody').innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-4 text-red-500">
                    Gagal memuat data
                </td>
            </tr>`;
    });
}

// Anti XSS
function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
}

// Format tanggal Indonesia
function formatDate(dateStr) {
    const d = new Date(dateStr);
    return isNaN(d.getTime()) ? '-' : d.toLocaleString('id-ID');
}

// Realtime: refresh otomatis tiap 5 detik
setInterval(loadRatings, 5000);

// Realtime: refresh saat filter berubah
['rating','nama_paket','tanggal','order'].forEach(id => {
    document.getElementById(id).addEventListener('input', loadRatings);
});

// Load awal
loadRatings();
</script>

</body>
</html>
