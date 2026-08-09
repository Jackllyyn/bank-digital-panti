<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Arus Kas</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 14pt; font-weight: bold; }
        .header h2 { margin: 2px 0; font-size: 12pt; font-weight: bold; }
        .header p { margin: 2px 0; font-size: 9pt; }
        hr { border: 0; border-bottom: 1px solid #000; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td { padding: 4px 6px; vertical-align: top; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .border-top { border-top: 1px solid #000; }
        .border-bottom { border-bottom: 1px solid #000; }
        .bg-gray { background-color: #f0f0f0; }
        .indent { padding-left: 20px; }
        .total-row { border-top: 1px solid #000; font-weight: bold; }
        .grand-total { border-top: 2px solid #000; border-bottom: 2px solid #000; font-weight: bold; background-color: #f0f0f0; padding: 8px 6px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $identitas->nama_yayasan ?? 'YAYASAN' }}</h1>
        <h2>{{ $identitas->nama_panti ?? 'PANTI ASUHAN' }}</h2>
        <p>{{ $identitas->alamat ?? '' }} {{ $identitas->kota ?? '' }}</p>
        <hr>
        <h3>LAPORAN ARUS KAS</h3>
        <p>Periode: {{ date('d-m-Y', strtotime($tglAwal)) }} s/d {{ date('d-m-Y', strtotime($tglAkhir)) }}</p>
    </div>

    <table style="width: 100%;">
        <tr>
            <td class="font-bold">SALDO KAS & BANK AWAL</td>
            <td class="text-right font-bold">{{ number_format($saldoAwal, 0, ',', '.') }}</td>
        </tr>
        
        <!-- ARUS MASUK -->
        <tr><td colspan="2" class="font-bold" style="padding-top: 15px;">ARUS KAS MASUK (PENERIMAAN)</td></tr>
        @foreach($arusMasuk as $row)
        <tr>
            <td class="indent">{{ $row->akunKredit->nama_akun ?? 'Lain-lain' }}</td>
            <td class="text-right">{{ number_format($row->total, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr>
            <td class="indent font-bold border-top">Total Penerimaan</td>
            <td class="text-right font-bold border-top">{{ number_format($totalMasuk, 0, ',', '.') }}</td>
        </tr>

        <!-- ARUS KELUAR -->
        <tr><td colspan="2" class="font-bold" style="padding-top: 15px;">ARUS KAS KELUAR (PENGELUARAN)</td></tr>
        @foreach($arusKeluar as $row)
        <tr>
            <td class="indent">{{ $row->akunDebet->nama_akun ?? 'Lain-lain' }}</td>
            <td class="text-right">({{ number_format($row->total, 0, ',', '.') }})</td>
        </tr>
        @endforeach
        <tr>
            <td class="indent font-bold border-top">Total Pengeluaran</td>
            <td class="text-right font-bold border-top">({{ number_format($totalKeluar, 0, ',', '.') }})</td>
        </tr>

        <!-- SUMMARY -->
        <tr>
            <td class="font-bold" style="padding-top: 15px;">Kenaikan / (Penurunan) Bersih Kas</td>
            <td class="text-right font-bold" style="padding-top: 15px;">{{ number_format($totalMasuk - $totalKeluar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="grand-total">SALDO KAS & BANK AKHIR</td>
            <td class="text-right grand-total">{{ number_format($saldoAkhir, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div style="margin-top: 40px; text-align: right;">
        <p>{{ $identitas->kota ?? 'Kota' }}, {{ date('d F Y') }}</p>
        <br><br><br>
        <p><strong>{{ auth()->user()->name ?? 'Administrator' }}</strong></p>
    </div>
</body>
</html>
