
<?php $__env->startSection('title', 'Daftar Donasi Barang'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

    <!-- Header + Tombol Tambah -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Penerimaan Donasi Barang</h1>
            <p class="text-sm text-gray-600 mt-1">Catat dan pantau semua donasi berupa barang yang masuk ke panti</p>
        </div>
        <a href="<?php echo e(route('admin.donasi-barang.create')); ?>"
           class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-green-700 transition focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Catat Donasi Barang Baru
        </a>
    </div>

    <!-- Filter Tanggal -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">
        <form method="GET" action="<?php echo e(route('admin.donasi-barang.index')); ?>" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end" x-data="dateFilter()">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" x-model="startDate"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                       value="<?php echo e(request('start_date')); ?>">
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" id="end_date" x-model="endDate"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                       value="<?php echo e(request('end_date')); ?>">
            </div>

            <div class="flex items-end gap-3">
                <button type="submit" class="px-6 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                    Filter
                </button>
                <button type="submit" formaction="<?php echo e(route('admin.donasi-barang.export.pdf')); ?>" formtarget="_blank" class="px-6 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition flex items-center gap-2">
                    <i class="fas fa-file-pdf"></i> PDF
                </button>
                <a href="<?php echo e(route('admin.donasi-barang.index')); ?>" class="text-gray-600 hover:text-gray-800 text-sm underline">Reset</a>
            </div>
        </form>
    </div>

    <!-- Tabel -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donatur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akun</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Qty</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Nilai (Rp)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petugas</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $donasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition donasi-row cursor-pointer" data-id="<?php echo e($donasi->id); ?>">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo e($donasi->no_transaksi); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo e($donasi->tanggal->format('d/m/Y')); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo e($donasi->donatur?->nama ?? 'Umum'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo e($donasi->akun?->nama_akun ?? $donasi->kode_akun); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?php $__currentLoopData = $donasi->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($detail->barang?->nama_barang ?? '-'); ?><br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <?php echo e(number_format($donasi->details_sum_qty ?? 0, 0, ',', '.')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-700">
                                Rp <?php echo e(number_format($donasi->details_sum_total_nilai ?? 0, 0, ',', '.')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo e($donasi->user?->name ?? 'Admin'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium flex justify-center items-center gap-2">
                                <a href="<?php echo e(route('admin.donasi-barang.show', $donasi->id)); ?>" 
                                   class="text-indigo-600 hover:text-indigo-900 detail-link" title="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <a href="<?php echo e(route('admin.donasi-barang.edit', $donasi->id)); ?>" 
                                   class="text-yellow-600 hover:text-yellow-900 detail-link" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00 2 2h11a2 2 0 00 2-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="<?php echo e(route('admin.donasi-barang.destroy', $donasi->id)); ?>" method="POST" class="inline-block detail-link" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data donasi ini? Stok dan jurnal akan dibatalkan.');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-4a2 2 0 00-2 2v1a2 2 0 01-2 2H8a2 2 0 01-2-2v-1a2 2 0 00-2-2H4"></path>
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada data donasi barang</p>
                                    <p class="mt-2 text-sm">Mulai dengan mencatat donasi barang baru menggunakan tombol di atas</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <?php echo e($donasis->appends(request()->query())->links('vendor.pagination.tailwind')); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('dateFilter', () => ({
        startDate: '<?php echo e(request('start_date')); ?>',
        endDate: '<?php echo e(request('end_date')); ?>',

        init() {
            this.$watch('startDate', value => {
                if (this.endDate && value > this.endDate) {
                    this.endDate = value;
                }
            });
            this.$watch('endDate', value => {
                if (this.startDate && value < this.startDate) {
                    this.startDate = value;
                }
            });
        }
    }));
});

document.addEventListener('DOMContentLoaded', function () {
    const rows = document.querySelectorAll('.donasi-row');
    
    rows.forEach(row => {
        row.addEventListener('click', function (event) {
            if (event.target.closest('.detail-link')) {
                return;
            }
            const id = row.getAttribute('data-id');
            if (id) {
                window.location.href = '/admin/donasi-barang/' + id + '/struk';
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\web-panti\resources\views/admin/donasi-barang/index.blade.php ENDPATH**/ ?>