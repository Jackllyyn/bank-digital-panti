@extends('layouts.app')
@section('title', 'Edit Inventaris: ' . $inventari->nama_barang)

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-5 bg-green-600 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('admin.inventaris.index') }}" class="mr-4 text-white hover:text-green-100">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <div>
                        <h1 class="text-xl font-semibold">Edit Barang Inventaris</h1>
                        <p class="text-green-100 text-sm mt-1">{{ $inventari->nama_barang }}</p>
                    </div>
                </div>
                <p class="text-sm">Kode: <span class="font-bold">{{ $inventari->kode_barang }}</span></p>
            </div>
        </div>

        <form action="{{ route('admin.inventaris.update', $inventari->kode_barang) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <!-- Foto -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Barang Saat Ini</label>
                    @if($inventari->foto)
                        <img src="{{ asset('storage/'.$inventari->foto) }}" class="h-48 w-48 object-cover rounded-lg shadow-sm mx-auto mb-3">
                    @else
                        <div class="h-48 w-48 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-box text-5xl text-gray-400"></i>
                        </div>
                    @endif

                    <label class="block text-sm font-medium text-gray-700 mb-2 mt-4">Ganti Foto (Opsional)</label>
                    <input type="file" name="foto" accept="image/*"
                           class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-100 file:text-green-700 hover:file:bg-green-200">
                    @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kode Barang *</label>
                    <input type="text" name="kode_barang" value="{{ old('kode_barang', $inventari->kode_barang) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                    @error('kode_barang') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Barang *</label>
                    <input type="text" name="nama_barang" value="{{ old('nama_barang', $inventari->nama_barang) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                    @error('nama_barang') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Satuan</label>
                    <input type="text" name="satuan" value="{{ old('satuan', $inventari->satuan) }}"
                           placeholder="pcs, kg, box, dll"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Stok Saat Ini *</label>
                    <input type="number" name="stok" value="{{ old('stok', $inventari->stok) }}" step="0.01" min="0" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga Rata-rata (Rp) *</label>
                    <input type="number" name="harga_rata2" value="{{ old('harga_rata2', $inventari->harga_rata2) }}" step="0.01" min="0" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">{{ old('keterangan', $inventari->keterangan) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.inventaris.index') }}"
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
@endsection