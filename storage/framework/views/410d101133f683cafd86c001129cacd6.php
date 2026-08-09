
<?php $__env->startSection('title', 'Detail Donasi - ' . $donasi->no_transaksi); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Detail Donasi Barang</h1>
            <a href="<?php echo e(route('admin.donasi-barang.struk', $donasi->id)); ?>" 
               class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                Cetak Struk
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <strong>No Transaksi:</strong> <?php echo e($donasi->no_transaksi); ?><br>
                <strong>Tanggal:</strong> <?php echo e($donasi->tanggal->format('d F Y')); ?><br>
                <strong>Donatur:</strong> <?php echo e($donasi->donatur?->nama ?? 'Umum'); ?>

            </div>
            <div>
                <strong>Petugas:</strong> <?php echo e($donasi->user?->name ?? 'Admin'); ?><br>
                <strong>Keterangan:</strong> <?php echo e($donasi->keterangan ?? '-'); ?>

            </div>
        </div>

        <h2 class="text-xl font-semibold mb-4">Detail Barang</h2>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-3">Barang</th>
                    <th class="border p-3">Deskripsi</th>
                    <th class="border p-3 text-right">Qty</th>
                    <th class="border p-3 text-right">Satuan</th>
                    <th class="border p-3 text-right">Nilai per Unit (Rp)</th>
                    <th class="border p-3 text-right">Total Nilai (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $donasi->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="border p-3"><?php echo e($detail->barang?->nama_barang ?? '-'); ?></td>
                        <td class="border p-3"><?php echo e($detail->deskripsi_barang ?? '-'); ?></td>
                        <td class="border p-3 text-right"><?php echo e(number_format($detail->qty, 0, ',', '.')); ?></td>
                        <td class="border p-3 text-right"><?php echo e($detail->barang?->satuan ?? 'unit'); ?></td>
                        <td class="border p-3 text-right"><?php echo e(number_format($detail->nilai_satuan ?? 0, 0, ',', '.')); ?></td>
                        <td class="border p-3 text-right"><?php echo e(number_format($detail->total_nilai ?? 0, 0, ',', '.')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <div class="mt-6 text-right font-semibold">
            Total Qty: <?php echo e(number_format($donasi->details->sum('qty'), 0, ',', '.')); ?><br>
            Total Nilai Donasi: Rp <?php echo e(number_format($donasi->details->sum('total_nilai'), 0, ',', '.')); ?>

        </div>

        <div class="mt-10 flex justify-center gap-16 text-center">
            <div>
                <p class="mb-16">Mengetahui,<br>Pimpinan Panti</p>
                <p>(..........................................)</p>
            </div>
            <div>
                <p class="mb-16">Donatur / Pemberi</p>
                <p><?php echo e($donasi->donatur?->nama ?? '..........................................'); ?></p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\web-panti\resources\views/admin/donasi-barang/show.blade.php ENDPATH**/ ?>