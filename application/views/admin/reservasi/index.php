<main class="flex-1 p-4 sm:p-6 md:p-8 bg-gray-50">

    <!-- ================= HEADER ================= -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">
                Kelola Reservasi
            </h1>
            <p class="text-sm text-gray-500">
                Status reservasi dapat diubah admin, pembayaran otomatis oleh sistem
            </p>
        </div>
    </div>

    <!-- ================= TABLE ================= -->
    <div class="bg-white rounded-2xl shadow overflow-x-auto">

        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 border-b text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">User</th>
                    <th class="px-4 py-3 text-left">Paket</th>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-center">Peserta</th>
                    <th class="px-4 py-3 text-right">Total</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Pembayaran</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                <?php if (!empty($reservasi)): ?>
                    <?php foreach ($reservasi as $r): ?>

                        <?php $is_today = date('Y-m-d') === $r->tanggal_kunjungan; ?>

                        <tr class="hover:bg-gray-50 <?= $is_today ? 'bg-blue-50 border-l-4 border-blue-500' : '' ?>">
                            <td class="px-4 py-3 font-medium"><?= $r->nama_user ?></td>
                            <td class="px-4 py-3"><?= $r->nama_paket ?></td>

                            <td class="px-4 py-3">
                                <?= date('d M Y', strtotime($r->tanggal_kunjungan)) ?>
                                <?php if ($is_today): ?>
                                    <span class="ml-2 text-xs font-semibold text-blue-600">Hari Ini</span>
                                <?php endif; ?>
                            </td>

                            <td class="px-4 py-3 text-center"><?= $r->jumlah_peserta ?></td>

                            <td class="px-4 py-3 text-right font-semibold">
                                Rp <?= number_format($r->total_harga, 0, ',', '.') ?>
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-3 py-1 text-xs rounded-full font-semibold
        <?= $r->status == 'Selesai' ? 'bg-green-100 text-green-700' :
            ($r->status == 'Dikonfirmasi' ? 'bg-blue-100 text-blue-700' :
                ($r->status == 'Pending' ? 'bg-yellow-100 text-yellow-700' :
                    'bg-red-100 text-red-700')) ?>">
                                    <?= $r->status ?>
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-3 py-1 text-xs rounded-full
        <?= $r->payment_status == 'settlement' ? 'bg-green-100 text-green-700' :
            ($r->payment_status == 'pending' ? 'bg-yellow-100 text-yellow-700' :
                'bg-gray-100 text-gray-600') ?>">
                                    <?= ucfirst($r->payment_status ?? 'Belum Bayar') ?>
                                </span>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <button onclick="openDetail(<?= $r->id_reservasi ?>)"
                                    class="px-3 py-1 text-xs font-semibold rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200">
                                    Detail
                                </button>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                <?php else: ?>

                    <tr>
                        <td colspan="8" class="py-14 text-center text-gray-500">
                            <p class="font-medium">Belum ada data reservasi</p>
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>
        </table>
    </div>

</main>

<!-- ================= MODAL DETAIL ================= -->
<div id="modalDetail" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 relative">

        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">✕</button>

        <h2 class="text-lg font-bold mb-4">Detail Reservasi</h2>

        <div id="modalContent" class="space-y-3 text-sm"></div>

        <!-- STATUS EDIT -->
        <div class="mt-4">
            <label class="text-sm text-gray-500">Status Reservasi</label>
            <select id="statusSelect" class="mt-1 w-full border rounded-lg px-3 py-2 text-sm">
                <option value="Pending">Pending</option>
                <option value="Dikonfirmasi">Dikonfirmasi</option>
                <option value="Dibatalkan">Dibatalkan</option>
            </select>
            <p class="text-xs text-gray-400 mt-1">
                * Status <b>Selesai</b> diatur otomatis oleh sistem
            </p>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <button onclick="saveStatus()"
                class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                Simpan Status
            </button>
            <button onclick="closeModal()" class="px-4 py-2 text-sm rounded-lg bg-gray-200 hover:bg-gray-300">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ================= SCRIPT ================= -->
<script>
    let currentId = null;

    function openDetail(id) {
        currentId = id;

        fetch(`<?= site_url('reservasi/detail/') ?>${id}`)

            .then(res => res.json())
            .then(res => {
                if (res.status !== 'success') return;

                const r = res.data;

                document.getElementById('modalContent').innerHTML = `
                <div class="flex justify-between"><span>User</span><b>${r.nama_user}</b></div>
                <div class="flex justify-between"><span>Paket</span><span>${r.nama_paket}</span></div>
                <div class="flex justify-between"><span>Tanggal</span><span>${r.tanggal_kunjungan}</span></div>
                <div class="flex justify-between"><span>Jam</span><span>${r.jam_kunjungan ?? '-'}</span></div>
                <div class="flex justify-between"><span>Peserta</span><span>${r.jumlah_peserta}</span></div>
                <div class="flex justify-between"><span>Total</span>
                    <b>Rp ${Number(r.total_harga).toLocaleString('id-ID')}</b>
                </div>
                <hr>
                <div class="flex justify-between"><span>Pembayaran</span>
                    <span>${r.payment_status ?? '-'}</span>
                </div>
                <div class="flex justify-between"><span>Order ID</span>
                    <span class="text-xs">${r.order_id ?? '-'}</span>
                </div>
            `;

                document.getElementById('statusSelect').value = r.status;
                document.getElementById('statusSelect').disabled = (r.status === 'Selesai');

                document.getElementById('modalDetail').classList.remove('hidden');
                document.getElementById('modalDetail').classList.add('flex');
            });
    }

    function saveStatus() {
        const status = document.getElementById('statusSelect').value;

        fetch(`<?= base_url('admin/reservasi/update_status') ?>`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id_reservasi=${currentId}&status=${status}`
        })
            .then(res => res.json())
            .then(() => location.reload());
    }

    function closeModal() {
        document.getElementById('modalDetail').classList.add('hidden');
        document.getElementById('modalDetail').classList.remove('flex');
    }
</script>