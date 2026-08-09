@extends('layouts.app')
@section('title', 'Edit Akun')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="flex items-center mb-8">
            <a href="{{ route('admin.daftar-akun.index') }}" class="mr-4 text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">Edit Akun Perkiraan</h1>
        </div>

        <form action="{{ route('admin.daftar-akun.update', $akun->kode_akun) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Akun</label>
                    <input type="text" value="{{ $akun->kode_akun }}" readonly
                           class="w-full px-4 py-2.5 border border-gray-200 bg-gray-100 text-gray-700 rounded-lg cursor-not-allowed">
                    <p class="text-xs text-gray-500 mt-1">Kode akun dibuat otomatis dan tidak dapat diubah</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Akun</label>
                    <input type="text" name="nama_akun" value="{{ old('nama_akun', $akun->nama_akun) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    @error('nama_akun')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelompok</label>
                        <select name="kelompok" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            @foreach(['ASET','LIABILITAS','EKUITAS','PENDAPATAN','BEBAN'] as $k)
                                <option value="{{ $k }}" {{ old('kelompok', $akun->kelompok) == $k ? 'selected' : '' }}>
                                    {{ $k }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelompok')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Posisi Saldo Normal</label>
                        <select name="posisi_saldo" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="DEBET"  {{ old('posisi_saldo', $akun->posisi_saldo) == 'DEBET'  ? 'selected' : '' }}>DEBET</option>
                            <option value="KREDIT" {{ old('posisi_saldo', $akun->posisi_saldo) == 'KREDIT' ? 'selected' : '' }}>KREDIT</option>
                        </select>
                        @error('posisi_saldo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-end gap-4">
                <a href="{{ route('admin.daftar-akun.index') }}"
                   class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium flex items-center gap-2">
                    <i class="fas fa-save"></i> Update Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endsection