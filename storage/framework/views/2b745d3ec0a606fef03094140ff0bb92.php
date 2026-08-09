
<?php $__env->startSection('title', 'Daftar Barang / Persediaan'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

    <!-- Header + Tombol Tambah -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Master Barang / Persediaan</h1>
            <p class="text-sm text-gray-600 mt-1">Kelola daftar barang yang tersedia di panti asuhan</p>
        </div>
        <a href="<?php echo e(route('admin.barang.create')); ?>"
           class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-green-700 transition focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Barang Baru
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">
        <form method="GET" action="<?php echo e(route('admin.barang.index')); ?>" class="flex flex-col sm:flex-row sm:items-end gap-4">
            <div class="flex-1">
                <label for="filter" class="block text-sm font-medium text-gray-700 mb-1">Filter Kode / Nama Barang</label>
                <input type="text" name="filter" id="filter" value="<?php echo e(request('filter')); ?>"
                       placeholder="Contoh: KB2510001, BERAS, MINYAK..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
            </div>
            <div class="flex items-end gap-3">
                <button type="submit" class="px-6 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                    Filter
                </button>
                <?php if(request('filter')): ?>
                    <a href="<?php echo e(route('admin.barang.index')); ?>" class="text-gray-600 hover:text-gray-800 text-sm underline">Reset</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Tabel -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Saat Ini</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $barangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo e($barang->kode_barang); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($barang->nama_barang); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($barang->satuan ?? 'unit'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e(ucfirst($barang->kategori ?? '-')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold <?php echo e($barang->stok_real <= 0 ? 'text-red-600' : 'text-green-700'); ?>">
                                <?php echo e(number_format($barang->stok_real, 0, ',', '.')); ?>

                                <?php if($barang->stok_real <= 0): ?>
                                    <span class="text-xs text-red-500 ml-1">(Habis)</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="<?php echo e(route('admin.barang.edit', $barang->id)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="<?php echo e(route('admin.barang.destroy', $barang->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus <?php echo e(addslashes($barang->nama_barang)); ?>?')"
                                            class="text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-4a2 2 0 00-2 2v1a2 2 0 01-2 2H8a2 2 0 01-2-2v-1a2 2 0 00-2-2H4"></path>
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada data barang</p>
                                    <p class="mt-2 text-sm">Tambahkan barang baru dengan tombol di atas</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <?php echo e($barangs->appends(request()->query())->links('vendor.pagination.tailwind')); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\web-panti\resources\views/admin/barang/index.blade.php ENDPATH**/ ?>