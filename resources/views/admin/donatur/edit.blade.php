@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Edit Donatur</h1>
        <form action="{{ route('admin.donatur.update', $donatur->kode_donatur) }}" method="POST">
            @csrf @method('PATCH')
            <div class="mb-4">
                <label>Kode Donatur</label>
                <input type="text" disabled value="{{ $donatur->kode_donatur }}" class="border p-2 w-full">
            </div>
            <div class="mb-4">
                <label>Jenis Donatur</label>
                <input type="text" name="jenis_donatur" value="{{ old('jenis_donatur', $donatur->jenis_donatur) }}"
                    class="border p-2 w-full">
                @error('jenis_donatur') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label>Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $donatur->nama) }}" class="border p-2 w-full">
                @error('nama') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label>Alamat Lengkap</label>
                <textarea name="alamat_lengkap"
                    class="border p-2 w-full">{{ old('alamat_lengkap', $donatur->alamat_lengkap) }}</textarea>
                @error('alamat_lengkap') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label>Kota</label>
                <input type="text" name="kota" value="{{ old('kota', $donatur->kota) }}" class="border p-2 w-full">
                @error('kota') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label>Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon', $donatur->telepon) }}" class="border p-2 w-full">
                @error('telepon') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="border p-2 w-full">
                    <option value="">Pilih</option>
                    <option value="L" {{ old('jenis_kelamin', $donatur->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="P" {{ old('jenis_kelamin', $donatur->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>
                @error('jenis_kelamin') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label>Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $donatur->pekerjaan) }}"
                    class="border p-2 w-full">
                @error('pekerjaan') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label>Klasifikasi</label>
                <select name="klasifikasi" class="border p-2 w-full">
                    <option value="">Pilih</option>
                    <option value="tetap" {{ old('klasifikasi', $donatur->klasifikasi) == 'tetap' ? 'selected' : '' }}>Tetap
                    </option>
                    <option value="tidak tetap" {{ old('klasifikasi', $donatur->klasifikasi) == 'tidak tetap' ? 'selected' : '' }}>Tidak Tetap</option>
                </select>
                @error('klasifikasi') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
           <div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Tanggal Daftar</label>
    <input type="date" name="tanggal_daftar" 
           value="{{ old('tanggal_daftar', \Carbon\Carbon::parse($donatur->tanggal_daftar ?? today())->format('Y-m-d')) }}" 
           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
    @error('tanggal_daftar')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2">Update</button>
        </form>
    </div>
@endsection