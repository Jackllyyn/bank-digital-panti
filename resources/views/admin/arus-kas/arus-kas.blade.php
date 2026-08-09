@extends('layouts.app')
@section('title', 'Laporan Arus Kas')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Header & Filter -->
        <div class="px-6 py-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Laporan Arus Kas</h1>
                <p class="text-xs text-gray-500">Metode Langsung (Kas & Bank)</p>
            </div>
            
            <form method="GET" action="{{ route('admin.arus-kas.index') }}" class="flex items-center gap-2">
                <select name="kategori" class="rounded-lg border-gray-300 text-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat }}" {{ $kategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
                <input type="date" name="tgl_awal" value="{{ $tglAwal }}" class="rounded-lg border-gray-300 text-sm focus:ring-green-500 focus:border-green-500">
                <span class="text-gray-400">-</span>
                <input type="date" name="tgl_akhir" value="{{ $tglAkhir }}" class="rounded-lg border-gray-300 text-sm focus:ring-green-500 focus:border-green-500">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm transition">
                    <i class="fas fa-filter"></i>
                </button>
                <a href="{{ route('admin.arus-kas.pdf', request()->query()) }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm transition">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </form>
        </div>

        <!-- Content -->
        <div class="p-8">
            <div class="mb-6 text-center">
                <h2 class="text-xl font-bold text-gray-800">LAPORAN ARUS KAS</h2>
                <p class="text-sm text-gray-600">Periode: {{ date('d F Y', strtotime($tglAwal)) }} s/d {{ date('d F Y', strtotime($tglAkhir)) }}</p>
            </div>

            <div class="border rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <!-- Saldo Awal -->
                    <tr class="bg-gray-50 font-bold">
                        <td class="px-6 py-3">SALDO KAS & BANK AWAL</td>
                        <td class="px-6 py-3 text-right">{{ number_format($saldoAwal, 0, ',', '.') }}</td>
                    </tr>

                    <!-- Arus Masuk -->
                    <tr>
                        <td colspan="2" class="px-6 py-3 font-bold text-green-700 bg-green-50 border-t border-b border-green-100">ARUS KAS MASUK (PENERIMAAN)</td>
                    </tr>
                    @forelse($arusMasuk as $row)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-2 pl-10 text-gray-700">{{ $row->akunKredit->nama_akun ?? 'Tanpa Nama Akun' }}</td>
                        <td class="px-6 py-2 text-right text-gray-700">{{ number_format($row->total, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-6 py-2 pl-10 text-gray-400 italic">Tidak ada penerimaan kas pada periode ini.</td>
                    </tr>
                    @endforelse
                    <tr class="font-bold bg-gray-50 border-t">
                        <td class="px-6 py-2 pl-10">Total Penerimaan</td>
                        <td class="px-6 py-2 text-right text-green-700">+ {{ number_format($totalMasuk, 0, ',', '.') }}</td>
                    </tr>

                    <!-- Arus Keluar -->
                    <tr>
                        <td colspan="2" class="px-6 py-3 font-bold text-red-700 bg-red-50 border-t border-b border-red-100 mt-4">ARUS KAS KELUAR (PENGELUARAN)</td>
                    </tr>
                    @forelse($arusKeluar as $row)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-2 pl-10 text-gray-700">{{ $row->akunDebet->nama_akun ?? 'Tanpa Nama Akun' }}</td>
                        <td class="px-6 py-2 text-right text-gray-700">{{ number_format($row->total, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-6 py-2 pl-10 text-gray-400 italic">Tidak ada pengeluaran kas pada periode ini.</td>
                    </tr>
                    @endforelse
                    <tr class="font-bold bg-gray-50 border-t">
                        <td class="px-6 py-2 pl-10">Total Pengeluaran</td>
                        <td class="px-6 py-2 text-right text-red-700">- {{ number_format($totalKeluar, 0, ',', '.') }}</td>
                    </tr>

                    <!-- Summary -->
                    <tr class="bg-gray-100 font-bold border-t-2 border-gray-300">
                        <td class="px-6 py-3">KENAIKAN / (PENURUNAN) BERSIH KAS</td>
                        <td class="px-6 py-3 text-right">{{ number_format($totalMasuk - $totalKeluar, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-gray-800 text-white font-bold text-base">
                        <td class="px-6 py-4">SALDO KAS & BANK AKHIR</td>
                        <td class="px-6 py-4 text-right">{{ number_format($saldoAkhir, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
