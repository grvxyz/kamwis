<main class="flex-1 p-6 md:p-8 overflow-x-auto">

<!-- ================= HEADER ================= -->
<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kelola Artikel</h1>
        <p class="text-sm text-gray-500">Manajemen konten & SEO artikel</p>
    </div>

    <button onclick="openFormModal()"
        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow text-sm font-semibold">
        + Tambah Artikel
    </button>
</div>

<!-- ================= TABLE ================= -->
<div class="bg-white rounded-xl shadow border overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 border-b">
<tr>
    <th class="px-4 py-3 text-left">Foto</th>
    <th class="px-4 py-3 text-left">Judul</th>
    <th class="px-4 py-3 text-left">Status</th>
    <th class="px-4 py-3 text-center">Aksi</th>
</tr>
</thead>

<tbody class="divide-y">
<?php if(!empty($artikel)): ?>
<?php foreach($artikel as $a): ?>
<tr class="hover:bg-gray-50">
    <td class="px-4 py-3">
        <?php if($a->foto): ?>
            <img src="<?= base_url('uploads/artikel/'.$a->foto) ?>"
                 class="w-20 h-14 object-cover rounded-lg border">
        <?php else: ?>
            <div class="w-20 h-14 bg-gray-200 rounded-lg"></div>
        <?php endif ?>
    </td>

    <td class="px-4 py-3">
        <p class="font-semibold text-gray-800"><?= $a->judul ?></p>
        <span class="text-xs text-gray-400">/artikel/<?= $a->slug ?></span>
    </td>

    <td class="px-4 py-3">
        <span class="px-3 py-1 text-xs rounded-full font-semibold
        <?= $a->status=='publish'
            ? 'bg-green-100 text-green-700'
            : 'bg-gray-200 text-gray-600' ?>">
            <?= ucfirst($a->status) ?>
        </span>
    </td>

    <td class="px-4 py-3 text-center space-x-2">
        <button onclick='previewArtikel(<?= json_encode($a) ?>)'
            class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-xs">
            Preview
        </button>

        <button onclick='editArtikel(<?= json_encode($a) ?>)'
            class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-xs">
            Edit
        </button>

        <button onclick="hapusArtikel(<?= $a->id_artikel ?>)"
            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">
            Hapus
        </button>
    </td>
</tr>
<?php endforeach ?>
<?php else: ?>
<tr>
    <td colspan="4" class="py-10 text-center text-gray-500">
        Belum ada artikel
    </td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>

<!-- ================= MODAL FORM ================= -->
<div id="formModal"
class="fixed inset-0 hidden bg-black/50 z-50 flex items-center justify-center px-4">

<div class="bg-white w-full max-w-xl rounded-2xl shadow-lg flex flex-col max-h-[90vh]">

    <!-- HEADER -->
    <div class="flex justify-between items-center border-b px-6 py-4 sticky top-0 bg-white">
        <h2 id="formTitle" class="text-lg font-bold">Tambah Artikel</h2>
        <button onclick="closeFormModal()" class="text-xl text-gray-400">✕</button>
    </div>

    <!-- BODY -->
    <div class="overflow-y-auto p-6 space-y-4">
        <form id="formArtikel" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="id_artikel" id="id_artikel">

            <div>
                <label class="text-sm font-medium">Judul</label>
                <input name="judul" id="judul" oninput="generateSlug()"
                class="w-full border rounded-lg px-3 py-2 mt-1" required>
            </div>

            <div>
                <label class="text-sm font-medium">Slug (SEO URL)</label>
                <input name="slug" id="slug"
                class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-100" readonly>
            </div>

            <div>
                <label class="text-sm font-medium">Isi Artikel</label>
                <textarea name="isi" id="isi" rows="6"
                class="w-full border rounded-lg px-3 py-2 mt-1"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium">Meta Title</label>
                    <input name="meta_title"
                    class="w-full border rounded-lg px-3 py-2 mt-1">
                </div>

                <div>
                    <label class="text-sm font-medium">Status</label>
                    <select name="status" id="status"
                    class="w-full border rounded-lg px-3 py-2 mt-1">
                        <option value="publish">Publish</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="text-sm font-medium">Meta Description</label>
                <textarea name="meta_description" rows="2"
                class="w-full border rounded-lg px-3 py-2 mt-1"></textarea>
            </div>

            <div>
                <label class="text-sm font-medium">Foto Artikel</label>
                <input type="file" name="foto" accept="image/*"
                onchange="previewImage(event)"
                class="w-full border rounded-lg px-3 py-2 mt-1">
                <img id="imgPreview"
                class="mt-2 hidden w-full h-40 object-cover rounded-lg">
            </div>
        </form>
    </div>

    <!-- FOOTER -->
    <div class="flex justify-end items-center px-6 py-4 border-t bg-white space-x-2">
        <button onclick="closeFormModal()"
        class="px-4 py-2 border rounded-lg text-sm">
            Batal
        </button>

        <button form="formArtikel"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold">
            Simpan
        </button>
    </div>
