
<?php $__env->startSection('title', 'Jurnal Umum'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <!-- Header + Tombol Export -->
        <div class="px-6 py-5 bg-green-50 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Jurnal Umum</h1>
                <p class="text-sm text-gray-600 mt-1">Semua transaksi tercatat otomatis termasuk donasi barang</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="<?php echo e(route('admin.jurnal-umum.export.excel')); ?>" 
                   class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition flex items-center gap-2 shadow-sm">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
                <a href="<?php echo e(route('admin.jurnal-umum.export.pdf')); ?>" 
                   class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition flex items-center gap-2 shadow-sm">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>
        </div>

        <!-- Filter -->
        <div class="p-6" x-data="jurnalFilter()">
            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    
                    <!-- Dari Tanggal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" x-model="dari" @change="applyFilter()" 
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 focus:border-green-400">
                    </div>

                    <!-- Sampai Tanggal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" x-model="sampai" @change="applyFilter()" 
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 focus:border-green-400">
                    </div>

                    <!-- Akun -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Akun</label>
                        <select x-model="akun" @change="applyFilter()" 
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 focus:border-green-400">
                            <option value="">Semua Akun</option>
                            <?php $__currentLoopData = $akuns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($a->kode_akun); ?>"><?php echo e($a->kode_akun); ?> - <?php echo e($a->nama_akun); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Sumber Transaksi -->
                    <div>
                        <label for="sumber" class="block text-sm font-medium text-gray-700 mb-1">Sumber Transaksi</label>
                        <select x-model="sumber" @change="applyFilter()" id="sumber"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 focus:border-green-400">
                            <option value="">-- Semua --</option>
                            <option value="donasi_barang">Donasi Barang</option>
                            <option value="donasi_uang">Donasi Uang/Tunai</option>
                            <option value="manual">Input Manual / Lainnya</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tabel Jurnal -->
            <div class="mt-6 overflow-x-auto rounded-lg border border-gray-200 bg-white">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium text-gray-700">Tanggal</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-700">No. Transaksi</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-700">Uraian</th>
                            <th class="px-6 py-3 text-right font-medium text-gray-700">Debet</th>
                            <th class="px-6 py-3 text-right font-medium text-gray-700">Kredit</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-700">User</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php $__empty_1 = true; $__currentLoopData = $jurnals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-green-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-800">
                                    <?php echo e($j->tanggal->translatedFormat('d M Y')); ?>

                                </td>
                                <td class="px-6 py-4 font-mono text-green-700 whitespace-nowrap">
                                    <?php echo e($j->no_transaksi); ?>

                                    <?php if(str_starts_with($j->no_transaksi, 'JU-DB-')): ?>
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-box-open mr-1"></i>Donasi
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    <?php echo e($j->uraian); ?>

                                </td>
                                <td class="px-6 py-4 text-right font-medium">
                                    <?php if($j->akunDebet): ?>
                                        <div class="text-green-600">
                                            Rp <?php echo e(number_format($j->jumlah, 0, ',', '.')); ?>

                                            <div class="text-xs text-gray-500 mt-0.5">
                                                <?php echo e($j->akunDebet->kode_akun); ?> - <?php echo e(Str::limit($j->akunDebet->nama_akun, 25)); ?>

                                            </div>
                                        </div>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-right font-medium">
                                    <?php if($j->akunKredit): ?>
                                        <div class="text-red-600">
                                            Rp <?php echo e(number_format($j->jumlah, 0, ',', '.')); ?>

                                            <div class="text-xs text-gray-500 mt-0.5">
                                                <?php echo e($j->akunKredit->kode_akun); ?> - <?php echo e(Str::limit($j->akunKredit->nama_akun, 25)); ?>

                                            </div>
                                        </div>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500">
                                    <?php echo e($j->user->name ?? 'Sistem'); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-16 text-gray-400">
                                    Belum ada data jurnal untuk periode ini
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                <?php echo e($jurnals->withQueryString()->links('vendor.pagination.tailwind')); ?>

            </div>
        </div>
    </div>
</div>

<script>
function jurnalFilter() {
    return {
        dari: '<?php echo e(request('dari')); ?>',
        sampai: '<?php echo e(request('sampai')); ?>',
        akun: '<?php echo e(request('akun')); ?>',
        sumber: '<?php echo e(request('sumber')); ?>',

        applyFilter() {
            const params = new URLSearchParams();
            if (this.dari)    params.append('dari', this.dari);
            if (this.sampai)  params.append('sampai', this.sampai);
            if (this.akun)    params.append('akun', this.akun);
            if (this.sumber)  params.append('sumber', this.sumber);
            window.location.search = params.toString();
        }
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\web-panti\resources\views/admin/jurnal-umum/index.blade.php ENDPATH**/ ?>