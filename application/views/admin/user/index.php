<!-- ================= MAIN ================= -->
<main class="flex-1 p-4 md:p-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola User</h1>
            <p class="text-sm text-gray-500">Manajemen data user aplikasi</p>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3 mb-4">
        <select id="filterRole" class="border rounded-lg px-3 py-2 text-sm" onchange="filterUser()">
            <option value="">Semua Role</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>

        <input type="text" id="searchUser" placeholder="Cari nama / email..."
            class="border rounded-lg px-3 py-2 text-sm w-full md:w-64" onkeyup="filterUser()">
    </div>



    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow border overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                <?php $no = 1;
                foreach ($users as $u): ?>
                    <tr class="hover:bg-gray-50 user-row" data-role="<?= $u->role ?>"
                        data-name="<?= strtolower($u->nama) ?>" data-email="<?= strtolower($u->email) ?>">

                        <td class="px-4 py-3"><?= $no++ ?></td>
                        <td class="px-4 py-3 font-medium"><?= $u->nama ?></td>
                        <td class="px-4 py-3 text-gray-600"><?= $u->email ?></td>

                        <td class="px-4 py-3">
                            <span class="px-3 py-1 text-xs rounded-full
                        <?= $u->role == 'admin'
                            ? 'bg-purple-100 text-purple-700'
                            : 'bg-blue-100 text-blue-700' ?>">
                                <?= ucfirst($u->role) ?>
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <span class="px-3 py-1 text-xs rounded-full
                        <?= $u->status == 'aktif'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700' ?>">
                                <?= ucfirst($u->status) ?>
                            </span>
                        </td>

                        <td class="px-4 py-3 text-center space-x-2">
                            <button onclick='openEditModal(<?= json_encode($u) ?>)'
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                Edit
                            </button>

                            <button onclick="hapusUser(<?= $u->id_user ?>)"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                Hapus
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">
                            Data user kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</main>

<!-- ================= MODAL ================= -->
<div id="modal" class="fixed inset-0 hidden bg-black/50 flex items-center justify-center z-50 px-4">

    <div id="modalBox" class="bg-white w-full max-w-md rounded-xl p-6 shadow-lg
transform scale-95 opacity-0 transition-all duration-300">

        <h2 id="modalTitle" class="text-lg font-bold mb-4">Tambah User</h2>

        <form id="userForm">
            <input type="hidden" name="id_user" id="id_user">

            <div class="mb-3">
                <label class="text-sm">Nama</label>
                <input type="text" name="nama" id="nama" class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <div class="mb-3">
                <label class="text-sm">Email</label>
                <input type="email" name="email" id="email" class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <div class="mb-3">
                <label class="text-sm">Role</label>
                <select name="role" id="role" class="w-full border rounded-lg px-3 py-2">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="text-sm">Status</label>
                <select name="status" id="status" class="w-full border rounded-lg px-3 py-2">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 border rounded-lg">
                    Batal
                </button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= JS ================= -->
<script>
    const modal = document.getElementById('modal');
    const box = document.getElementById('modalBox');
    const filterRole = document.getElementById('filterRole');
    const searchUser = document.getElementById('searchUser');
    const rows = document.querySelectorAll('.user-row');

    /* FILTER + SEARCH */
    function filterTable() {
        const role = filterRole.value;
        const keyword = searchUser.value.toLowerCase();

        rows.forEach(row => {
            const matchRole = !role || row.dataset.role === role;
            const matchText =
                row.dataset.name.includes(keyword) ||
                row.dataset.email.includes(keyword);

            row.style.display = (matchRole && matchText) ? '' : 'none';
        });
    }

    filterRole.addEventListener('change', filterTable);
    searchUser.addEventListener('input', filterTable);

    /* MODAL */
    function openEditModal(user) {
        modal.classList.remove('hidden');
        setTimeout(() => box.classList.remove('scale-95', 'opacity-0'), 50);

        modalTitle.innerText = 'Edit User';
        id_user.value = user.id_user;
        nama.value = user.nama;
        email.value = user.email;
        role.value = user.role;
        status.value = user.status;
    }

    function closeModal() {
        box.classList.add('scale-95', 'opacity-0');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }

    /* SUBMIT */
    userForm.addEventListener('submit', e => {
        e.preventDefault();

        fetch('<?= base_url("admin/user/ajax_simpan") ?>', {
            method: 'POST',
            body: new FormData(userForm)
        }).then(() => location.reload());
    });

    function hapusUser(id) {
        if (!confirm('Yakin ingin menghapus user ini?')) return;

        fetch('<?= base_url("admin/user/ajax_hapus") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id_user=' + id
        }).then(() => location.reload());
    }
</script>