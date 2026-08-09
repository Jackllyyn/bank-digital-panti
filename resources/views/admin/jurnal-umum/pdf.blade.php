<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Jurnal Umum</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background: #f0f0f0; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">JURNAL UMUM</h2>
    <p style="text-align: center;">Periode: {{ request('dari') ?? '-' }} s/d {{ request('sampai') ?? 'Sekarang' }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No Transaksi</th>
                <th>Uraian</th>
                <th>Akun Debet</th>
                <th>Debet</th>
                <th>Akun Kredit</th>
                <th>Kredit</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jurnals as $j)
            <tr>
                <td>{{ $j->tanggal?->format('d/m/Y') }}</td>
                <td>{{ $j->no_transaksi }}</td>
                <td>{{ $j->uraian }}</td>
                <td>{{ $j->akunDebet ? $j->akunDebet->kode_akun . ' - ' . $j->akunDebet->nama_akun : '-' }}</td>
                <td class="text-right">{{ $j->akunDebet ? number_format($j->jumlah, 0, ',', '.') : '-' }}</td>
                <td>{{ $j->akunKredit ? $j->akunKredit->kode_akun . ' - ' . $j->akunKredit->nama_akun : '-' }}</td>
                <td class="text-right">{{ $j->akunKredit ? number_format($j->jumlah, 0, ',', '.') : '-' }}</td>
                <td>{{ $j->user?->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>