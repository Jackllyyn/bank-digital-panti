
<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="space-y-6">
        <!-- Header & Selamat Datang -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">
                        Selamat Datang, <?php echo e(auth()->user()->name); ?>

                    </h1>
                    <p class="text-gray-600 text-sm mt-1">
                        <?php echo e($identitas->nama_panti ?? 'Panti Asuhan'); ?> • <?php echo e($identitas->alamat ?? ''); ?>

                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Tahun <?php echo e(date('Y')); ?></p>
                </div>
            </div>
        </div>

        <!-- Statistik Utama (4 Kartu Kecil) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 text-center">
                <p class="text-sm text-gray-600">Donasi Bulan Ini</p>
                <p class="text-xl font-bold text-green-700 mt-2">
                    Rp <?php echo e(number_format($donasiBulanIni, 0, ',', '.')); ?>

                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 text-center">
                <p class="text-sm text-gray-600">Pengeluaran Bulan Ini</p>
                <p class="text-xl font-bold text-red-700 mt-2">
                    Rp <?php echo e(number_format($pengeluaranBulanIni, 0, ',', '.')); ?>

                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 text-center">
                <p class="text-sm text-gray-600">Surplus/Defisit</p>
                <p class="text-xl font-bold <?php echo e($surplusBulanIni >= 0 ? 'text-green-700' : 'text-red-700'); ?> mt-2">
                    Rp <?php echo e(number_format(abs($surplusBulanIni), 0, ',', '.')); ?>

                    <span class="text-xs font-normal"><?php echo e($surplusBulanIni >= 0 ? '(Surplus)' : '(Defisit)'); ?></span>
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 text-center">
                <p class="text-sm text-gray-600">Anak Asuh Aktif</p>
                <p class="text-xl font-bold text-indigo-700 mt-2">
                    <?php echo e($totalAnakAktif); ?>

                </p>
            </div>
        </div>

        <!-- Anak Asuh - Laki-laki & Perempuan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <i class="fas fa-male text-4xl text-blue-600 mb-3"></i>
                <p class="text-sm text-gray-600">Laki-laki</p>
                <p class="text-3xl font-bold text-blue-700 mt-2">
                    <?php echo e($totalAnakLaki); ?>

                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <i class="fas fa-female text-4xl text-pink-600 mb-3"></i>
                <p class="text-sm text-gray-600">Perempuan</p>
                <p class="text-3xl font-bold text-pink-700 mt-2">
                    <?php echo e($totalAnakPerempuan); ?>

                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <i class="fas fa-users text-4xl text-indigo-600 mb-3"></i>
                <p class="text-sm text-gray-600">Total Anak Asuh</p>
                <p class="text-3xl font-bold text-indigo-700 mt-2">
                    <?php echo e($totalAnakAktif); ?>

                </p>
            </div>
        </div>

        <!-- Grafik Donasi vs Pengeluaran -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Donasi vs Pengeluaran (6 Bulan Terakhir)</h2>
            <div class="relative h-96">
                <canvas id="donasiPengeluaranChart"></canvas>
            </div>
        </div>

        <!-- Aktivitas Terakhir -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terakhir</h2>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $aktivitasTerakhir; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-start gap-4 text-sm">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 text-sm">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium"><?php echo e($log->causer?->name ?? 'System'); ?></p>
                            <p class="text-gray-600"><?php echo e($log->description); ?></p>
                            <p class="text-xs text-gray-500 mt-1"><?php echo e($log->created_at->diffForHumans()); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-6">Belum ada aktivitas</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('donasiPengeluaranChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($grafik->pluck('bulan'), 15, 512) ?>,
                datasets: [
                    {
                        label: 'Donasi',
                        data: <?php echo json_encode($grafik->pluck('donasi'), 15, 512) ?>,
                        backgroundColor: 'rgba(16, 185, 129, 0.85)',
                        hoverBackgroundColor: 'rgba(16, 185, 129, 1)',
                        borderColor: '#059669',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false,
                    },
                    {
                        label: 'Pengeluaran',
                        data: <?php echo json_encode($grafik->pluck('pengeluaran'), 15, 512) ?>,
                        backgroundColor: 'rgba(239, 68, 68, 0.85)',
                        hoverBackgroundColor: 'rgba(239, 68, 68, 1)',
                        borderColor: '#dc2626',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                weight: '600'
                            },
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'rectRounded'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: { size: 14 },
                        bodyFont: { size: 13 },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 0
                                    }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { size: 12 },
                            color: '#374151'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                }).format(value);
                            },
                            font: { size: 12 },
                            color: '#374151',
                            padding: 10
                        }
                    }
                }
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\web-panti\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>