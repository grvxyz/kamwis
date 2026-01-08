<?php if (empty($reservasi)) : ?>
    <div class="rounded-xl bg-white p-6 text-center shadow">
        <p class="text-gray-500">
            Tidak ada data reservasi
        </p>
    </div>
<?php else : ?>

<div class="overflow-x-auto rounded-xl bg-white shadow">
    <table class="w-full text-sm">
        <thead class="bg-gradient-to-r from-blue-600 to-green-500 text-white">
            <tr>
                <th class="px-4 py-3 text-left">Paket</th>
                <th class="px-4 py-3 text-center">Tanggal</th>
                <th class="px-4 py-3 text-center">Jam</th>
                <th class="px-4 py-3 text-center">Peserta</th>
                <th class="px-4 py-3 text-center">Total</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Pembayaran</th>
            </tr>
        </thead>

        <tbody class="divide-y">
        <?php foreach ($reservasi as $r) : ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 font-medium text-gray-800">
                    <?= $r->nama_paket ?>
                </td>

                <td class="px-4 py-3 text-center">
                    <?= date('d M Y', strtotime($r->tanggal_kunjungan)) ?>
                </td>

                <td class="px-4 py-3 text-center">
                    <?= $r->jam_kunjungan ? substr($r->jam_kunjungan, 0, 5) : '-' ?>
                </td>

                <td class="px-4 py-3 text-center">
                    <?= $r->jumlah_peserta ?> org
                </td>

                <td class="px-4 py-3 text-center font-semibold text-green-600">
                    Rp <?= number_format($r->total_harga, 0, ',', '.') ?>
                </td>

                <td class="px-4 py-3 text-center">
                    <?php
                        $statusBadge = [
                            'Pending'        => 'bg-yellow-100 text-yellow-700',
                            'Dikonfirmasi'   => 'bg-blue-100 text-blue-700',
                            'Dibatalkan'    => 'bg-red-100 text-red-700',
                            'Selesai'        => 'bg-green-100 text-green-700'
                        ];
                    ?>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        <?= $statusBadge[$r->status] ?? 'bg-gray-100 text-gray-600' ?>">
                        <?= $r->status ?>
                    </span>
                </td>

                <td class="px-4 py-3 text-center">
                    <?php
                        $payBadge = [
                            'pending'     => 'bg-yellow-100 text-yellow-700',
                            'settlement'  => 'bg-green-100 text-green-700',
                            'expire'      => 'bg-red-100 text-red-700'
                        ];
                    ?>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        <?= $payBadge[$r->payment_status] ?? 'bg-gray-100 text-gray-600' ?>">
                        <?= ucfirst($r->payment_status) ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php endif; ?>
