@extends('layouts.app')
@section('title', 'Tambah Akun Baru')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <h1 class="text-2xl font-semibold text-gray-800 mb-8">Tambah Akun Perkiraan</h1>

        <form action="{{ route('admin.daftar-akun.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kode Akun</label>
                        <input type="text" name="kode_akun" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Akun</label>
                        <input type="text" name="nama_akun" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelompok</label>
                        <select name="kelompok" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="ASET">ASET</option>
                            <option value="LIABILITAS">LIABILITAS</option>
                            <option value="EKUITAS">EKUITAS</option>
                            <option value="PENDAPATAN">PENDAPATAN</option>
                            <option value="BEBAN">BEBAN</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Posisi Saldo Normal</label>
                        <select name="posisi_saldo" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="DEBET">DEBET</option>
                            <option value="KREDIT">KREDIT</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Saldo Awal Tahun {{ date('Y') }} (opsional)
                    </label>
                    <input type="number" name="saldo_awal" value="0" step="0.01"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('admin.daftar-akun.index') }}"
                   class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endsection