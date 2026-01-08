<main class="flex-1 p-6 md:p-8 overflow-x-auto">

    <!-- ================= HEADER ================= -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Event</h1>
            <p class="text-sm text-gray-500">Manajemen event & jadwal kegiatan</p>
        </div>
    </div>
    <div class="flex flex-wrap md:flex-nowrap gap-4 mb-6 items-center">
    <select class="px-4 py-2 border rounded-lg text-sm bg-white w-full md:w-auto"
        onchange="filterEvent(this.value)">
        <option value="all">Semua Event</option>
        <option value="aktif">Event Aktif</option>
        <option value="upcoming">Akan Datang</option>
        <option value="selesai">Event Selesai</option>
    </select>

    <!-- SEARCH -->
    <input type="text" id="searchEvent"
        placeholder="Cari nama event / lokasi..."
        class="px-4 py-2 border rounded-lg text-sm w-full md:w-64"
        onkeyup="searchEvent()">

    <button onclick="openModal()"
        class="px-4 py-2 bg-blue-600 hover:bg-blue-700
        text-white rounded-lg text-sm font-semibold shadow">
        + Tambah Event
    </button>
</div>


    <!-- ================= TABLE ================= -->
    <div class="bg-white rounded-xl shadow border overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-5 py-3 text-left">Foto</th>
                    <th class="px-5 py-3 text-left">Nama Event</th>
                    <th class="px-5 py-3 text-left">Tanggal</th>
                    <th class="px-5 py-3 text-left">Lokasi</th>
                    <th class="px-5 py-3 text-center">Status</th>
                    <th class="px-5 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody id="eventTable" class="divide-y">
                <?php if (empty($event)): ?>
                    <tr>
                        <td colspan="6" class="py-10 text-center text-gray-500">
                            Belum ada event
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($event as $e): ?>
                    <tr class="event-row" data-status="<?= $e->status ?>" data-start="<?= $e->tanggal_mulai ?>"
                        data-end="<?= $e->tanggal_selesai ?>">

                        <td class="px-5 py-4">
                            <?php if ($e->foto): ?>
                                <img src="<?= base_url('uploads/event/' . $e->foto) ?>"
                                    class="w-28 h-16 object-cover rounded-lg border">
                            <?php else: ?>
                                <div class="w-28 h-16 bg-gray-200 rounded-lg
            flex items-center justify-center text-xs text-gray-500">
                                    Landscape
                                </div>
                            <?php endif; ?>
                        </td>

                        <td class="px-5 py-4 font-semibold text-gray-800">
                            <?= $e->nama_event ?>
                        </td>

                        <td class="px-5 py-4 text-gray-600">
                            <?= date('d M Y', strtotime($e->tanggal_mulai)) ?>
                            <br>
                            <span class="text-xs text-gray-400">
                                s/d <?= date('d M Y', strtotime($e->tanggal_selesai)) ?>
                            </span>
                        </td>

                        <td class="px-5 py-4 text-gray-600"><?= $e->lokasi ?></td>

                        <!-- STATUS -->
                        <td class="px-5 py-4 text-center">
                            <div class="status-badge">
                                <span class="px-3 py-1 text-xs rounded-full font-semibold
        <?= $e->status == 'aktif'
            ? 'bg-green-100 text-green-700'
            : 'bg-gray-200 text-gray-600' ?>">
                                    <?= ucfirst($e->status) ?>
                                </span>
                            </div>
                        </td>

                        <!-- AKSI -->
                        <td class="px-5 py-4 text-center space-x-2 action-cell">
                            <button onclick='editEvent(<?= json_encode($e) ?>)' class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600
        text-white text-xs rounded">
                                Edit
                            </button>

                            <button onclick="hapusEvent(<?= $e->id_event ?>)" class="px-3 py-1 bg-red-600 hover:bg-red-700
        text-white text-xs rounded">
                                Hapus
                            </button>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- ================= MODAL ================= -->
    <div id="modal" class="fixed inset-0 hidden bg-black/50 z-50
        flex items-center justify-center px-4">

        <div class="bg-white w-full max-w-xl rounded-2xl shadow-lg
            max-h-[90vh] overflow-y-auto">

            <div class="border-b px-6 py-4 flex justify-between items-center">
                <h2 id="modalTitle" class="text-lg font-bold">Tambah Event</h2>
                <button onclick="closeModal()" class="text-gray-400 text-xl">✕</button>
            </div>

            <form id="formEvent" enctype="multipart/form-data" class="p-6 space-y-4">

                <input type="hidden" name="id_event" id="id_event">

                <div>
                    <label class="text-sm font-medium">Nama Event</label>
                    <input name="nama_event" id="nama_event" class="w-full border rounded-lg px-3 py-2 mt-1" required>
                </div>

                <div>
                    <label class="text-sm font-medium">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi"
                        class="w-full border rounded-lg px-3 py-2 mt-1"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                            class="w-full border rounded-lg px-3 py-2 mt-1">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                            class="w-full border rounded-lg px-3 py-2 mt-1">
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium">Lokasi</label>
                    <input name="lokasi" id="lokasi" class="w-full border rounded-lg px-3 py-2 mt-1">
                </div>

                <div>
                    <label class="text-sm font-medium">Status</label>
                    <select name="status" id="status" class="w-full border rounded-lg px-3 py-2 mt-1">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Foto Event</label>
                    <input type="file" name="foto" class="w-full border rounded-lg px-3 py-2 mt-1">
                </div>

                <div class="bg-yellow-50 border border-yellow-200
            rounded-lg p-3 text-xs text-yellow-800">
                    ⚠️ Event yang telah selesai akan otomatis dinonaktifkan
                    dan disarankan untuk dihapus.
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border rounded-lg text-sm">
                        Batal
                    </button>
                    <button class="px-4 py-2 bg-blue-600 text-white
               rounded-lg text-sm font-semibold">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- ================= JS ================= -->
    <script>
        const modal = document.getElementById('modal');
        const today = new Date().toISOString().split('T')[0];

        function openModal() { modal.classList.remove('hidden'); }
        function closeModal() {
            modal.classList.add('hidden');
            formEvent.reset();
            id_event.value = '';
        }

        function editEvent(e) {
            openModal();
            modalTitle.innerText = 'Edit Event';
            id_event.value = e.id_event;
            nama_event.value = e.nama_event;
            deskripsi.value = e.deskripsi;
            tanggal_mulai.value = e.tanggal_mulai;
            tanggal_selesai.value = e.tanggal_selesai;
            lokasi.value = e.lokasi;
            status.value = e.status;
        }

        formEvent.onsubmit = e => {
            e.preventDefault();
            fetch("<?= site_url('admin/event/ajax_simpan') ?>", {
                method: 'POST',
                body: new FormData(formEvent)
            }).then(() => location.reload());
        }

        function hapusEvent(id) {
            if (confirm('Hapus event ini?')) {
                fetch("<?= site_url('admin/event/ajax_hapus') ?>", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + id
                }).then(() => location.reload());
            }
        }

        // AUTO STATUS SELESAI
        document.querySelectorAll('.event-row').forEach(row => {
            const end = row.dataset.end;
            const badge = row.querySelector('.status-badge');

            if (end < today) {
                row.dataset.status = 'selesai';
                badge.innerHTML = `
        <span class="px-3 py-1 text-xs rounded-full font-semibold
        bg-red-100 text-red-700">Selesai</span>
        <div class="text-[11px] text-red-500 mt-1">
        ⚠️ Disarankan untuk dihapus
        </div>`;
            }
        });

        // FILTER
        function filterEvent(type) {
            document.querySelectorAll('.event-row').forEach(row => {
                row.style.display = 'table-row';
                if (type === 'aktif' && row.dataset.status !== 'aktif') row.style.display = 'none';
                if (type === 'selesai' && row.dataset.status !== 'selesai') row.style.display = 'none';
                if (type === 'upcoming' && row.dataset.start <= today) row.style.display = 'none';
            });
        }
        function searchEvent() {
        const keyword = document.getElementById('searchEvent').value.toLowerCase();

        document.querySelectorAll('.event-row').forEach(row => {
            const nama = row.children[1].innerText.toLowerCase();
            const lokasi = row.children[3].innerText.toLowerCase();

            if (nama.includes(keyword) || lokasi.includes(keyword)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    }
    </script>

</main>