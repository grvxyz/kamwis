<main class="flex-1 p-8 bg-gray-50">

  <h1 class="text-2xl font-bold mb-1">Laporan & Statistik</h1>
  <p class="text-gray-500 mb-6">Analisis performa dan pendapatan wisata</p>

  <!-- ================= SUMMARY ================= -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-xl shadow">
      <p class="text-sm text-gray-500">Total Pendapatan</p>
      <h2 class="text-2xl font-bold mt-2">
        Rp <?= number_format($total_pendapatan,0,',','.') ?>
      </h2>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
      <p class="text-sm text-gray-500">Total Reservasi</p>
      <h2 class="text-2xl font-bold mt-2"><?= $total_reservasi ?></h2>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
      <p class="text-sm text-gray-500">Total Peserta</p>
      <h2 class="text-2xl font-bold mt-2"><?= $total_peserta ?></h2>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
      <p class="text-sm text-gray-500">Conversion Rate</p>
      <h2 class="text-2xl font-bold mt-2">
        <?= $total_peserta ? round(($total_reservasi/$total_peserta)*100,1) : 0 ?>%
      </h2>
    </div>

  </div>

  <!-- ================= CHART ================= -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <!-- Pendapatan Paket -->
    <div class="bg-white p-6 rounded-xl shadow">
      <h3 class="font-bold mb-4">Pendapatan per Paket</h3>
      <canvas id="chartPendapatan" height="150"></canvas>
    </div>

    <!-- Status Reservasi -->
    <div class="bg-white p-6 rounded-xl shadow">
      <h3 class="font-bold mb-4">Status Reservasi</h3>
      <canvas id="chartStatus" height="150"></canvas>
    </div>

  </div>

  <!-- ================= STATUS & TERLARIS ================= -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <div class="bg-white p-6 rounded-xl shadow">
      <h3 class="font-bold mb-4">Status Reservasi</h3>
      <?php foreach($status_reservasi as $s): ?>
        <p class="flex justify-between text-sm mb-2">
          <span><?= $s->status ?></span>
          <span><?= $s->total ?> booking</span>
        </p>
      <?php endforeach ?>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
      <h3 class="font-bold mb-4">Paket Terpopuler</h3>
      <?php foreach($paket_terlaris as $p): ?>
        <p class="text-sm mb-2">
          <?= $p->nama_paket ?><br>
          <span class="text-gray-500">
            <?= $p->total ?> pemesanan • Rp <?= number_format($p->pendapatan,0,',','.') ?>
          </span>
        </p>
      <?php endforeach ?>
    </div>

  </div>

  <!-- ================= TABEL PERFORMA ================= -->
  <div class="bg-white p-6 rounded-xl shadow">
    <h3 class="font-bold mb-4">Performa Paket Wisata</h3>

    <table class="w-full text-sm">
      <thead class="border-b">
        <tr>
          <th class="text-left py-2">Nama Paket</th>
          <th class="text-center">Pemesanan</th>
          <th class="text-right">Pendapatan</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($performa_paket as $p): ?>
          <tr class="border-b">
            <td class="py-2"><?= $p->nama_paket ?></td>
            <td class="text-center"><?= $p->pemesanan ?></td>
            <td class="text-right">
              Rp <?= number_format($p->pendapatan,0,',','.') ?>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>

</main>

<!-- ================= CHART.JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* ================= DATA PHP ================= */
const paketLabels = <?= json_encode(array_column($performa_paket, 'nama_paket')) ?>;
const paketPendapatan = <?= json_encode(array_column($performa_paket, 'pendapatan')) ?>;

const statusLabels = <?= json_encode(array_column($status_reservasi, 'status')) ?>;
const statusTotal = <?= json_encode(array_column($status_reservasi, 'total')) ?>;

/* ================= BAR CHART ================= */
new Chart(document.getElementById('chartPendapatan'), {
  type: 'bar',
  data: {
    labels: paketLabels,
    datasets: [{
      label: 'Pendapatan',
      data: paketPendapatan,
      backgroundColor: '#3b82f6'
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false }
    },
    scales: {
      y: {
        ticks: {
          callback: value => 'Rp ' + value.toLocaleString('id-ID')
        }
      }
    }
  }
});

/* ================= DOUGHNUT CHART ================= */
new Chart(document.getElementById('chartStatus'), {
  type: 'doughnut',
  data: {
    labels: statusLabels,
    datasets: [{
      data: statusTotal,
      backgroundColor: [
        '#22c55e',
        '#facc15',
        '#ef4444',
        '#3b82f6'
      ]
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'bottom'
      }
    }
  }
});
</script>