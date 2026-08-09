
<?php $__env->startSection('title', 'Laporan Keuangan'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-4 bg-green-600 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
            <div>
                <h1 class="text-lg font-semibold">Laporan Keuangan</h1>
                <p class="text-green-100 text-xs mt-1">Neraca & Laba Rugi — Otomatis dari jurnal & saldo awal</p>
            </div>
            <div class="flex gap-2">
                <form method="GET" action="<?php echo e(route('admin.laporan.index')); ?>" class="flex items-center gap-2 bg-white/10 p-1 rounded-lg">
                    <input type="date" name="tgl_awal" value="<?php echo e($tglAwal); ?>" class="text-gray-800 text-xs rounded border-0 py-1 px-2 focus:ring-1 focus:ring-green-300">
                    <span class="text-xs">s/d</span>
                    <input type="date" name="tgl_akhir" value="<?php echo e($tglAkhir); ?>" class="text-gray-800 text-xs rounded border-0 py-1 px-2 focus:ring-1 focus:ring-green-300">
                    <button type="submit" class="bg-green-800 hover:bg-green-900 text-white text-xs px-3 py-1 rounded transition">
                        <i class="fas fa-filter"></i>
                    </button>
                </form>
            </div>
            <div class="flex gap-2">
                <a href="<?php echo e(route('admin.laporan.excel', request()->query())); ?>"
                   class="px-4 py-1.5 bg-white text-green-700 rounded-lg hover:bg-green-100 transition text-xs font-medium flex items-center gap-1">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
                <a href="<?php echo e(route('admin.laporan.pdf', request()->query())); ?>"
                   target="_blank"
                   class="px-4 py-1.5 bg-white text-red-700 rounded-lg hover:bg-red-100 transition text-xs font-medium flex items-center gap-1">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
                <a href="<?php echo e(route('admin.laporan.neraca-saldo-penutupan')); ?>"
                   class="px-4 py-1.5 bg-white text-gray-700 rounded-lg hover:bg-gray-100 transition text-xs font-medium flex items-center gap-1">
                    <i class="fas fa-book"></i> Neraca Setelah Penutupan
                </a>
                
            </div>
        </div>

        <div class="p-5 space-y-6">
            <!-- Grafik Neraca (sangat kecil) -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <h2 class="text-sm font-semibold text-gray-800 mb-2">Posisi Keuangan (Neraca)</h2>
                <canvas id="neracaChart" height="100"></canvas>
            </div>

            <!-- Grafik Laba Rugi (sangat kecil) -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <h2 class="text-sm font-semibold text-gray-800 mb-2">Laba / Rugi Tahun Ini</h2>
                <canvas id="labarugiChart" height="100"></canvas>
            </div>

            <!-- Tabel Neraca (lebih compact) -->
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th colspan="2" class="px-4 py-2 text-left text-sm font-semibold text-gray-800">NERACA</th>
                        </tr>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Keterangan</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 uppercase">Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $aset = 0; $liabilitas = 0; $ekuitas = 0; ?>

                        <?php $__currentLoopData = $akuns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $akun): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($saldoAkhir[$akun->kode_akun])): ?>
                                <?php
                                    $saldo = $saldoAkhir[$akun->kode_akun];
                                    $display = number_format($saldo, 0, ',', '.');
                                ?>

                                <?php if($akun->kelompok == 'ASET'): ?>
                                    <?php $aset += $saldo; ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2"><?php echo e($akun->kode_akun); ?> - <?php echo e($akun->nama_akun); ?></td>
                                        <td class="px-4 py-2 text-right font-medium"><?php echo e($display); ?></td>
                                    </tr>
                                <?php elseif($akun->kelompok == 'LIABILITAS'): ?>
                                    <?php $liabilitas += $saldo; ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2"><?php echo e($akun->kode_akun); ?> - <?php echo e($akun->nama_akun); ?></td>
                                        <td class="px-4 py-2 text-right font-medium"><?php echo e($display); ?></td>
                                    </tr>
                                <?php elseif($akun->kelompok == 'EKUITAS'): ?>
                                    <?php $ekuitas += $saldo; ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2"><?php echo e($akun->kode_akun); ?> - <?php echo e($akun->nama_akun); ?></td>
                                        <td class="px-4 py-2 text-right font-medium"><?php echo e($display); ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <tr class="bg-gray-100 font-semibold">
                            <td class="px-4 py-2 text-xs">TOTAL ASET</td>
                            <td class="px-4 py-2 text-right text-xs text-green-700"><?php echo e(number_format($aset, 0, ',', '.')); ?></td>
                        </tr>
                        <tr class="bg-gray-100 font-semibold">
                            <td class="px-4 py-2 text-xs">TOTAL LIABILITAS + EKUITAS</td>
                            <td class="px-4 py-2 text-right text-xs text-green-700"><?php echo e(number_format($liabilitas + $ekuitas, 0, ',', '.')); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tabel Laba Rugi (lebih compact) -->
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th colspan="2" class="px-4 py-2 text-left text-sm font-semibold text-gray-800">LAPORAN AKTIVITAS RUGI LABA</th>
                        </tr>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Keterangan</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 uppercase">Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $pendapatan = 0; $beban = 0; ?>

                        <?php $__currentLoopData = $akuns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $akun): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($saldoAkhir[$akun->kode_akun])): ?>
                                <?php
                                    $saldo = $saldoAkhir[$akun->kode_akun];
                                    $display = number_format($saldo, 0, ',', '.');
                                ?>

                                <?php if($akun->kelompok == 'PENDAPATAN'): ?>
                                    <?php $pendapatan += $saldo; ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2"><?php echo e($akun->kode_akun); ?> - <?php echo e($akun->nama_akun); ?></td>
                                        <td class="px-4 py-2 text-right font-medium"><?php echo e($display); ?></td>
                                    </tr>
                                <?php elseif($akun->kelompok == 'BEBAN'): ?>
                                    <?php $beban += $saldo; ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2"><?php echo e($akun->kode_akun); ?> - <?php echo e($akun->nama_akun); ?></td>
                                        <td class="px-4 py-2 text-right font-medium"><?php echo e($display); ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <tr class="bg-gray-100 font-semibold">
                            <td class="px-4 py-2 text-xs">TOTAL PENDAPATAN</td>
                            <td class="px-4 py-2 text-right text-xs text-green-700"><?php echo e(number_format($pendapatan, 0, ',', '.')); ?></td>
                        </tr>
                        <tr class="bg-gray-100 font-semibold">
                            <td class="px-4 py-2 text-xs">TOTAL BEBAN</td>
                            <td class="px-4 py-2 text-right text-xs text-red-700"><?php echo e(number_format($beban, 0, ',', '.')); ?></td>
                        </tr>
                        <tr class="bg-gray-200 font-bold text-sm">
                            <td class="px-4 py-2 text-xs">LABA / (RUGI) BERSIH</td>
                            <td class="px-4 py-2 text-right <?php echo e(($pendapatan - $beban) >= 0 ? 'text-green-700' : 'text-red-700'); ?>">
                                <?php echo e(number_format($pendapatan - $beban, 0, ',', '.')); ?>

                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="text-green-100 text-xs mt-1">Neraca & Laba Rugi — Otomatis dari jurnal & saldo awal</p>
            </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN + Script Grafik (ukuran kecil) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const aset       = <?php echo e($aset ?? 0); ?>;
    const liabilitas = <?php echo e($liabilitas ?? 0); ?>;
    const ekuitas    = <?php echo e($ekuitas ?? 0); ?>;
    const pendapatan = <?php echo e($pendapatan ?? 0); ?>;
    const beban      = <?php echo e($beban ?? 0); ?>;

    // Grafik Neraca – sangat kecil
    new Chart(document.getElementById('neracaChart'), {
        type: 'bar',
        data: {
            labels: ['Aset', 'Liabilitas', 'Ekuitas'],
            datasets: [{
                label: 'Saldo Akhir (Rp)',
                data: [aset, liabilitas, ekuitas],
                backgroundColor: ['#10b981', '#ef4444', '#8b5cf6'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Grafik Laba Rugi – sangat kecil
    new Chart(document.getElementById('labarugiChart'), {
        type: 'bar',
        data: {
            labels: ['Pendapatan', 'Beban'],
            datasets: [{
                label: 'Jumlah (Rp)',
                data: [pendapatan, beban],
                backgroundColor: ['#10b981', '#ef4444'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\web-panti\resources\views/admin/laporan/index.blade.php ENDPATH**/ ?>