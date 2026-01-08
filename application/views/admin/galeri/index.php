<main class="flex-1 p-6 md:p-8 overflow-x-auto">

    <!-- ================= HEADER ================= -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Galeri</h1>
            <p class="text-sm text-gray-500">Manajemen foto & video kegiatan</p>
        </div>
    </div>
    <div class="flex flex-wrap md:flex-nowrap gap-4 mb-6 items-center">
        <select id="filterJenis" class="px-4 py-2 border rounded-lg text-sm bg-white w-full md:w-auto">
            <option value="all">Semua</option>
            <option value="foto">Foto</option>
            <option value="video">Video</option>
        </select>

        <input type="text" id="searchGaleri" placeholder="Cari nama kegiatan..."
            class="px-4 py-2 border rounded-lg text-sm w-full md:w-64">
            <button onclick="openModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700
                text-white rounded-lg text-sm font-semibold shadow">
            + Tambah Galeri
        </button>
    </div>


    <!-- ================= TABLE ================= -->
    <div class="bg-white rounded-xl shadow border overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-5 py-3 text-left">Preview</th>
                    <th class="px-5 py-3 text-left">Nama Kegiatan</th>
                    <th class="px-5 py-3 text-center">Jenis</th>
                    <th class="px-5 py-3 text-left">Deskripsi</th>
                    <th class="px-5 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <?php foreach ($galeri as $g): ?>
                <tr class="galeri-row" data-jenis="<?= htmlspecialchars($g->jenis, ENT_QUOTES) ?>"
                    data-heading="<?= htmlspecialchars(strtolower($g->heading), ENT_QUOTES) ?>">

                    <td class="px-5 py-4">
                        <?php if ($g->jenis == 'foto'): ?>
                            <img src="<?= base_url('uploads/galeri/' . $g->file) ?>"
                                class="w-28 h-16 object-cover rounded-lg border">
                        <?php else: ?>
                            <a href="<?= $g->file ?>" target="_blank" class="text-blue-600 hover:underline font-medium">
                                Lihat Video
                            </a>
                        <?php endif; ?>
                    </td>

                    <td class="px-5 py-4 font-semibold text-gray-800"><?= $g->heading ?></td>
                    <td class="px-5 py-4 text-center">
                        <span class="px-3 py-1 text-xs rounded-full font-semibold
<?= $g->jenis == 'foto' ? 'bg-green-100 text-green-700' : 'bg-purple-100 text-purple-700' ?>">
                            <?= ucfirst($g->jenis) ?>
                        </span>
                    </td>
                    <td class="px-5 py-4 text-gray-600"><?= $g->deskripsi ?></td>
                    <td class="px-5 py-4 text-center space-x-2">
                        <button onclick='editGaleri(<?= json_encode($g) ?>)'
                            class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-xs">
                            Edit
                        </button>
                        <button onclick="hapusGaleri(<?= $g->id_galeri ?>)"
                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">
                            Hapus
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
    </div>

    <!-- ================= MODAL ================= -->
    <div id="modal" class="fixed inset-0 hidden bg-black/50 z-50
        flex items-center justify-center px-4">

        <div class="bg-white w-full max-w-md rounded-2xl shadow-lg">

            <div class="border-b px-6 py-4 flex justify-between items-center">
                <h2 id="modalTitle" class="text-lg font-bold">Tambah Galeri</h2>
                <button onclick="closeModal()" class="text-gray-400 text-xl">✕</button>
            </div>

            <form id="formGaleri" enctype="multipart/form-data" class="p-6 space-y-4">

                <input type="hidden" name="id_galeri" id="id_galeri">

                <!-- JENIS -->
                <div>
                    <label class="text-sm font-medium">Jenis Galeri</label>
                    <select name="jenis" id="jenis" onchange="toggleInput()"
                        class="w-full border rounded-lg px-3 py-2 mt-1">
                        <option value="foto">Foto</option>
                        <option value="video">Video</option>
                    </select>
                </div>

                <!-- HEADING -->
                <div>
                    <label class="text-sm font-medium">Nama Kegiatan</label>
                    <input name="heading" id="heading" class="w-full border rounded-lg px-3 py-2 mt-1" required>
                </div>

                <!-- FOTO -->
                <div id="fotoInput">
                    <label class="text-sm font-medium">Upload Foto</label>
                    <input type="file" name="file" class="w-full border rounded-lg px-3 py-2 mt-1">
                </div>

                <!-- VIDEO -->
                <div id="videoInput" class="hidden">
                    <label class="text-sm font-medium">Link Video</label>
                    <input name="file_video" placeholder="https://youtube.com/..."
                        class="w-full border rounded-lg px-3 py-2 mt-1">
                </div>

                <!-- DESKRIPSI -->
                <div>
                    <label class="text-sm font-medium">Deskripsi Kegiatan</label>
                    <textarea name="deskripsi" id="deskripsi" class="w-full border rounded-lg px-3 py-2 mt-1"
                        rows="3"></textarea>
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

        function openModal() {
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
            formGaleri.reset();
            id_galeri.value = '';
            modalTitle.innerText = 'Tambah Galeri';
            toggleInput();
        }

        function toggleInput() {
            fotoInput.classList.toggle('hidden', jenis.value === 'video');
            videoInput.classList.toggle('hidden', jenis.value === 'foto');
        }

        function editGaleri(g) {
            openModal();
            modalTitle.innerText = 'Edit Galeri';

            id_galeri.value = g.id_galeri;
            jenis.value = g.jenis;
            heading.value = g.heading;
            deskripsi.value = g.deskripsi;

            if (g.jenis === 'video') {
                videoInput.classList.remove('hidden');
                fotoInput.classList.add('hidden');
                document.querySelector('[name="file_video"]').value = g.file;
            } else {
                fotoInput.classList.remove('hidden');
                videoInput.classList.add('hidden');
            }
        }

        formGaleri.onsubmit = e => {
            e.preventDefault();

            fetch("<?= site_url('admin/galeri/ajax_simpan') ?>", {
                method: 'POST',
                body: new FormData(formGaleri)
            }).then(() => location.reload());
        }

        function hapusGaleri(id) {
            if (confirm('Hapus galeri ini?')) {
                fetch("<?= site_url('admin/galeri/ajax_hapus') ?>", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + id
                }).then(() => location.reload());
            }
        }
        const rows = document.querySelectorAll('.galeri-row');
        const filterJenis = document.getElementById('filterJenis');
        const searchGaleri = document.getElementById('searchGaleri');

        function filterGaleri() {
            const jenis = filterJenis.value;
            const keyword = searchGaleri.value.toLowerCase();

            rows.forEach(row => {
                const matchJenis = (jenis === 'all' || row.dataset.jenis === jenis);
                const matchSearch = row.dataset.heading.includes(keyword);
                row.style.display = (matchJenis && matchSearch) ? 'table-row' : 'none';
            });
        }

        // Event listener
        filterJenis.addEventListener('change', filterGaleri);
        searchGaleri.addEventListener('input', filterGaleri);
    </script>

</main>