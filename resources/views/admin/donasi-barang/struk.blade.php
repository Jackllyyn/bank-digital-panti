<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Donasi Barang - {{ $donasi->no_transaksi }}</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 800px; margin: 0 auto; border: 1px solid #000; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .info { display: flex; justify-content: space-between; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
        .total { text-align: right; font-weight: bold; margin-top: 15px; font-size: 1.1em; }
        .footer { margin-top: 60px; display: flex; justify-content: space-between; text-align: center; }
        .ttd .garis { border-top: 1px solid #000; width: 80%; margin: 60px auto 10px; }
        .no-print { text-align: center; margin: 20px 0; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()">Cetak Bukti</button>
        <a href="{{ route('admin.donasi-barang.index') }}" style="margin-left: 20px;">Kembali</a>
    </div>

    <div class="container">
        <div class="header">
            <h1>BUKTI PENERIMAAN DONASI BARANG</h1>
            <p>PANTI ASUHAN [Nama Panti Anda]</p>
        </div>

        <div class="info">
            <div>
                <strong>No Transaksi:</strong> {{ $donasi->no_transaksi }}<br>
                <strong>Tanggal:</strong> {{ $donasi->tanggal->format('d F Y') }}<br>
                <strong>Petugas:</strong> {{ $donasi->user?->name ?? 'Admin' }}
            </div>
            <div style="text-align: right;">
                <strong>Donatur:</strong> {{ $donasi->donatur?->nama ?? 'Umum' }}<br>
                <strong>Keterangan:</strong> {{ $donasi->keterangan ?? '-' }}
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Deskripsi</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Nilai per Unit (Rp)</th>
                    <th>Total Nilai (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donasi->details as $detail)
                    <tr>
                        <td style="text-align:center">{{ $loop->iteration }}</td>
                        <td>{{ $detail->barang?->nama_barang ?? '-' }}</td>
                        <td>{{ $detail->deskripsi_barang ?? '-' }}</td>
                        <td style="text-align:right">{{ number_format($detail->qty, 0, ',', '.') }}</td>
                        <td>{{ $detail->barang?->satuan ?? 'unit' }}</td>
                        <td style="text-align:right">{{ number_format($detail->nilai_satuan ?? 0, 0, ',', '.') }}</td>
                        <td style="text-align:right">{{ number_format($detail->total_nilai ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center">Tidak ada data barang</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="total">
            Total Qty: {{ number_format($donasi->details->sum('qty'), 0, ',', '.') }}<br>
            Total Nilai Donasi: Rp {{ number_format($donasi->details->sum('total_nilai'), 0, ',', '.') }}
        </div>

        <div class="footer">
            <div class="ttd">
                <p>Mengetahui,<br>Pimpinan Panti</p>
                <div class="garis"></div>
                <p>(..........................................)</p>
            </div>
            <div class="ttd">
                <p>Donatur / Pemberi</p>
                <div class="garis"></div>
                <p>{{ $donasi->donatur?->nama ?? '..........................................' }}</p>
            </div>
        </div>

        <div style="text-align:center; margin-top:40px; font-size:12px;">
            Dicetak pada: {{ now()->format('d F Y H:i') }}
        </div>
    </div>
</body>
</html>