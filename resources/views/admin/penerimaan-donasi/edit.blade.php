@extends('layouts.app')
@section('title', 'Edit Penerimaan Donasi')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <!-- Header -->
        <div class="px-6 py-5 bg-yellow-500 text-white rounded-t-xl">
            <h1 class="text-xl font-semibold">Edit Donasi</h1>
            <p class="text-yellow-50 text-sm mt-1">No. Transaksi: {{ $donasi->no_transaksi }}</p>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.penerimaan-donasi.update', $donasi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', $donasi->tanggal->format('Y-m-d')) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Akun Pendapatan</label>
                        <select name="kode_pendapatan" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm">
                            <option value="">-- Pilih Akun Pendapatan --</option>
                            @foreach($akunPendapatan as $akun)
                                <option value="{{ $akun->kode_akun }}" {{ old('kode_pendapatan', $akun->kode_pendapatan) == $akun->kode_akun ? 'selected' : '' }}>
                                    {{ $akun->kode_akun }} — {{ $akun->nama_akun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Cara Bayar</label>
                        <select name="cara_bayar" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm">
                            <option value="tunai" {{ old('cara_bayar', $donasi->cara_bayar) == 'tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="transfer" {{ old('cara_bayar', $donasi->cara_bayar) == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Donatur (opsional)</label>
                        <select name="kode_donatur"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm">
                            <option value="">- Umum / Tidak diketahui -</option>
                            @foreach($donaturs as $d)
                                <option value="{{ $d->kode_donatur }}" {{ old('kode_donatur', $donasi->kode_donatur) == $d->kode_donatur ? 'selected' : '' }}>
                                    {{ $d->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" required min="1" step="1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm font-medium"
                               value="{{ old('jumlah', $donasi->jumlah) }}">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                        <textarea name="keterangan" rows="3" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm">{{ old('keterangan', $donasi->keterangan) }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-4">
                    <a href="{{ route('admin.penerimaan-donasi.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm font-medium">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection