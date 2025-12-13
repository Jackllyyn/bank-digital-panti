<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Jurnal Umum</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 30px; font-size: 11px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 5px; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; }
        th { background-color: #f0f0f0; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        @if($identitas)
            <h1>{{ $identitas->nama_panti }}</h1>
            <p>{{ $identitas->alamat }} • {{ $identitas->kota }} • {{ $identitas->telepon }}</p>
        @else
            <h1>Panti Muhammadiyah Pesantunan</h1>
        @endif
        <h2>JURNAL UMUM</h2>
        <p>Periode: Semua Transaksi • {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No. Transaksi</th>
                <th>Uraian</th>
                <th class="text-right">Debet</th>
                <th class="text-right">Kredit</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jurnals as $j)
            <tr>
                <td>{{ $j->tanggal->format('d/m/Y') }}</td>
                <td>{{ $j->no_transaksi }}</td>
                <td>{{ $j->uraian }}</td>
                <td class="text-right">{{ $j->akunDebet ? 'Rp ' . number_format($j->jumlah,0,',','.') : '-' }}</td>
                <td class="text-right">{{ $j->akunKredit ? 'Rp ' . number_format($j->jumlah,0,',','.') : '-' }}</td>
                <td>{{ $j->user->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>