<!DOCTYPE html>
<html>
<head>
    <title>Bukti Transaksi Barang Keluar</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; pb: 10px; }
        .title { font-size: 14pt; font-weight: bold; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #ccc; padding: 5px; }
        .no-border { border: none; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title"><?php echo e(strtoupper($identitas->nama_panti ?? 'PANTI ASUHAN')); ?></div>
        <div><?php echo e($identitas->alamat ?? 'Alamat Panti'); ?></div>
        <h3 style="margin-top: 15px;">BUKTI BARANG KELUAR</h3>
    </div>

    <table class="no-border">
        <tr class="no-border">
            <td class="no-border" width="150">No. Transaksi</td>
            <td class="no-border" width="10">:</td>
            <td class="no-border"><?php echo e($keluar->no_transaksi); ?></td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Tanggal</td>
            <td class="no-border">:</td>
            <td class="no-border"><?php echo e(\Carbon\Carbon::parse($keluar->tanggal)->format('d F Y')); ?></td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Keterangan</td>
            <td class="no-border">:</td>
            <td class="no-border"><?php echo e($keluar->keterangan); ?></td>
        </tr>
    </table>

    <h4>Detail Barang</h4>
    <table>
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo e($keluar->barang->kode_barang); ?></td>
                <td><?php echo e($keluar->barang->nama_barang); ?></td>
                <td class="text-center"><?php echo e($keluar->qty); ?></td>
                <td class="text-center"><?php echo e($keluar->barang->satuan); ?></td>
            </tr>
        </tbody>
    </table>

    <?php if($jurnals->count() > 0): ?>
    <h4>Catatan Akuntansi (Jurnal)</h4>
    <table>
        <thead>
            <tr>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th>Debet</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $jurnals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jurnal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($jurnal->kode_akun_debet); ?></td>
                <td><?php echo e($jurnal->akunDebet->nama_akun ?? '-'); ?></td>
                <td class="text-right"><?php echo e(number_format($jurnal->jumlah, 0, ',', '.')); ?></td>
                <td class="text-right">0</td>
            </tr>
            <tr>
                <td><?php echo e($jurnal->kode_akun_kredit); ?></td>
                <td><?php echo e($jurnal->akunKredit->nama_akun ?? '-'); ?></td>
                <td class="text-right">0</td>
                <td class="text-right"><?php echo e(number_format($jurnal->jumlah, 0, ',', '.')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php endif; ?>

    <div style="margin-top: 50px;">
        <table class="no-border">
            <tr class="no-border">
                <td class="no-border text-center" width="50%">
                    Diserahkan Oleh,<br><br><br><br>
                    (..........................)
                </td>
                <td class="no-border text-center" width="50%">
                    Dibuat Oleh,<br><br><br><br>
                    ( <?php echo e($keluar->user->name ?? 'Admin'); ?> )
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\web-panti\resources\views/admin/penjualan-pemakaian-barang/print.blade.php ENDPATH**/ ?>