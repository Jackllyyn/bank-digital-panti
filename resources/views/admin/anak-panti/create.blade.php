@extends('layouts.app')
@section('title', 'Tambah Anak Panti')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Tambah Anak Panti Baru</h1>

    <form action="{{ route('admin.anak-panti.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200">
        @csrf

        <!-- Foto -->
        <div class="mb-8 text-center">
            <label class="block text-sm font-medium text-gray-700 mb-3">Foto Anak</label>
            <div class="flex justify-center">
                <input type="file" name="foto" accept="image/*"
                       class="block w-full max-w-xs text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
            @error('foto') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- NIAP -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">NIAP <span class="text-red-500">*</span></label>
                <input type="text" name="niap" value="{{ old('niap') }}" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Nama -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" required class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    <option value="">Pilih</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <!-- Tanggal Masuk -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Masuk <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-3">
            </div>

            <!-- Kota Asal -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kota Asal</label>
                <input type="text" name="kota" value="{{ old('kota') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3">
            </div>

            <!-- Tempat & Tanggal Lahir -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3">
            </div>

            <!-- Nama Ayah & Ibu -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ayah</label>
                <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ibu</label>
                <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3">
            </div>

            <!-- Pendidikan & Sekolah -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat Pendidikan</label>
                <input type="text" name="tingkat_pendidikan" value="{{ old('tingkat_pendidikan') }}"
                       placeholder="SD / SMP / SMA" class="w-full border border-gray-300 rounded-lg px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Sekolah</label>
                <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3">
            </div>

            <!-- Status -->
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Anak</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="keluar">Keluar</option>
                    <option value="adopsi">Adopsi</option>
                </select>
            </div>
        </div>

        <div class="mt-10 flex justify-end gap-4">
            <a href="{{ route('admin.anak-panti.index') }}"
               class="px-8 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit"
                    class="px-10 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow">
                Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection