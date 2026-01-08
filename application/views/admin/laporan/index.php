<main class="flex-1 p-8 bg-gray-50">

  <!-- ================= HEADER ================= -->
  <h1 class="text-2xl font-bold mb-1">Laporan & Statistik</h1>
  <p class="text-gray-500 mb-6">Analisis performa dan pendapatan wisata</p>

  <!-- ================= FILTER ================= -->
  <div class="bg-white p-4 rounded-xl shadow mb-8">
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">

      <!-- BULAN -->
      <div>
        <label class="text-sm text-gray-600">Bulan</label>
        <select id="bulan" class="w-full border rounded-lg px-3 py-2 text-sm">
          <option value="">Semua</option>
          <?php for ($i = 1; $i <= 12; $i++): ?>
            <option value="<?= $i ?>"><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
          <?php endfor ?>
        </select>
      </div>

      <!-- TAHUN -->
      <div>
        <label class="text-sm text-gray-600">Tahun</label>
        <select id="tahun" class="w-full border rounded-lg px-3 py-2 text-sm">
          <?php for ($y = date('Y'); $y >= 2023; $y--): ?>
            <option value="<?= $y ?>"><?= $y ?></option>
          <?php endfor ?>
        </select>
      </div>

      <!-- PRESET -->
      <div class="md:col-span-2">
        <label class="text-sm text-gray-600">Preset Cepat</label>
        <div class="flex gap-2">
          <button type="button" onclick="preset('today')" class="preset-btn">Hari Ini</button>
          <button type="button" onclick="preset('month')" class="preset-btn">Bulan Ini</button>
          <button type="button" onclick="preset('year')" class="preset-btn">Tahun Ini</button>
        </div>
      </div>

      <!-- EXPORT -->
      <div class="flex gap-2">
        <button onclick="exportData('pdf')" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm">PDF</button>
        <button onclick="exportData('csv')" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm">Excel</button>
      </div>

    </div>
  </div>

  <!-- ================= SUMMARY ================= -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-xl shadow">
      <p class="text-sm text-gray-500">Total Pendapatan</p>
      <h2 id="totalPendapatan" class="text-2xl font-bold mt-2">Rp 0</h2>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
      <p class="text-sm text-gray-500">Total Reservasi</p>
      <h2 id="totalReservasi" class="text-2xl font-bold mt-2">0</h2>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
      <p class="text-sm text-gray-500">Total Peserta</p>
      <h2 id="totalPeserta" class="text-2xl font-bold mt-2">0</h2>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
      <p class="text-sm text-gray-500">Conversion Rate</p>
      <h2 id="conversionRate" class="text-2xl font-bold mt-2">0%</h2>
    </div>

  </div>

  <!-- ================= CHART ================= -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <div class="bg-white p-6 rounded-xl shadow">
      <h3 class="font-bold mb-4">Pendapatan per Paket</h3>
      <canvas id="chartPendapatan" height="150"></canvas>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
      <h3 class="font-bold mb-4">Status Reservasi</h3>
      <canvas id="chartStatus" height="150"></canvas>
    </div>

    <div class="bg-white p-6 rounded-xl shadow md:col-span-2">
      <h3 class="font-bold mb-4">Growth Pemesanan & Peserta</h3>
      <canvas id="growthChart" height="120"></canvas>
    </div>


  </div>

  <!-- ================= TABLE ================= -->
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
      <tbody id="tablePerforma"></tbody>
    </table>
  </div>

</main>

<!-- ================= STYLE ================= -->
<style>
  .preset-btn {
    padding: 8px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
  }

  .preset-btn:hover {
    background: #eff6ff
  }

  .up {
    color: #16a34a;
    font-weight: 600
  }

  .down {
    color: #dc2626;
    font-weight: 600
  }

  .flat {
    color: #6b7280;
    font-weight: 600
  }
</style>

