{{-- resources/views/staff/penerimaan-donasi/create.blade.php --}}

@extends('layouts.app')

@section('title', 'Input Penerimaan Donasi')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-8">Input Penerimaan Donasi</h1>

        <!-- Alert jika ada error -->
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('staff.penerimaan-donasi.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                           class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400">
                    @error('tanggal') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Donasi</label>
                    <select name="jenis" required class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-400">
                        <option value="">-- Pilih Jenis Donasi --</option>
                        <option value="zakat" {{ old('jenis') == 'zakat' ? 'selected' : '' }}>Zakat Fitrah / Mal</option>
                        <option value="infak" {{ old('jenis') == 'infak' ? 'selected' : '' }}>Infak / Sedekah</option>
                        <option value="wakaf" {{ old('jenis') == 'wakaf' ? 'selected' : '' }}>Wakaf</option>
                        <option value="lainnya" {{ old('jenis') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jenis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Donatur (Opsional)</label>
                    <select name="kode_donatur" class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-400">
                        <option value="">- Umum / Tidak Diketahui -</option>
                        @foreach(\App\Models\Donatur::orderBy('nama')->get() as $d)
                            <option value="{{ $d->kode_donatur }}" {{ old('kode_donatur') == $d->kode_donatur ? 'selected' : '' }}>
                                {{ $d->nama }} ({{ $d->kode_donatur }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah (Rp)</label>
                    <input type="number" name="jumlah" value="{{ old('jumlah') }}" required min="1" step="0.01"
                           class="w-full px-4 py-3 rounded-xl border text-2xl font-bold text-emerald-600 focus:ring-2 focus:ring-emerald-400">
                    @error('jumlah') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cara Bayar</label>
                    <select name="cara_bayar" required class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-400">
                        <option value="">-- Pilih Cara Bayar --</option>
                        <option value="tunai" {{ old('cara_bayar') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="transfer" {{ old('cara_bayar') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="barang" {{ old('cara_bayar') == 'barang' ? 'selected' : '' }}>Barang</option>
                    </select>
                    @error('cara_bayar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="4" required placeholder="Contoh: Donasi dari Bapak Ahmad untuk operasional bulan ini"
                              class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-400">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-10 flex justify-end space-x-4">
                <a href="{{ route('staff.dashboard') }}"
                   class="px-8 py-3 bg-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-10 py-3 bg-emerald-600 text-white font-medium rounded-xl hover:bg-emerald-700 transition shadow-md">
                    Simpan & Buat Jurnal Otomatis
                </button>
            </div>
        </form>
    </div>
</div>
@endsection