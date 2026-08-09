<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 14pt; font-weight: bold; }
        .header h2 { margin: 2px 0; font-size: 12pt; font-weight: bold; }
        .header p { margin: 2px 0; font-size: 9pt; }
        hr { border: 0; border-bottom: 1px solid #000; margin: 10px 0; }
        .section-title { font-weight: bold; margin-top: 15px; margin-bottom: 5px; text-decoration: underline; font-size: 11pt; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { padding: 3px 4px; vertical-align: top; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .sub-total { border-top: 1px solid #000; font-weight: bold; }
        .grand-total { border-top: 2px solid #000; border-bottom: 2px solid #000; font-weight: bold; padding: 5px 4px; background-color: #f0f0f0; }
        .group-header { font-weight: bold; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $identitas->nama_yayasan ?? 'YAYASAN' }}</h1>
        <h2>{{ $identitas->nama_panti ?? 'PANTI ASUHAN' }}</h2>
        <p>{{ $identitas->alamat ?? '' }} {{ $identitas->kota ?? '' }}</p>
        <hr>
        <h3>LAPORAN KEUANGAN PERIODE {{ date('d-m-Y', strtotime($tglAwal)) }} s/d {{ date('d-m-Y', strtotime($tglAkhir)) }}</h3>
    </div>

    <!-- NERACA -->
    <div class="section-title">I. NERACA (POSISI KEUANGAN)</div>
    
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%; padding-right: 15px; border-right: 1px dashed #ccc;">
                <div class="group-header">ASET</div>
                <table style="width: 100%;">
                    @foreach($akuns->where('kelompok', 'ASET') as $akun)
                        @if(($saldoAkhir[$akun->kode_akun] ?? 0) != 0)
                        <tr>
                            <td>{{ $akun->nama_akun }}</td>
                            <td class="text-right">{{ number_format($saldoAkhir[$akun->kode_akun], 0, ',', '.') }}</td>
                        </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td class="sub-total">TOTAL ASET</td>
                        <td class="text-right sub-total">{{ number_format($aset, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%; padding-left: 15px;">
                <div class="group-header">LIABILITAS</div>
                <table style="width: 100%;">
                    @foreach($akuns->where('kelompok', 'LIABILITAS') as $akun)
                        @if(($saldoAkhir[$akun->kode_akun] ?? 0) != 0)
                        <tr>
                            <td>{{ $akun->nama_akun }}</td>
                            <td class="text-right">{{ number_format($saldoAkhir[$akun->kode_akun], 0, ',', '.') }}</td>
                        </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td class="sub-total">Total Liabilitas</td>
                        <td class="text-right sub-total">{{ number_format($liabilitas, 0, ',', '.') }}</td>
                    </tr>
                </table>

                <div class="group-header" style="margin-top: 10px;">EKUITAS</div>
                <table style="width: 100%;">
                    @foreach($akuns->where('kelompok', 'EKUITAS') as $akun)
                        @if(($saldoAkhir[$akun->kode_akun] ?? 0) != 0)
                        <tr>
                            <td>{{ $akun->nama_akun }}</td>
                            <td class="text-right">{{ number_format($saldoAkhir[$akun->kode_akun], 0, ',', '.') }}</td>
                        </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td>Surplus/Defisit Tahun Berjalan</td>
                        <td class="text-right">{{ number_format($surplusDefisit, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="sub-total">Total Ekuitas</td>
                        <td class="text-right sub-total">{{ number_format($ekuitas + $surplusDefisit, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- LABA RUGI -->
    <div class="section-title" style="margin-top: 20px;">II. LAPORAN SURPLUS / DEFISIT (LABA RUGI)</div>
    <table style="width: 100%;">
        <tr><td colspan="2" class="group-header">PENDAPATAN</td></tr>
        @foreach($akuns->where('kelompok', 'PENDAPATAN') as $akun)
            @if(($saldoAkhir[$akun->kode_akun] ?? 0) != 0)
            <tr>
                <td style="padding-left: 20px;">{{ $akun->nama_akun }}</td>
                <td class="text-right" style="width: 150px;">{{ number_format($saldoAkhir[$akun->kode_akun], 0, ',', '.') }}</td>
            </tr>
            @endif
        @endforeach
        <tr><td class="sub-total">TOTAL PENDAPATAN</td><td class="text-right sub-total">{{ number_format($pendapatan, 0, ',', '.') }}</td></tr>

        <tr><td colspan="2" class="group-header" style="padding-top: 10px;">BEBAN</td></tr>
        @foreach($akuns->where('kelompok', 'BEBAN') as $akun)
            @if(($saldoAkhir[$akun->kode_akun] ?? 0) != 0)
            <tr>
                <td style="padding-left: 20px;">{{ $akun->nama_akun }}</td>
                <td class="text-right">{{ number_format($saldoAkhir[$akun->kode_akun], 0, ',', '.') }}</td>
            </tr>
            @endif
        @endforeach
        <tr><td class="sub-total">TOTAL BEBAN</td><td class="text-right sub-total">{{ number_format($beban, 0, ',', '.') }}</td></tr>

        <tr>
            <td class="grand-total">SURPLUS / (DEFISIT)</td>
            <td class="text-right grand-total">{{ number_format($surplusDefisit, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div style="margin-top: 40px; text-align: right;">
        <p>{{ $identitas->kota ?? 'Kota' }}, {{ date('d F Y') }}</p>
        <br><br><br>
        <p><strong>{{ auth()->user()->name ?? 'Administrator' }}</strong></p>
    </div>
</body>
</html>