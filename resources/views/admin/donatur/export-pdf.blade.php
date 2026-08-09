<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Donatur</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 14pt; font-weight: bold; }
        .header h2 { margin: 2px 0; font-size: 12pt; font-weight: bold; }
        .header p { margin: 2px 0; font-size: 9pt; }
        hr { border: 0; border-bottom: 1px solid #000; margin: 10px 0; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; font-size: 9pt; vertical-align: top; }
        th { background-color: #f0f0f0; font-weight: bold; text-align: center; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .filter-info { font-size: 9pt; color: #555; margin-bottom: 10px; font-style: italic; }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $identitas->nama_yayasan ?? 'YAYASAN PANTI ASUHAN' }}</h1>
        <h2>{{ $identitas->nama_panti ?? 'Laporan Donatur' }}</h2>
        <p>{{ $identitas->alamat ?? '' }} {{ $identitas->kota ?? '' }}</p>
        <p>Telp: {{ $identitas->telepon ?? '-' }} | Email: {{ $identitas->email ?? '-' }}</p>
        <hr>
        <h3 style="margin: 10px 0;">LAPORAN DATA DONATUR</h3>
    </div>

    @if($request->filled('tgl_awal') && $request->filled('tgl_akhir'))
        <p class="text-center" style="font-size: 10pt; font-weight: bold; margin-bottom: 10px; text-align: center;">
            PERIODE: {{ \Carbon\Carbon::parse($request->tgl_awal)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($request->tgl_akhir)->translatedFormat('d F Y') }}
        </p>
    @endif

    @if($request->filled('search') || $request->filled('jenis_donatur') || $request->filled('klasifikasi'))
        <div class="filter-info">
            Filter diterapkan:
            @if($request->filled('search')) "Search: {{ $request->search }}" @endif
            @if($request->filled('jenis_donatur')) "Jenis: {{ ucfirst($request->jenis_donatur) }}" @endif
            @if($request->filled('klasifikasi')) "Klasifikasi: {{ ucfirst($request->klasifikasi) }}" @endif
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="8%">Kode</th>
                <th width="18%">Nama Donatur</th>
                <th width="10%">Jenis</th>
                <th width="10%">Kota</th>
                <th width="10%">Klasifikasi</th>
                <th width="12%">Terakhir Donasi</th>
                <th width="10%">Uang (Rp)</th>
                <th width="10%">Barang (Rp)</th>
                <th width="12%">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $grandTotalUang = 0;
                $grandTotalBarang = 0;
                $grandTotal = 0;
            @endphp
            @forelse($donaturs as $index => $donatur)
                @php
                    $grandTotalUang += $donatur->total_donasi;
                    $grandTotalBarang += $donatur->total_nilai_donasi_barang;
                    $grandTotal += $donatur->total_keseluruhan;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $donatur->kode_donatur }}</td>
                    <td>
                        <strong>{{ $donatur->nama }}</strong><br>
                        <span style="font-size: 8pt; color: #555;">{{ $donatur->telepon }}</span>
                    </td>
                    <td class="text-center">{{ $donatur->jenis_donatur_display }}</td>
                    <td class="text-center">{{ $donatur->kota ?? '-' }}</td>
                    <td class="text-center">{{ ucwords($donatur->klasifikasi) }}</td>
                    <td class="text-center">{{ $donatur->terakhir_donasi_formatted }}</td>
                    <td class="text-right">{{ number_format($donatur->total_donasi, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($donatur->total_nilai_donasi_barang, 0, ',', '.') }}</td>
                    <td class="text-right"><strong>{{ number_format($donatur->total_keseluruhan, 0, ',', '.') }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center" style="padding: 20px;">Tidak ada data donatur yang sesuai filter.</td>
                </tr>
            @endforelse
            
            @if(count($donaturs) > 0)
            <tr style="background-color: #f0f0f0; font-weight: bold;">
                <td colspan="7" class="text-right">GRAND TOTAL</td>
                <td class="text-right">{{ number_format($grandTotalUang, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($grandTotalBarang, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right; font-size: 10pt;">
        <p>{{ $identitas->kota ?? 'Kota' }}, {{ now()->translatedFormat('d F Y') }}</p>
        <br><br><br>
        <p><strong>( {{ auth()->user()->name ?? 'Admin' }} )</strong></p>
    </div>

</body>
</html>