</div>
</div>

<!-- ================= MODAL PREVIEW ================= -->
<div id="previewModal"
class="fixed inset-0 hidden bg-black/50 z-50 flex items-center justify-center px-4">

<div class="bg-white max-w-2xl w-full rounded-2xl shadow-lg flex flex-col max-h-[90vh]">

    <div class="flex justify-between items-center border-b px-6 py-4 sticky top-0 bg-white">
        <h2 class="text-lg font-bold">Preview Artikel</h2>
        <button onclick="closePreview()" class="text-xl text-gray-400">✕</button>
    </div>

    <div class="p-6 overflow-y-auto space-y-4">
        <img id="previewFoto" class="w-full rounded-lg hidden">
        <h1 id="previewJudul" class="text-xl font-bold"></h1>
        <div id="previewIsi" class="text-gray-700 text-sm leading-relaxed"></div>
    </div>
</div>
</div>

<!-- ================= SCRIPT ================= -->
<script>
function openFormModal(){
    formModal.classList.remove('hidden');
}

function closeFormModal(){
    formModal.classList.add('hidden');
    formArtikel.reset();
    imgPreview.classList.add('hidden');
    id_artikel.value = '';
    formTitle.innerText = 'Tambah Artikel';
}

function generateSlug(){
    slug.value = judul.value.toLowerCase()
        .replace(/[^a-z0-9]+/g,'-')
        .replace(/(^-|-$)/g,'');
}

function previewImage(e){
    imgPreview.src = URL.createObjectURL(e.target.files[0]);
    imgPreview.classList.remove('hidden');
}

function previewArtikel(a){
    previewModal.classList.remove('hidden');
    previewJudul.innerText = a.judul;
    previewIsi.innerHTML = a.isi;

    if(a.foto){
        previewFoto.src = '<?= base_url("uploads/artikel/") ?>' + a.foto;
        previewFoto.classList.remove('hidden');
    }
}

function closePreview(){
    previewModal.classList.add('hidden');
}

function editArtikel(a){
    openFormModal();
    formTitle.innerText = 'Edit Artikel';

    id_artikel.value = a.id_artikel;
    judul.value = a.judul;
    slug.value = a.slug;
    isi.value = a.isi;
    status.value = a.status;
}

formArtikel.addEventListener('submit', function(e){
    e.preventDefault();

    fetch('<?= site_url("admin/artikel/ajax_simpan") ?>',{
        method:'POST',
        body:new FormData(formArtikel)
    }).then(() => location.reload());
});

function hapusArtikel(id){
    if(confirm('Hapus artikel ini?')){
        fetch('<?= site_url("admin/artikel/ajax_hapus") ?>',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'id=' + id
        }).then(() => location.reload());
    }
}
</script>

</main>
