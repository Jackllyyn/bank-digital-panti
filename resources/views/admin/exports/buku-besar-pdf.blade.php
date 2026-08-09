<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Besar - {{ $akunTerpilih->nama_akun }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 14pt; font-weight: bold; }
        .header h2 { margin: 2px 0; font-size: 12pt; font-weight: bold; }
        .header p { margin: 2px 0; font-size: 9pt; }
        hr { border: 0; border-bottom: 1px solid #000; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px 6px; vertical-align: top; }
        th { background-color: #f0f0f0; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .info-table { width: 100%; border: none; margin-bottom: 10px; }
        .info-table td { border: none; padding: 2px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $identitas->nama_yayasan ?? 'YAYASAN' }}</h1>
        <h2>{{ $identitas->nama_panti ?? 'PANTI ASUHAN' }}</h2>
        <p>{{ $identitas->alamat ?? '' }} {{ $identitas->kota ?? '' }}</p>
        <hr>
        <h3>BUKU BESAR</h3>
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 15%;">Kode Akun</td>
            <td style="width: 35%;">: <strong>{{ $akunTerpilih->kode_akun }}</strong></td>
            <td style="width: 15%;">Periode</td>
            <td style="width: 35%;">: {{ date('d-m-Y', strtotime($tglAwal)) }} s/d {{ date('d-m-Y', strtotime($tglAkhir)) }}</td>
        </tr>
        <tr>
            <td>Nama Akun</td>
            <td>: <strong>{{ $akunTerpilih->nama_akun }}</strong></td>
            <td>Posisi Saldo</td>
            <td>: {{ $akunTerpilih->posisi_saldo }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 15%;">No. Bukti</th>
                <th>Keterangan</th>
                <th style="width: 13%;">Debet</th>
                <th style="width: 13%;">Kredit</th>
                <th style="width: 15%;">Saldo</th>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: #fafafa; font-style: italic;">
                <td colspan="3">Saldo Awal</td>
                <td class="text-right">-</td>
                <td class="text-right">-</td>
                <td class="text-right"><strong>{{ number_format($saldoAwalPeriode, 0, ',', '.') }}</strong></td>
            </tr>

            @php $saldo = $saldoAwalPeriode; @endphp

            @foreach($transaksi as $row)
                @php
                    $debet = $row->kode_akun_debet == $kodeAkun ? $row->jumlah : 0;
                    $kredit = $row->kode_akun_kredit == $kodeAkun ? $row->jumlah : 0;
                    
                    if ($akunTerpilih->posisi_saldo == 'DEBET') {
                        $saldo += $debet - $kredit;
                    } else {
                        $saldo += $kredit - $debet;
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ date('d/m/Y', strtotime($row->tanggal)) }}</td>
                    <td>{{ $row->no_transaksi }}</td>
                    <td>{{ $row->uraian }}</td>
                    <td class="text-right">{{ $debet > 0 ? number_format($debet, 0, ',', '.') : '-' }}</td>
                    <td class="text-right">{{ $kredit > 0 ? number_format($kredit, 0, ',', '.') : '-' }}</td>
                    <td class="text-right">{{ number_format($saldo, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>