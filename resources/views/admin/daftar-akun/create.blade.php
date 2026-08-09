@extends('layouts.app')
@section('title', 'Tambah Akun Baru')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <h1 class="text-2xl font-semibold text-gray-800 mb-8">Tambah Akun Perkiraan</h1>

        <form action="{{ route('admin.daftar-akun.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Preview Kode Akun Otomatis -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Akun</label>
                    <div class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-gray-700 font-mono font-medium cursor-not-allowed">
                        <span id="kode-preview">Akan dibuat otomatis...</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Kode akan dihasilkan berdasarkan kelompok yang dipilih (contoh: ASET → 1xxx, PENDAPATAN → 4xxx)
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Akun</label>
                    <input type="text" name="nama_akun" value="{{ old('nama_akun') }}" required autofocus
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    @error('nama_akun')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelompok</label>
                        <select name="kelompok" id="kelompok-select" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="" disabled selected>Pilih Kelompok</option>
                            <option value="ASET">ASET</option>
                            <option value="LIABILITAS">LIABILITAS</option>
                            <option value="EKUITAS">EKUITAS</option>
                            <option value="PENDAPATAN">PENDAPATAN</option>
                            <option value="BEBAN">BEBAN</option>
                        </select>
                        @error('kelompok')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Posisi Saldo Normal</label>
                        <select name="posisi_saldo" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="" disabled selected>Pilih Posisi</option>
                            <option value="DEBET">DEBET</option>
                            <option value="KREDIT">KREDIT</option>
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
                        class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                    Simpan Akun Baru
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Preview kode akun sederhana -->
<script>
    const kelompokSelect = document.getElementById('kelompok-select');
    const kodePreview = document.getElementById('kode-preview');

    const prefixMap = {
        'ASET': '1',
        'LIABILITAS': '2',
        'EKUITAS': '3',
        'PENDAPATAN': '4',
        'BEBAN': '5'
    };

    kelompokSelect.addEventListener('change', function() {
        const kelompok = this.value;
        if (kelompok && prefixMap[kelompok]) {
            kodePreview.textContent = prefixMap[kelompok] + 'xxx (akan dibuat otomatis)';
            kodePreview.classList.add('text-green-700', 'font-semibold');
        } else {
            kodePreview.textContent = 'Akan dibuat otomatis...';
            kodePreview.classList.remove('text-green-700', 'font-semibold');
        }
    });
</script>
@endsection