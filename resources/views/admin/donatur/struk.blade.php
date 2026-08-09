@extends('layouts.app')
@section('title', 'Laporan Donatur - ' . $donatur->nama)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Header Laporan -->
    <div class="flex justify-between items-start mb-8 border-b pb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Laporan Riwayat Donatur</h1>
            <p class="text-gray-500 mt-1">Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
        </div>
        <div class="flex gap-3 no-print">
            <a href="{{ route('admin.donatur.pdf', $donatur->kode_donatur) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Cetak PDF
            </a>
            <a href="{{ route('admin.donatur.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Kembali</a>
        </div>
    </div>

    <!-- Profil Donatur -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-4">Informasi Donatur</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-400">Kode Donatur</p>
                    <p class="font-mono font-bold text-lg">{{ $donatur->kode_donatur }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Nama Lengkap</p>
                    <p class="font-semibold">{{ $donatur->nama }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Klasifikasi</p>
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $donatur->klasifikasi === 'tetap' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                        {{ ucwords($donatur->klasifikasi) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-4">Kontak & Alamat</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-400">Telepon</p>
                    <p>{{ $donatur->telepon ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Alamat</p>
                    <p class="text-sm">{{ $donatur->alamat ?? '-' }}, {{ $donatur->kota ?? '' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-green-50 p-6 rounded-xl shadow-sm border border-green-100">
            <h3 class="text-sm font-semibold text-green-700 uppercase mb-4">Ringkasan Kontribusi</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-green-600">Total Uang:</span>
                    <span class="font-bold text-green-800">{{ $donatur->total_donasi_rp }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-purple-600">Total Barang:</span>
                    <span class="font-bold text-purple-800">{{ $donatur->total_nilai_donasi_barang_formatted }}</span>
                </div>
                <div class="pt-2 border-t border-green-200 flex justify-between">
                    <span class="text-sm font-bold text-gray-700">Akumulasi:</span>
                    <span class="font-black text-gray-900">{{ $donatur->total_keseluruhan_rp }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Donasi Uang -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <span class="w-2 h-6 bg-green-500 rounded-full"></span>
            Riwayat Donasi Uang
        </h2>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($donatur->penerimaanDonasi ?? [] as $uang)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $uang->tanggal->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $uang->keterangan ?? 'Donasi Rutin' }}</td>
                        <td class="px-6 py-4 text-sm text-right font-semibold text-green-600">Rp {{ number_format($uang->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-400 italic">Belum ada riwayat donasi uang</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Riwayat Donasi Barang -->
    <div>
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <span class="w-2 h-6 bg-purple-500 rounded-full"></span>
            Riwayat Donasi Barang
        </h2>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Barang</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Estimasi Nilai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($donatur->donasiBarang ?? [] as $header)
                        @foreach($header->details as $barang)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $header->tanggal->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $barang->nama_barang }}</td>
                            <td class="px-6 py-4 text-sm text-center text-gray-600">{{ $barang->qty }} {{ $barang->satuan }}</td>
                            <td class="px-6 py-4 text-sm text-right font-semibold text-purple-600">Rp {{ number_format($barang->total_nilai, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-400 italic">Belum ada riwayat donasi barang</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white; }
        .max-w-6xl { max-width: 100% !important; width: 100% !important; }
    }
</style>
@endsection
