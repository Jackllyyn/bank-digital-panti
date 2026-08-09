
<?php $__env->startSection('title', 'Penerimaan Donasi Barang'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Penerimaan Donasi Barang</h1>
        <a href="<?php echo e(route('admin.donasi-barang.index')); ?>" class="text-gray-600 hover:text-gray-900 text-sm flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6 lg:p-8">
        <form action="<?php echo e(route('admin.donasi-barang.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 gap-6">

                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal *</label>
                    <input type="date" name="tanggal" value="<?php echo e(old('tanggal', date('Y-m-d'))); ?>" required
                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                    <?php $__errorArgs = ['tanggal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Donatur (opsional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Donatur (opsional)</label>
                    <select name="kode_donatur" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                        <option value="">-- Umum / Tidak diketahui --</option>
                        <?php $__currentLoopData = $donaturs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($d->kode_donatur); ?>" <?php echo e(old('kode_donatur') == $d->kode_donatur ? 'selected' : ''); ?>>
                                <?php echo e($d->nama); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Akun Debet (Aset/Persediaan) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Akun Debet (Aset/Persediaan) *</label>
                    <select name="kode_akun_debet" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                        <option value="">-- Pilih Akun Debet --</option>
                        <?php $__currentLoopData = $akunDebet; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($ad->kode_akun); ?>" <?php echo e(old('kode_akun_debet') == $ad->kode_akun ? 'selected' : ''); ?>>
                                <?php echo e($ad->kode_akun); ?> - <?php echo e($ad->nama_akun); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Pilih akun Aset (misal: Persediaan Barang, Peralatan, Kendaraan) yang bertambah.</p>
                </div>

                <!-- Akun Pendapatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Akun Pendapatan *</label>
                    <select name="kode_akun" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                        <option value="">-- Pilih Akun Pendapatan --</option>
                        <?php $__currentLoopData = $akuns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $akun): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($akun->kode_akun); ?>" <?php echo e(old('kode_akun') == $akun->kode_akun ? 'selected' : ''); ?>>
                                <?php echo e($akun->kode_akun); ?> - <?php echo e($akun->nama_akun); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Dynamic Items Section -->
                <div x-data="{
                    items: <?php echo e(json_encode(old('items', [['barang_id' => '', 'qty' => 1, 'nilai_satuan' => 0, 'deskripsi_barang' => '']]))); ?>,
                    addItem() {
                        this.items.push({ barang_id: '', qty: 1, nilai_satuan: 0, deskripsi_barang: '' });
                    },
                    removeItem(index) {
                        if (this.items.length > 1) {
                            this.items.splice(index, 1);
                        }
                    },
                    formatRupiah(number) {
                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
                    },
                    get totalEstimasi() {
                        return this.items.reduce((sum, item) => sum + (item.qty * item.nilai_satuan), 0);
                    }
                }" class="border-t border-gray-200 pt-4">
                    
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Barang</h3>
                        <button type="button" @click="addItem()" class="text-sm bg-blue-50 text-blue-600 px-3 py-1 rounded hover:bg-blue-100 font-medium">
                            + Tambah Barang
                        </button>
                    </div>

                    <template x-for="(item, index) in items" :key="index">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                                <!-- Barang -->
                                <div class="md:col-span-4">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Barang *</label>
                                    <select :name="'items['+index+'][barang_id]'" x-model="item.barang_id" required class="block w-full border border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 p-2">
                                        <option value="">-- Pilih Barang --</option>
                                        <?php $__currentLoopData = $barangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($b->id); ?>"><?php echo e($b->nama_barang); ?> (<?php echo e($b->satuan); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Qty -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Qty *</label>
                                    <input type="number" :name="'items['+index+'][qty]'" x-model="item.qty" min="1" required class="block w-full border border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 p-2">
                                </div>

                                <!-- Nilai Satuan -->
                                <div class="md:col-span-3">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Nilai Satuan (Rp) *</label>
                                    <input type="number" :name="'items['+index+'][nilai_satuan]'" x-model="item.nilai_satuan" min="0" required class="block w-full border border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 p-2">
                                </div>

                                <!-- Deskripsi -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Ket. Barang (Opsional)</label>
                                    <input type="text" :name="'items['+index+'][deskripsi_barang]'" x-model="item.deskripsi_barang" placeholder="Merk/Kondisi" class="block w-full border border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 p-2">
                                </div>

                                <!-- Hapus -->
                                <div class="md:col-span-1 flex justify-center md:justify-end pb-0.5">
                                    <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="text-red-500 hover:text-red-700 p-2 rounded hover:bg-red-50 transition" title="Hapus baris">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="text-right font-bold text-gray-700 mt-2">
                        Total Estimasi Nilai: <span x-text="formatRupiah(totalEstimasi)" class="text-green-600 text-xl"></span>
                    </div>
                </div>

                <!-- Keterangan Umum (opsional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Umum (opsional)</label>
                    <textarea name="keterangan" rows="3" placeholder="Contoh: Donasi bulanan dari keluarga Bapak Ahmad"
                              class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2"><?php echo e(old('keterangan')); ?></textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <a href="<?php echo e(route('admin.donasi-barang.index')); ?>"
                   class="px-6 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                    Simpan Donasi Barang
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\web-panti\resources\views/admin/donasi-barang/create.blade.php ENDPATH**/ ?>