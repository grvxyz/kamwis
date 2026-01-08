<main class="flex-1 p-6 md:p-8 overflow-x-auto">

<!-- ================= HEADER ================= -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-3">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kelola Paket Wisata</h1>
        <p class="text-sm text-gray-500">Manajemen paket & harga wisata</p>
    </div>
</div>
<div class="flex flex-wrap items-center gap-3 mb-4">
    <select id="filterStatus"
        class="border rounded-lg px-3 py-2 text-sm"
        onchange="filterPaket()">
        <option value="all">Semua Status</option>
        <option value="aktif">Aktif</option>
        <option value="nonaktif">Nonaktif</option>
    </select>

    <input type="text" id="searchNama"
        placeholder="Cari nama paket..."
        class="border rounded-lg px-3 py-2 text-sm w-64"
        onkeyup="filterPaket()">
    <button onclick="openModal()"
        class="inline-flex items-center gap-2 px-4 py-2
               bg-blue-600 hover:bg-blue-700
               text-white rounded-lg shadow transition">
        + Tambah Paket
    </button>
</div>

<!-- ================= TABLE ================= -->
<div class="bg-white rounded-xl shadow border overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 border-b">
<tr>
    <th class="px-5 py-3 text-left font-semibold">Foto</th>
    <th class="px-5 py-3 text-left font-semibold">Nama Paket</th>
    <th class="px-5 py-3 text-left font-semibold">Harga</th>
    <th class="px-5 py-3 text-left font-semibold">Status</th>
    <th class="px-5 py-3 text-center font-semibold">Aksi</th>
</tr>
</thead>

<tbody class="divide-y">
<?php if(empty($paket)): ?>
<tr>
<td colspan="5" class="py-10 text-center text-gray-500">
Data paket belum tersedia
</td>
</tr>
<?php endif; ?>

<?php foreach($paket as $p): ?>
<tr class="paket-row hover:bg-gray-50 transition"
    data-status="<?= $p->status ?>"
    data-nama="<?= strtolower($p->nama_paket) ?>">
<td class="px-5 py-4">
    <img src="<?= base_url('uploads/paket/'.$p->foto) ?>"
         class="w-24 h-16 object-cover rounded-lg border">
</td>

<td class="px-5 py-4 font-medium text-gray-800">
    <?= $p->nama_paket ?>
</td>

<td class="px-5 py-4 text-gray-700">
    Rp <?= number_format($p->harga,0,',','.') ?>
</td>

<td class="px-5 py-4">
    <span class="px-3 py-1 text-xs rounded-full font-semibold
        <?= $p->status=='aktif'
            ? 'bg-green-100 text-green-700'
            : 'bg-red-100 text-red-700' ?>">
        <?= ucfirst($p->status) ?>
    </span>
</td>

<td class="px-5 py-4 text-center space-x-2">
    <button onclick='editPaket(<?= json_encode($p) ?>)'
        class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600
               text-white rounded-md text-xs transition">
        Edit
    </button>

    <button onclick="hapusPaket(<?= $p->id_paket ?>)"
        class="px-3 py-1 bg-red-600 hover:bg-red-700
               text-white rounded-md text-xs transition">
        Hapus
    </button>
</td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>

<!-- ================= MODAL ================= -->
<div id="modal"
 class="fixed inset-0 bg-black/50 hidden
        flex items-center justify-center p-4 z-50">

<div class="bg-white w-full max-w-lg rounded-xl p-6
            animate-scale overflow-y-auto max-h-[90vh]">

<h2 class="text-xl font-bold mb-4 text-gray-800" id="modalTitle">
    Tambah Paket
</h2>

<form id="formPaket" enctype="multipart/form-data" class="space-y-4">
<input type="hidden" name="id_paket" id="id_paket">

<div>
<label class="text-sm font-medium">Nama Paket</label>
<input name="nama_paket" id="nama_paket"
 class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200" required>
</div>

<div>
<label class="text-sm font-medium">Deskripsi</label>
<textarea name="deskripsi" id="deskripsi"
 class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"></textarea>
</div>

<div>
<label class="text-sm font-medium">Fasilitas</label>
<textarea name="fasilitas" id="fasilitas"
 class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"></textarea>
</div>

<div>
<label class="text-sm font-medium">Harga</label>
<input type="number" name="harga" id="harga"
 class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200" required>
</div>

<div>
<label class="text-sm font-medium">Status</label>
<select name="status" id="status"
 class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
<option value="aktif">Aktif</option>
<option value="nonaktif">Nonaktif</option>
</select>
</div>

<div>
<label class="text-sm font-medium">Foto</label>
<input type="file" name="foto"
 class="w-full border rounded-lg px-3 py-2">
</div>

<div class="flex justify-end gap-3 pt-4 border-t">
<button type="button" onclick="closeModal()"
 class="px-4 py-2 border rounded-lg hover:bg-gray-100 transition">
Batal
</button>

<button
 class="px-4 py-2 bg-blue-600 hover:bg-blue-700
        text-white rounded-lg transition">
Simpan
</button>
</div>
</form>

</div>
</div>

<!-- ================= JS ================= -->
<script>
    function filterPaket(){
    const statusFilter = document.getElementById('filterStatus').value;
    const searchVal = document.getElementById('searchNama').value.toLowerCase();
    const rows = document.querySelectorAll('.paket-row');

    rows.forEach(row=>{
        const rowStatus = row.getAttribute('data-status');
        const rowNama = row.getAttribute('data-nama');
        let show = true;

        if(statusFilter !== 'all' && statusFilter !== rowStatus) show=false;
        if(searchVal && !rowNama.includes(searchVal)) show=false;

        row.style.display = show ? '' : 'none';
    });
}
function openModal(){
    modal.classList.remove('hidden');
}

function closeModal(){
    modal.classList.add('hidden');
    formPaket.reset();
    id_paket.value='';
    modalTitle.innerText='Tambah Paket';
}

function editPaket(p){
    openModal();
    modalTitle.innerText='Edit Paket';
    id_paket.value=p.id_paket;
    nama_paket.value=p.nama_paket;
    deskripsi.value=p.deskripsi;
    fasilitas.value=p.fasilitas;
    harga.value=p.harga;
    status.value=p.status;
}

formPaket.onsubmit = function(e){
    e.preventDefault();
    fetch("<?= site_url('admin/paket/ajax_simpan') ?>",{
        method:'POST',
        body:new FormData(this)
    })
    .then(r=>r.json())
    .then(res=>{
        if(res.status==='success') location.reload();
        else alert(res.message);
    });
}

function hapusPaket(id){
    if(!confirm('Hapus paket ini?')) return;
    fetch("<?= site_url('admin/paket/ajax_hapus') ?>",{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'id_paket='+id
    }).then(()=>location.reload());
}
</script>

<style>
@keyframes scale{
    from{transform:scale(.95);opacity:0}
    to{transform:scale(1);opacity:1}
}
.animate-scale{animation:scale .2s ease}
</style>


</main>
