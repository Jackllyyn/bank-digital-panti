<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Donasi Barang</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 16pt; font-weight: bold; }
        .header p { margin: 2px 0; font-size: 10pt; }
        hr { border: 0; border-top: 2px solid #333; margin-top: 10px; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; vertical-align: top; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        .items-list { margin: 0; padding-left: 15px; }
        .items-list li { margin-bottom: 2px; }

        .footer { margin-top: 40px; width: 100%; }
        .signature { float: right; width: 200px; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $identitas->nama_panti ?? 'Panti Asuhan' }}</h1>
        <p>{{ $identitas->alamat ?? 'Alamat Panti' }}</p>
        <p>Telp: {{ $identitas->no_telp ?? '-' }} | Email: {{ $identitas->email ?? '-' }}</p>
        <hr>
        <h2 style="margin: 10px 0; font-size: 14pt;">LAPORAN DONASI BARANG</h2>
        @if($request->start_date && $request->end_date)
            <p>Periode: {{ \Carbon\Carbon::parse($request->start_date)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($request->end_date)->translatedFormat('d F Y') }}</p>
        @elseif($request->start_date)
            <p>Dari Tanggal: {{ \Carbon\Carbon::parse($request->start_date)->translatedFormat('d F Y') }}</p>
        @elseif($request->end_date)
            <p>Sampai Tanggal: {{ \Carbon\Carbon::parse($request->end_date)->translatedFormat('d F Y') }}</p>
        @else
            <p>Semua Periode</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th width="15%">No Transaksi</th>
                <th width="18%">Donatur</th>
                <th>Rincian Barang</th>
                <th width="15%">Estimasi Nilai</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @forelse($donasis as $index => $donasi)
                @php $grandTotal += $donasi->details_sum_total_nilai; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $donasi->tanggal->format('d/m/Y') }}</td>
                    <td class="text-center">{{ $donasi->no_transaksi }}</td>
                    <td>
                        {{ $donasi->donatur->nama ?? 'Umum / Hamba Allah' }}
                        @if($donasi->keterangan)
                            <br><small class="text-gray-500">Ket: {{ $donasi->keterangan }}</small>
                        @endif
                    </td>
                    <td>
                        <ul class="items-list">
                            @foreach($donasi->details as $detail)
                                <li>
                                    {{ $detail->barang->nama_barang ?? 'Barang Dihapus' }} 
                                    ({{ number_format($detail->qty, 0, ',', '.') }} {{ $detail->barang->satuan ?? 'unit' }})
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-right">Rp {{ number_format($donasi->details_sum_total_nilai, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data donasi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right font-bold" style="background-color: #f2f2f2;">TOTAL ESTIMASI NILAI DONASI</td>
                <td class="text-right font-bold" style="background-color: #f2f2f2;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <div class="signature">
            <p>{{ $identitas->kota ?? 'Kota' }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Mengetahui,</p>
            <br><br><br>
            <p><strong>{{ auth()->user()->name ?? 'Administrator' }}</strong></p>
            <p>Pengurus</p>
        </div>
    </div>

</body>
</html>