<!-- ================= SCRIPT ================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const bulan = document.getElementById('bulan')
  const tahun = document.getElementById('tahun')

  const totalPendapatan = document.getElementById('totalPendapatan')
  const totalReservasi = document.getElementById('totalReservasi')
  const totalPeserta = document.getElementById('totalPeserta')
  const conversionRate = document.getElementById('conversionRate')
  const tablePerforma = document.getElementById('tablePerforma')

  /* ===== CHART INIT ===== */
  const chartPendapatan = new Chart(
    document.getElementById('chartPendapatan'), {
    type: 'bar',
    data: { labels: [], datasets: [{ data: [], backgroundColor: '#3b82f6' }] },
    options: { plugins: { legend: { display: false } } }
  })

  const chartStatus = new Chart(
    document.getElementById('chartStatus'), {
    type: 'doughnut',
    data: { labels: [], datasets: [{ data: [], backgroundColor: ['#22c55e', '#facc15', '#ef4444', '#3b82f6'] }] },
    options: { plugins: { legend: { position: 'bottom' } } }
  })
  const growthChart = new Chart(
    document.getElementById('growthChart'),
    {
      type: 'line',
      data: {
        labels: [],
        datasets: [
          {
            label: 'Pemesanan',
            data: [],
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,.1)',
            tension: 0.4,
            fill: true
          },
          {
            label: 'Peserta',
            data: [],
            borderColor: '#22c55e',
            backgroundColor: 'rgba(34,197,94,.1)',
            tension: 0.4,
            fill: true
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'bottom' }
        }
      }
    }
  )


  /* ===== LOAD DATA ===== */
  function loadLaporan() {
    fetch("<?= base_url('admin/laporan/filter') ?>", {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ bulan: bulan.value, tahun: tahun.value })
    })
      .then(r => r.json())
      .then(updateUI)
  }

  /* ===== PRESET ===== */
  function preset(type) {
    const now = new Date()
    const m = now.getMonth() + 1
    const y = now.getFullYear()

    if (type === 'today' || type === 'month') {
      bulan.value = m
      tahun.value = y
    }

    if (type === 'year') {
      bulan.value = ''
      tahun.value = y
    }

    loadLaporan()
  }

  /* ===== UPDATE UI ===== */
  function updateUI(res) {
    totalPendapatan.innerText = 'Rp ' + res.total_pendapatan
    totalReservasi.innerText = res.total_reservasi
    totalPeserta.innerText = res.total_peserta
    conversionRate.innerText = res.conversion_rate + '%'

    chartPendapatan.data.labels = res.chart_paket.labels
    chartPendapatan.data.datasets[0].data = res.chart_paket.data
    chartPendapatan.update()

    chartStatus.data.labels = res.chart_status.labels
    chartStatus.data.datasets[0].data = res.chart_status.data
    chartStatus.update()

    growthChart.data.labels = res.growth.labels
    growthChart.data.datasets[0].data = res.growth.pemesanan
    growthChart.data.datasets[1].data = res.growth.peserta
    growthChart.update()


    tablePerforma.innerHTML = res.tabel
    const deltaReservasi = document.getElementById('deltaReservasi')
    const deltaPeserta = document.getElementById('deltaPeserta')

    deltaReservasi.innerText =
      (res.delta_reservasi > 0 ? '+' : '') + res.delta_reservasi
    deltaReservasi.className =
      res.delta_reservasi >= 0 ? 'text-green-600' : 'text-red-600'

    deltaPeserta.innerText =
      (res.delta_peserta > 0 ? '+' : '') + res.delta_peserta
    deltaPeserta.className =
      res.delta_peserta >= 0 ? 'text-green-600' : 'text-red-600'

  }

  /* ===== REALTIME ===== */
  bulan.addEventListener('change', loadLaporan)
  tahun.addEventListener('change', loadLaporan)
  setInterval(loadLaporan, 30000)

  /* ===== EXPORT ===== */
  function exportData(type) {
    window.open(
      `<?= site_url('admin/laporan/export_') ?>${type}?bulan=${bulan.value}&tahun=${tahun.value}`
    )
  }

  /* ===== LOAD AWAL ===== */
  loadLaporan()
</script>