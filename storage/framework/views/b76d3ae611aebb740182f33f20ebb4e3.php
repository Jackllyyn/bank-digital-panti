
<?php $__env->startSection('title', 'Identitas Panti'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto py-8 px-4">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
            <i class="fas fa-building text-emerald-600"></i>
            Identitas Panti & Yayasan
        </h1>
        <p class="text-sm text-gray-600 mt-1">Kelola data resmi panti untuk laporan dan dokumen</p>
    </div>

    <!-- Notifikasi -->
    <?php if(session('success')): ?>
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-lg text-sm">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-lg text-sm">
            <ul class="list-disc list-inside">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <form action="<?php echo e(route('admin.identitas-panti.update')); ?>" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="p-6 space-y-8">

            <!-- Logo Panti (TAMPILKAN YANG SUDAH DIUPLOAD) -->
            <div class="flex items-center gap-8 bg-gray-50 rounded-lg p-6">
                <div class="flex-shrink-0">
                    <?php if($identitas->logo && Storage::disk('public')->exists($identitas->logo)): ?>
                        <img src="<?php echo e(asset('storage/' . $identitas->logo)); ?>"
                             alt="Logo Panti"
                             class="w-40 h-40 object-contain rounded-lg border-2 border-gray-300 shadow-md">
                    <?php else: ?>
                        <div class="w-40 h-40 bg-gray-200 border-2 border-dashed border-gray-400 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-5xl text-gray-400"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Logo Panti Saat Ini</h3>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ganti Logo Baru</label>
                    <input type="file" name="logo" accept="image/*"
                           class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, GIF. Maksimal 2MB. Disarankan ukuran 400×400 px</p>
                    <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Informasi Umum -->
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-5 border-b pb-2">Informasi Umum</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Yayasan</label>
                        <input type="text" name="nama_yayasan" value="<?php echo e(old('nama_yayasan', $identitas->nama_yayasan)); ?>" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Panti Asuhan</label>
                        <input type="text" name="nama_panti" value="<?php echo e(old('nama_panti', $identitas->nama_panti)); ?>" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"><?php echo e(old('alamat', $identitas->alamat)); ?></textarea>
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-2">Kota</label>
                        <input type="text" name="kota" value="<?php echo e(old('kota', $identitas->kota)); ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-2">Kode Pos</label>
                        <input type="text" name="kode_pos" value="<?php echo e(old('kode_pos', $identitas->kode_pos)); ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-2">Pimpinan</label>
                        <input type="text" name="pimpinan" value="<?php echo e(old('pimpinan', $identitas->pimpinan)); ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-2">Bendahara</label>
                        <input type="text" name="bendahara" value="<?php echo e(old('bendahara', $identitas->bendahara)); ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>
            </div>

            <!-- Kontak & Rekening -->
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-5 border-b pb-2">Kontak & Rekening</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div><label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                        <input type="text" name="telepon" value="<?php echo e(old('telepon', $identitas->telepon)); ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="<?php echo e(old('email', $identitas->email)); ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                        <input type="text" name="website" value="<?php echo e(old('website', $identitas->website)); ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-2">NPWP</label>
                        <input type="text" name="npwp" value="<?php echo e(old('npwp', $identitas->npwp)); ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 font-mono">
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-2">Nama Bank</label>
                        <input type="text" name="nama_bank" value="<?php echo e(old('nama_bank', $identitas->nama_bank)); ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-2">Nomor Rekening</label>
                        <input type="text" name="no_rekening" value="<?php echo e(old('no_rekening', $identitas->no_rekening)); ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 font-mono">
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end pt-6 border-t">
                <button type="submit"
                        class="px-8 py-3 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition shadow-sm flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\web-panti\resources\views/admin/identitas-panti/edit.blade.php ENDPATH**/ ?>