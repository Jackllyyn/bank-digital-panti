@extends('layouts.app')
@section('title', 'Input Pengeluaran Baru')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-5 bg-green-600 text-white">
            <div class="flex items-center">
                <a href="{{ route('admin.pengeluaran.index') }}" class="mr-4 text-white hover:text-green-100">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-xl font-semibold">Input Pengeluaran Operasional</h1>
                    <p class="text-green-100 text-sm mt-1">Catat pengeluaran harian panti dengan mudah</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.pengeluaran.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Pengeluaran *</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                        @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Akun Beban *</label>
                        <select name="kode_akun" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                            <option value="">— Pilih Akun Beban —</option>
                            @foreach(\App\Models\DaftarAkun::where('kelompok', 'BEBAN')->orderBy('kode_akun')->get() as $akun)
                                <option value="{{ $akun->kode_akun }}" {{ old('kode_akun') == $akun->kode_akun ? 'selected' : '' }}>
                                    {{ $akun->kode_akun }} - {{ $akun->nama_akun }}
                                </option>
                            @endforeach
                        </select>
                        @error('kode_akun') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Pengeluaran (Rp) *</label>
                        <input type="number" name="jumlah" value="{{ old('jumlah') }}" required min="1" step="0.01"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm font-medium">
                        @error('jumlah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Bukti / Kwitansi (opsional)</label>
                        <input type="text" name="no_bukti" value="{{ old('no_bukti') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                               placeholder="Contoh: KW/2025/12/001">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan / Uraian *</label>
                    <textarea name="keterangan" rows="3" required
                              placeholder="Contoh: Pembayaran listrik PLN bulan Desember 2025 untuk panti asuhan"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.pengeluaran.index') }}"
                       class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan & Buat Jurnal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection