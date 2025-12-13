@extends('layouts.app')
@section('title', 'Tambah Aset Tetap')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-5 bg-green-600 text-white">
            <div class="flex items-center">
                <a href="{{ route('admin.aset-tetap.index') }}" class="mr-4 text-white hover:text-green-100">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-xl font-semibold">Tambah Aset Tetap</h1>
                    <p class="text-green-100 text-sm mt-1">Masukkan data aset tetap panti</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.aset-tetap.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kode Aset *</label>
                    <input type="text" name="kode_aset" value="{{ old('kode_aset') }}" required
                           placeholder="AST-001" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                    @error('kode_aset') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Aset *</label>
                    <input type="text" name="nama_aset" value="{{ old('nama_aset') }}" required
                           placeholder="Gedung Panti Asuhan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                    @error('nama_aset') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Perolehan *</label>
                    <input type="date" name="tanggal_perolehan" value="{{ old('tanggal_perolehan') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga Perolehan (Rp) *</label>
                    <input type="number" name="harga_perolehan" value="{{ old('harga_perolehan') }}" step="0.01" required
                           placeholder="500000000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Masa Manfaat (Tahun)</label>
                    <input type="number" name="masa_manfaat_tahun" value="{{ old('masa_manfaat_tahun') }}" min="1"
                           placeholder="20" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nilai Residu (Opsional)</label>
                    <input type="number" name="nilai_residu" value="{{ old('nilai_residu', 0) }}" step="0.01"
                           placeholder="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="3" placeholder="Contoh: Dibeli dari hibah yayasan tahun 2020"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">{{ old('keterangan') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Aset (Opsional)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition">
                    <input type="file" name="foto" accept="image/*" class="hidden" id="foto" onchange="previewFoto(event)">
                    <label for="foto" class="cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-600 text-sm">Klik untuk upload foto</p>
                        <p class="text-xs text-gray-500 mt-1">PNG/JPG max 2MB</p>
                    </label>
                    <div id="preview" class="mt-4 hidden">
                        <img id="preview-img" class="mx-auto max-h-48 rounded-lg shadow-sm">
                    </div>
                </div>
                @error('foto') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.aset-tetap.index') }}"
                   class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewFoto(event) {
    const preview = document.getElementById('preview');
    const img = document.getElementById('preview-img');
    if (event.target.files[0]) {
        img.src = URL.createObjectURL(event.target.files[0]);
        preview.classList.remove('hidden');
    }
}
</script>
@endsection