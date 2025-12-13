@extends('layouts.app')
@section('title', 'Laporan Keuangan')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-4 bg-green-600 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
            <div>
                <h1 class="text-lg font-semibold">Laporan Keuangan Tahun {{ $tahun }}</h1>
                <p class="text-green-100 text-xs mt-1">Neraca & Laba Rugi — Otomatis dari jurnal & saldo awal</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.laporan.excel') }}"
                   class="px-4 py-1.5 bg-white text-green-700 rounded-lg hover:bg-green-100 transition text-xs font-medium flex items-center gap-1">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
                <a href="{{ route('admin.laporan.pdf') }}"
                   class="px-4 py-1.5 bg-white text-red-700 rounded-lg hover:bg-red-100 transition text-xs font-medium flex items-center gap-1">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>
        </div>

        <div class="p-5 space-y-6">
            <!-- Grafik Neraca (sangat kecil) -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <h2 class="text-sm font-semibold text-gray-800 mb-2">Posisi Keuangan (Neraca)</h2>
                <canvas id="neracaChart" height="100"></canvas>
            </div>

            <!-- Grafik Laba Rugi (sangat kecil) -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <h2 class="text-sm font-semibold text-gray-800 mb-2">Laba / Rugi Tahun Ini</h2>
                <canvas id="labarugiChart" height="100"></canvas>
            </div>

            <!-- Tabel Neraca (lebih compact) -->
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th colspan="2" class="px-4 py-2 text-left text-sm font-semibold text-gray-800">NERACA</th>
                        </tr>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Keterangan</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 uppercase">Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php $aset = 0; $liabilitas = 0; $ekuitas = 0; @endphp

                        @foreach($akuns as $akun)
                            @if(isset($saldoAkhir[$akun->kode_akun]))
                                @php
                                    $saldo = $saldoAkhir[$akun->kode_akun];
                                    $display = number_format($saldo, 0, ',', '.');
                                @endphp

                                @if($akun->kelompok == 'ASET')
                                    @php $aset += $saldo; @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $akun->kode_akun }} - {{ $akun->nama_akun }}</td>
                                        <td class="px-4 py-2 text-right font-medium">{{ $display }}</td>
                                    </tr>
                                @elseif($akun->kelompok == 'LIABILITAS')
                                    @php $liabilitas += $saldo; @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $akun->kode_akun }} - {{ $akun->nama_akun }}</td>
                                        <td class="px-4 py-2 text-right font-medium">{{ $display }}</td>
                                    </tr>
                                @elseif($akun->kelompok == 'EKUITAS')
                                    @php $ekuitas += $saldo; @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $akun->kode_akun }} - {{ $akun->nama_akun }}</td>
                                        <td class="px-4 py-2 text-right font-medium">{{ $display }}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach

                        <tr class="bg-gray-100 font-semibold">
                            <td class="px-4 py-2 text-xs">TOTAL ASET</td>
                            <td class="px-4 py-2 text-right text-xs text-green-700">{{ number_format($aset, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="bg-gray-100 font-semibold">
                            <td class="px-4 py-2 text-xs">TOTAL LIABILITAS + EKUITAS</td>
                            <td class="px-4 py-2 text-right text-xs text-green-700">{{ number_format($liabilitas + $ekuitas, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tabel Laba Rugi (lebih compact) -->
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th colspan="2" class="px-4 py-2 text-left text-sm font-semibold text-gray-800">LAPORAN LABA RUGI</th>
                        </tr>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase">Keterangan</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 uppercase">Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php $pendapatan = 0; $beban = 0; @endphp

                        @foreach($akuns as $akun)
                            @if(isset($saldoAkhir[$akun->kode_akun]))
                                @php
                                    $saldo = $saldoAkhir[$akun->kode_akun];
                                    $display = number_format($saldo, 0, ',', '.');
                                @endphp

                                @if($akun->kelompok == 'PENDAPATAN')
                                    @php $pendapatan += $saldo; @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $akun->kode_akun }} - {{ $akun->nama_akun }}</td>
                                        <td class="px-4 py-2 text-right font-medium">{{ $display }}</td>
                                    </tr>
                                @elseif($akun->kelompok == 'BEBAN')
                                    @php $beban += $saldo; @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $akun->kode_akun }} - {{ $akun->nama_akun }}</td>
                                        <td class="px-4 py-2 text-right font-medium">{{ $display }}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach

                        <tr class="bg-gray-100 font-semibold">
                            <td class="px-4 py-2 text-xs">TOTAL PENDAPATAN</td>
                            <td class="px-4 py-2 text-right text-xs text-green-700">{{ number_format($pendapatan, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="bg-gray-100 font-semibold">
                            <td class="px-4 py-2 text-xs">TOTAL BEBAN</td>
                            <td class="px-4 py-2 text-right text-xs text-red-700">{{ number_format($beban, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="bg-gray-200 font-bold text-sm">
                            <td class="px-4 py-2 text-xs">LABA / (RUGI) BERSIH</td>
                            <td class="px-4 py-2 text-right {{ ($pendapatan - $beban) >= 0 ? 'text-green-700' : 'text-red-700' }}">
                                {{ number_format($pendapatan - $beban, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN + Script Grafik (ukuran kecil) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const aset       = {{ $aset ?? 0 }};
    const liabilitas = {{ $liabilitas ?? 0 }};
    const ekuitas    = {{ $ekuitas ?? 0 }};
    const pendapatan = {{ $pendapatan ?? 0 }};
    const beban      = {{ $beban ?? 0 }};

    // Grafik Neraca – sangat kecil
    new Chart(document.getElementById('neracaChart'), {
        type: 'bar',
        data: {
            labels: ['Aset', 'Liabilitas', 'Ekuitas'],
            datasets: [{
                label: 'Saldo Akhir (Rp)',
                data: [aset, liabilitas, ekuitas],
                backgroundColor: ['#10b981', '#ef4444', '#8b5cf6'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Grafik Laba Rugi – sangat kecil
    new Chart(document.getElementById('labarugiChart'), {
        type: 'bar',
        data: {
            labels: ['Pendapatan', 'Beban'],
            datasets: [{
                label: 'Jumlah (Rp)',
                data: [pendapatan, beban],
                backgroundColor: ['#10b981', '#ef4444'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endsection