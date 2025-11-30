@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Tambah Donatur</h1>
        <form action="{{ route('admin.donatur.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label>Jenis Donatur</label>
                <input type="text" name="jenis_donatur" value="{{ old('jenis_donatur') }}" class="border p-2 w-full">
                @error('jenis_donatur') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label>Nama</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="border p-2 w-full">
                @error('nama') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label>Alamat Lengkap</label>
                <textarea name="alamat_lengkap" class="border p-2 w-full">{{ old('alamat_lengkap') }}</textarea>
                @error('alamat_lengkap') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label>Kota</label>
                <input type="text" name="kota" value="{{ old('kota') }}" class="border p-2 w-full">
                @error('kota') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label>Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon') }}" class="border p-2 w-full">
                @error('telepon') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
          
            <div class="mb-4">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="border p-2 w-full">
                    <option value="">Pilih</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label>Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" class="border p-2 w-full">
                @error('pekerjaan') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label>Klasifikasi</label>
                <select name="klasifikasi" class="border p-2 w-full">
                    <option value="">Pilih</option>
                    <option value="tetap" {{ old('klasifikasi') == 'tetap' ? 'selected' : '' }}>Tetap</option>
                    <option value="tidak tetap" {{ old('klasifikasi') == 'tidak tetap' ? 'selected' : '' }}>Tidak Tetap</option>
                </select>
                @error('klasifikasi') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label>Tanggal Daftar</label>
                <input type="date" name="tanggal_daftar" value="{{ old('tanggal_daftar', now()->format('Y-m-d')) }}" class="border p-2 w-full">
                @error('tanggal_daftar') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="bg-green-500 text-black px-4 py-2">Simpan</button>
        </form>
    </div>
@endsection