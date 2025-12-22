
<?php $__env->startSection('title', 'Inventaris Barang Panti'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-5 bg-green-600 text-white">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-xl font-semibold">Inventaris Barang Panti</h1>
                    <p class="text-green-100 text-sm mt-1">
                        Total barang: <span class="font-bold"><?php echo e($inventaris->total()); ?></span> item
                    </p>
                </div>
                <a href="<?php echo e(route('admin.inventaris.create')); ?>"
                   class="inline-flex items-center px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i> Tambah Barang
                </a>
            </div>
        </div>

        <div class="p-6">
            <!-- Search -->
            <form method="GET" class="mb-6">
                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                           placeholder="Cari kode atau nama barang..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                    <button type="submit"
                            class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                        <i class="fas fa-search mr-2"></i> Cari
                    </button>
                    <?php if(request('search')): ?>
                        <a href="<?php echo e(route('admin.inventaris.index')); ?>"
                           class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                            Reset
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Kode</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Nama Barang</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Satuan</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-600 uppercase">Stok</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase">Harga Rata-rata</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase">Nilai Total</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-600 uppercase">Foto</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $inventaris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-center text-gray-600"><?php echo e($inventaris->firstItem() + $i); ?></td>
                                <td class="px-4 py-3 text-sm font-mono font-bold text-green-700"><?php echo e($item->kode_barang); ?></td>
                                <td class="px-4 py-3 text-sm font-medium"><?php echo e($item->nama_barang); ?></td>
                                <td class="px-4 py-3 text-sm text-gray-700"><?php echo e($item->satuan ?? '-'); ?></td>
                                <td class="px-4 py-3 text-center text-sm font-bold <?php echo e($item->stok <= 5 ? 'text-red-600' : 'text-green-600'); ?>">
                                    <?php echo e(number_format($item->stok, 0)); ?>

                                </td>
                                <td class="px-4 py-3 text-sm text-right">Rp <?php echo e(number_format($item->harga_rata2, 0, ',', '.')); ?></td>
                                <td class="px-4 py-3 text-sm text-right font-semibold text-indigo-600">
                                    Rp <?php echo e(number_format($item->stok * $item->harga_rata2, 0, ',', '.')); ?>

                                </td>
                                <td class="px-4 py-3 text-center">
                                    <?php if($item->foto): ?>
                                        <img src="<?php echo e(asset('storage/'.$item->foto)); ?>" class="h-12 w-12 object-cover rounded-lg mx-auto">
                                    <?php else: ?>
                                        <div class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto">
                                            <i class="fas fa-box text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 text-right space-x-3">
                                    <a href="<?php echo e(route('admin.inventaris.edit', $item->kode_barang)); ?>"
                                       class="text-green-600 hover:text-green-800 text-sm font-medium">Edit</a>
                                    <form action="<?php echo e(route('admin.inventaris.destroy', $item->kode_barang)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" onclick="return confirm('Yakin hapus <?php echo e($item->nama_barang); ?>?')"
                                                class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center py-12 text-gray-500 text-sm">
                                    <?php if(request('search')): ?>
                                        Tidak ditemukan barang dengan kata kunci "<?php echo e(request('search')); ?>"
                                    <?php else: ?>
                                        Belum ada data inventaris
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                <?php echo e($inventaris->appends(request()->query())->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\web-panti\resources\views/admin/inventaris/index.blade.php ENDPATH**/ ?>