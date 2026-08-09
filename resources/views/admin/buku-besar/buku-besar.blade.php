@extends('layouts.app')
@section('title', 'Buku Besar')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Header & Filter -->
        <div class="px-6 py-4 border-b border-gray-100">
            <h1 class="text-lg font-semibold text-gray-800 mb-4">Buku Besar (General Ledger)</h1>
            
            <form method="GET" action="{{ route('admin.buku-besar.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="w-full md:w-1/3">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Pilih Akun</label>
                    <select name="kode_akun" class="w-full rounded-lg border-gray-300 text-sm focus:ring-green-500 focus:border-green-500" required onchange="this.form.submit()">
                        <option value="">-- Pilih Akun --</option>
                        @foreach($akuns as $akun)
                            <option value="{{ $akun->kode_akun }}" {{ $kodeAkun == $akun->kode_akun ? 'selected' : '' }}>
                                {{ $akun->kode_akun }} - {{ $akun->nama_akun }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-auto">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="tgl_awal" value="{{ $tglAwal }}" class="rounded-lg border-gray-300 text-sm focus:ring-green-500 focus:border-green-500">
                </div>
                <div class="w-full md:w-auto">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="tgl_akhir" value="{{ $tglAkhir }}" class="rounded-lg border-gray-300 text-sm focus:ring-green-500 focus:border-green-500">
                </div>
                <a href="{{ route('admin.buku-besar.excel', request()->all()) }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
                </a>

                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition">
                    <i class="fas fa-filter mr-1"></i> Tampilkan
                </button>
                
                @if($kodeAkun)
                <a href="{{ route('admin.buku-besar.pdf', request()->query()) }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition ml-auto">
                    <i class="fas fa-file-pdf mr-1"></i> PDF
                </a>
                @endif
            </form>
        </div>

        <!-- Content -->
        <div class="p-6">
            @if($kodeAkun && $akunTerpilih)
                <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $akunTerpilih->kode_akun }} - {{ $akunTerpilih->nama_akun }}</h2>
                        <p class="text-sm text-gray-500">Posisi Normal: <span class="font-semibold">{{ $akunTerpilih->posisi_saldo }}</span> | Kelompok: {{ $akunTerpilih->kelompok }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Saldo Awal ({{ date('d/m/Y', strtotime($tglAwal)) }})</p>
                        <p class="text-lg font-bold text-gray-800">{{ number_format($saldoAwalPeriode, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">No. Bukti</th>
                                <th class="px-4 py-3">Keterangan</th>
                                <th class="px-4 py-3 text-right">Debet</th>
                                <th class="px-4 py-3 text-right">Kredit</th>
                                <th class="px-4 py-3 text-right">Saldo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <!-- Baris Saldo Awal -->
                            <tr class="bg-gray-50 italic text-gray-600">
                                <td class="px-4 py-2" colspan="3">Saldo Awal</td>
                                <td class="px-4 py-2 text-right">-</td>
                                <td class="px-4 py-2 text-right">-</td>
                                <td class="px-4 py-2 text-right font-bold">{{ number_format($saldoAwalPeriode, 0, ',', '.') }}</td>
                            </tr>

                            @php $saldo = $saldoAwalPeriode; @endphp

                            @forelse($transaksi as $row)
                                @php
                                    $debet = $row->kode_akun_debet == $kodeAkun ? $row->jumlah : 0;
                                    $kredit = $row->kode_akun_kredit == $kodeAkun ? $row->jumlah : 0;
                                    
                                    if ($akunTerpilih->posisi_saldo == 'DEBET') {
                                        $saldo += $debet - $kredit;
                                    } else {
                                        $saldo += $kredit - $debet;
                                    }
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 whitespace-nowrap">{{ date('d/m/Y', strtotime($row->tanggal)) }}</td>
                                    <td class="px-4 py-2 text-xs text-blue-600">{{ $row->no_transaksi }}</td>
                                    <td class="px-4 py-2">{{ $row->uraian }}</td>
                                    <td class="px-4 py-2 text-right">{{ $debet > 0 ? number_format($debet, 0, ',', '.') : '-' }}</td>
                                    <td class="px-4 py-2 text-right">{{ $kredit > 0 ? number_format($kredit, 0, ',', '.') : '-' }}</td>
                                    <td class="px-4 py-2 text-right font-semibold">{{ number_format($saldo, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">Tidak ada transaksi pada periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-100 font-bold">
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-right">SALDO AKHIR</td>
                                <td class="px-4 py-3 text-right">{{ number_format($saldo, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="text-center py-12 text-gray-500">Silakan pilih akun untuk melihat Buku Besar.</div>
            @endif
        </div>
    </div>
</div>
@endsection