<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penerimaan Donasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 5px;
            vertical-align: top;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .total-row td {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        .footer {
            width: 100%;
            margin-top: 30px;
        }
        .signature-box {
            float: right;
            width: 200px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $identitas->nama_panti ?? 'YAYASAN PANTI ASUHAN' }}</h1>
        <p>{{ $identitas->alamat ?? 'Alamat belum diatur' }}</p>
        <p>Telp: {{ $identitas->telepon ?? '-' }} | Email: {{ $identitas->email ?? '-' }}</p>
        <hr style="margin-top: 10px; border: 0; border-top: 1px solid #000;">
        <h2 style="margin: 10px 0; font-size: 14px;">LAPORAN PENERIMAAN DONASI</h2>
        <p>Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">Tanggal</th>
                <th width="15%">No. Transaksi</th>
                <th width="15%">Donatur</th>
                <th width="15%">Akun Pendapatan</th>
                <th width="8%">Metode</th>
                <th>Keterangan</th>
                <th width="12%">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donasis as $index => $donasi)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $donasi->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $donasi->no_transaksi }}</td>
                    <td>{{ $donasi->donatur->nama ?? 'Umum / Hamba Allah' }}</td>
                    <td>{{ $donasi->akunPendapatan->nama_akun ?? '-' }}</td>
                    <td class="text-center">{{ ucfirst($donasi->cara_bayar) }}</td>
                    <td>{{ $donasi->keterangan }}</td>
                    <td class="text-right">Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px;">Tidak ada data donasi untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="7" class="text-right">TOTAL PENERIMAAN</td>
                <td class="text-right">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>{{ $identitas->kota ?? 'Kota' }}, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Mengetahui,</p>
            <br><br><br>
            <p><strong>{{ auth()->user()->name ?? 'Admin' }}</strong></p>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>