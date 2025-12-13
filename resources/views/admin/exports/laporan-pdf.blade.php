<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 40px; font-size: 12px; }
        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { margin: 5px; font-size: 20px; }
        table { width: 100%; margin: 20px 0; }
        .border-top { border-top: 2px solid #000; padding-top: 10px; }
        .font-bold { font-weight: bold; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        @if($identitas)
            <h1>{{ $identitas->nama_panti }}</h1>
            <p>{{ $identitas->alamat }} • {{ $identitas->kota }}</p>
        @endif
        <h2>LAPORAN KEUANGAN</h2>
        <p>Tahun {{ $tahun }}</p>
    </div>

    <h3>NERACA</h3>
    <table>
        <tr><td><strong>ASET</strong></td><td></td></tr>
        @foreach($akuns->where('kelompok','ASET') as $a)
            @if(($saldoAkhir[$a->kode_akun]??0) != 0)
            <tr><td>&nbsp;&nbsp;{{ $a->nama_akun }}</td><td class="text-right">Rp {{ number_format($saldoAkhir[$a->kode_akun],0,',','.') }}</td></tr>
            @endif
        @endforeach
        <tr class="border-top font-bold"><td>Total Aset</td><td class="text-right">Rp {{ number_format($akuns->where('kelompok','ASET')->sum(fn($a)=>$saldoAkhir[$a->kode_akun]??0),0,',','.') }}</td></tr>
    </table>

    <h3>LAPORAN LABA RUGI</h3>
    <table>
        <tr><td>Pendapatan</td><td class="text-right">Rp {{ number_format($akuns->where('kelompok','PENDAPATAN')->sum(fn($a)=>$saldoAkhir[$a->kode_akun]??0),0,',','.') }}</td></tr>
        <tr><td>Beban</td><td class="text-right">(Rp {{ number_format($akuns->where('kelompok','BEBAN')->sum(fn($a)=>$saldoAkhir[$a->kode_akun]??0),0,',','.') }})</td></tr>
        <tr class="border-top font-bold"><td>SURPLUS</td><td class="text-right">Rp {{ number_format(($akuns->where('kelompok','PENDAPATAN')->sum(fn($a)=>$saldoAkhir[$a->kode_akun]??0) - $akuns->where('kelompok','BEBAN')->sum(fn($a)=>$saldoAkhir[$a->kode_akun]??0)),0,',','.') }}</td></tr>
    </table>
</body>
</html>