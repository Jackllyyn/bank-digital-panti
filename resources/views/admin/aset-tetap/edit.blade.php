@extends('layouts.app')
@section('title', 'Edit Aset Tetap')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-5 bg-green-600 text-white">
            <div class="flex items-center">
                <a href="{{ route('admin.aset-tetap.index') }}" class="mr-4 text-white hover:text-green-100">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-xl font-semibold">Edit Aset Tetap</h1>
                    <p class="text-green-100 text-sm mt-1">{{ $aset->nama_aset }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.aset-tetap.update', $aset->kode_aset) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf @method('PUT')
            <input type="hidden" name="old_foto" value="{{ $aset->foto }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kode Aset</label>
                    <input type="text" name="kode_aset" value="{{ old('kode_aset', $aset->kode_aset) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Aset</label>
                    <input type="text" name="nama_aset" value="{{ old('nama_aset', $aset->nama_aset) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Perolehan</label>
                    <input type="date" name="tanggal_perolehan" value="{{ old('tanggal_perolehan', $aset->tanggal_perolehan) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga Perolehan (Rp)</label>
                    <input type="number" name="harga_perolehan" value="{{ old('harga_perolehan', $aset->harga_perolehan) }}" step="0.01" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Masa Manfaat (Tahun)</label>
                    <input type="number" name="masa_manfaat_tahun" value="{{ old('masa_manfaat_tahun', $aset->masa_manfaat_tahun) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nilai Residu</label>
                    <input type="number" name="nilai_residu" value="{{ old('nilai_residu', $aset->nilai_residu) }}" step="0.01"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">{{ old('keterangan', $aset->keterangan) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Aset Saat Ini</label>
                @if($aset->foto)
                    <img src="{{ asset('storage/' . $aset->foto) }}" alt="Foto aset" class="h-48 rounded-lg shadow-sm mb-3 object-cover">
                    <p class="text-xs text-gray-500">Ganti foto (kosongkan jika tidak ingin mengganti)</p>
                @else
                    <p class="text-gray-500 italic text-sm">Belum ada foto</p>
                @endif

                <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition">
                    <input type="file" name="foto" accept="image/*" class="hidden" id="foto-edit" onchange="previewEdit(event)">
                    <label for="foto-edit" class="cursor-pointer">
                        <i class="fas fa-camera text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-600 text-sm">Upload foto baru</p>
                    </label>
                    <div id="preview-edit" class="mt-4 hidden">
                        <img id="preview-img-edit" class="mx-auto max-h-48 rounded-lg shadow-sm">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.aset-tetap.index') }}"
                   class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium flex items-center gap-2">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewEdit(event) {
    const preview = document.getElementById('preview-edit');
    const img = document.getElementById('preview-img-edit');
    if (event.target.files[0]) {
        img.src = URL.createObjectURL(event.target.files[0]);
        preview.classList.remove('hidden');
    }
}
</script>
@endsection