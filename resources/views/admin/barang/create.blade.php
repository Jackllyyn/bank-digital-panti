@extends('layouts.app')
@section('title', 'Tambah Barang Baru')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Barang Baru</h1>
        <a href="{{ route('admin.barang.index') }}" class="text-gray-600 hover:text-gray-900 text-sm flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6 lg:p-8">
        <form action="{{ route('admin.barang.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang (Otomatis)</label>
                    <input type="text" value="{{ $preview_kode }}" readonly
                           class="mt-1 block w-full border border-gray-300 bg-gray-100 rounded-lg shadow-sm px-3 py-2 text-gray-700 cursor-not-allowed">
                    <p class="mt-1 text-xs text-gray-500">Kode akan dibuat otomatis saat disimpan</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                    <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                    @error('nama_barang') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                    <select name="satuan" required
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                        <option value="">-- Pilih Satuan --</option>
                        <option value="unit" {{ old('satuan') == 'unit' ? 'selected' : '' }}>Unit</option>
                        <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                        <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>Kg</option>
                        <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>Liter</option>
                        <option value="pack" {{ old('satuan') == 'pack' ? 'selected' : '' }}>Pack</option>
                        <option value="dus" {{ old('satuan') == 'dus' ? 'selected' : '' }}>Dus</option>
                        <option value="botol" {{ old('satuan') == 'botol' ? 'selected' : '' }}>Botol</option>
                        <option value="sachet" {{ old('satuan') == 'sachet' ? 'selected' : '' }}>Sachet</option>
                        <option value="lembar" {{ old('satuan') == 'lembar' ? 'selected' : '' }}>Lembar</option>
                        <option value="set" {{ old('satuan') == 'set' ? 'selected' : '' }}>Set</option>
                    </select>
                    @error('satuan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori" required
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="baku" {{ old('kategori') == 'baku' ? 'selected' : '' }}>Baku</option>
                        <option value="tidak_baku" {{ old('kategori') == 'tidak_baku' ? 'selected' : '' }}>Tidak Baku</option>
                    </select>
                    @error('kategori') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok Awal</label>
                    <input type="number" name="stok_awal" min="0" value="{{ old('stok_awal', 0) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                    <p class="mt-1 text-xs text-gray-500">Jumlah stok awal (bilangan bulat, min 0)</p>
                    @error('stok_awal') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan (opsional)</label>
                    <textarea name="keterangan" rows="3" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <button type="submit" class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                    Simpan Barang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection