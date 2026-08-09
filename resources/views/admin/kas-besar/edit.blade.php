@extends('layouts.app')
@section('title', 'Edit Kas Besar')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-5 bg-green-600 text-white">
            <div class="flex items-center">
                <a href="{{ route('admin.kas-besar.index') }}" class="mr-4 text-white hover:text-green-100">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-xl font-semibold">Edit Kas Besar</h1>
                    <p class="text-green-100 text-sm mt-1">Perbarui data transaksi kas besar</p>
                </div>
            </div>
        </div>

    {{-- Transaksi --}}
     <div class="p-6">
            <form action="{{ route('admin.kas-besar.update', $kasBesar->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Kolom Kiri: Detail Akuntansi --}}
                    <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Transaksi *</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', $kasBesar->tanggal->format('Y-m-d')) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                        @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Sumber Dana (Kredit) <span class="text-gray-400 font-normal text-xs">- Kas/Bank Berkurang</span> *
                        </label>
                        <select name="nama_akunk" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                            <option value="">— Pilih Sumber Dana —</option>
                            @foreach($akuns as $akun)
                                @if (stripos($akun->nama_akun, 'Kas') !== false || stripos($akun->nama_akun, 'Bank') !== false)
                                    <option value="{{ $akun->kode_akun }}" {{ old('nama_akunk', $kasBesar->kode_akunk) == $akun->kode_akun ? 'selected' : '' }}>
                                    {{ $akun->kode_akun }} - {{ $akun->nama_akun }}
                                </option>
                                @endif
                            @endforeach
                        </select>
                        @error('nama_akunk') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Alokasi Pengeluaran (Debet) <span class="text-gray-400 font-normal text-xs">- Beban/Aset Bertambah</span> *
                        </label>
                        <select name="nama_akund" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                            <option value="">— Pilih Akun Alokasi —</option>
                            @foreach($akuns as $akun)
                                <option value="{{ $akun->kode_akun }}" {{ old('nama_akund', $kasBesar->kode_akund) == $akun->kode_akun ? 'selected' : '' }}>
                                    {{ $akun->kode_akun }} - {{ $akun->nama_akun }}
                                </option>
                            @endforeach
                        </select>
                        @error('nama_akund') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    </div>

                    {{-- Kolom Kanan: Nominal & Keterangan --}}
                    <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah (Rp) *</label>
                        <input type="number" name="jumlah" value="{{ old('jumlah', $kasBesar->jumlah) }}" required min="1" step="0.01"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm font-medium">
                        @error('jumlah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Bukti / Kwitansi (opsional)</label>
                        <input type="text" name="no_bukti" value="{{ old('no_bukti', $kasBesar->no_bukti) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                               placeholder="Contoh: BKB-001">
                    </div>

                    <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan / Uraian *</label>
                    <textarea name="keterangan" rows="4" required
                              placeholder="Contoh: Pembayaran listrik PLN bulan Desember 2025 untuk panti asuhan"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">{{ old('keterangan', $kasBesar->keterangan) }}</textarea>
                    @error('keterangan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                </div>
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.kas-besar.index') }}"
                       class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium flex items-center gap-2">
                        <i class="fas fa-save"></i> Perbarui Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
