
<?php $__env->startSection('title', 'Daftar Akun'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 bg-green-600 text-white">
            <h1 class="text-2xl font-semibold">Daftar Akun Perkiraan</h1>
            <p class="text-green-100 mt-1">Master data akuntansi Panti Muhammadiyah Pesantunan</p>
        </div>

        <!-- Konten -->
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <p class="text-sm text-gray-600">
                        Total: <span class="font-semibold text-green-700"><?php echo e($akuns->count()); ?></span> akun
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        Saldo awal ditampilkan untuk tahun <span class="font-medium"><?php echo e($tahun); ?></span>
                    </p>
                </div>
                <a href="<?php echo e(route('admin.daftar-akun.create')); ?>"
                   class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                    <i class="fas fa-plus mr-2"></i> Tambah Akun
                </a>
            </div>

            <?php if($akuns->isEmpty()): ?>
                <div class="text-center py-12 text-gray-500">
                    Belum ada data akun. Silakan tambahkan akun baru.
                </div>
            <?php else: ?>
                <div class="space-y-6">
                    <?php $__currentLoopData = ['ASET', 'LIABILITAS', 'EKUITAS', 'PENDAPATAN', 'BEBAN']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelompok): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $data = $akuns->where('kelompok', $kelompok); ?>
                        <?php if($data->count()): ?>
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <!-- Judul Kelompok -->
                                <div class="bg-green-50 px-6 py-4 font-medium text-green-800 border-b border-gray-200">
                                    <?php echo e($kelompok); ?>

                                </div>

                                <!-- Daftar Akun -->
                                <div class="divide-y divide-gray-100">
                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $akun): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $saldo = $akun->saldoAwal->first()?->saldo ?? 0;
                                        ?>
                                        <div class="px-6 py-4 flex justify-between items-center hover:bg-gray-50 transition">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-4">
                                                    <span class="font-mono font-semibold text-gray-900 w-20"><?php echo e($akun->kode_akun); ?></span>
                                                    <span class="text-gray-800 font-medium"><?php echo e($akun->nama_akun); ?></span>
                                                </div>
                                                <div class="mt-1 flex flex-wrap items-center gap-4 text-sm">
                                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($akun->posisi_saldo == 'DEBET' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                                        <?php echo e($akun->posisi_saldo); ?>

                                                    </span>
                                                    <span class="text-gray-600">
                                                        Saldo awal <?php echo e($tahun); ?>:
                                                        <span class="font-semibold text-gray-900">
                                                            Rp <?php echo e(number_format($saldo, 0, ',', '.')); ?>

                                                        </span>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="flex gap-4">
                                                <a href="<?php echo e(route('admin.daftar-akun.edit', $akun->kode_akun)); ?>"
                                                   class="text-green-600 hover:text-green-800 transition">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="<?php echo e(route('admin.daftar-akun.destroy', $akun->kode_akun)); ?>" method="POST" class="inline">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus akun ini? Data terkait mungkin ikut terpengaruh.')"
                                                            class="text-red-600 hover:text-red-800 transition">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\web-panti\resources\views/admin/daftar-akun/index.blade.php ENDPATH**/ ?>