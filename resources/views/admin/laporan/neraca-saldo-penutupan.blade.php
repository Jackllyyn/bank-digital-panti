@extends('layouts.app')
@section('title', 'Neraca Saldo Setelah Penutupan')

@section('content')
<div class="max-w-5xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-800 text-white flex justify-between items-center">
            <div>
                <h1 class="text-lg font-semibold">Neraca Saldo Setelah Penutupan</h1>
                <p class="text-gray-300 text-xs mt-1">Periode Tahun {{ $tahun }}</p>
            </div>
            <a href="{{ route('admin.laporan.index') }}" class="text-xs bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded text-white transition">
                &larr; Kembali ke Laporan Utama
            </a>
        </div>
        <div>
            <a href="{{ route('admin.laporan.excel') }}"
                   class="px-4 py-1.5 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition text-xs font-medium flex items-center gap-1">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
        </div>
        <div class="p-6">
            <div class="mb-4 p-4 bg-blue-50 text-blue-800 rounded-lg text-sm border border-blue-100">
                <i class="fas fa-info-circle mr-1"></i>
                Laporan ini menampilkan saldo akhir akun <strong>setelah</strong> jurnal penutup dibuat. Akun Pendapatan dan Beban harus bernilai <strong>0</strong>.
            </div>

            <div class="overflow-x-auto border rounded-lg">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-600 uppercase font-semibold text-xs">
                        <tr>
                            <th class="px-4 py-3">Kode Akun</th>
                            <th class="px-4 py-3">Nama Akun</th>
                            <th class="px-4 py-3">Kelompok</th>
                            <th class="px-4 py-3 text-right">Debet</th>
                            <th class="px-4 py-3 text-right">Kredit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php $totalDebet = 0; $totalKredit = 0; @endphp
                        @foreach($akuns as $akun)
                            @php
                                $saldo = $saldoAkhir[$akun->kode_akun] ?? 0;
                                // Skip jika saldo 0 (opsional, agar laporan lebih bersih)
                                if($saldo == 0) continue;

                                $debet = ($akun->posisi_saldo == 'DEBET') ? $saldo : 0;
                                $kredit = ($akun->posisi_saldo == 'KREDIT') ? $saldo : 0;

                                $totalDebet += $debet;
                                $totalKredit += $kredit;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 font-medium text-gray-900">{{ $akun->kode_akun }}</td>
                                <td class="px-4 py-2">{{ $akun->nama_akun }}</td>
                                <td class="px-4 py-2 text-xs">
                                    <span class="px-2 py-1 rounded-full 
                                        {{ in_array($akun->kelompok, ['ASET', 'BEBAN']) ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $akun->kelompok }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-right font-mono">{{ $debet != 0 ? number_format($debet, 0, ',', '.') : '-' }}</td>
                                <td class="px-4 py-2 text-right font-mono">{{ $kredit != 0 ? number_format($kredit, 0, ',', '.') : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-100 font-bold">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right">TOTAL</td>
                            <td class="px-4 py-3 text-right text-blue-700">{{ number_format($totalDebet, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right text-blue-700">{{ number_format($totalKredit, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection