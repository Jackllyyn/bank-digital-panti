<!DOCTYPE html>
<html>
<head>
    <title>Bukti Transaksi Barang Keluar</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; pb: 10px; }
        .title { font-size: 14pt; font-weight: bold; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #ccc; padding: 5px; }
        .no-border { border: none; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ strtoupper($identitas->nama_panti ?? 'PANTI ASUHAN') }}</div>
        <div>{{ $identitas->alamat ?? 'Alamat Panti' }}</div>
        <h3 style="margin-top: 15px;">BUKTI BARANG KELUAR</h3>
    </div>

    <table class="no-border">
        <tr class="no-border">
            <td class="no-border" width="150">No. Transaksi</td>
            <td class="no-border" width="10">:</td>
            <td class="no-border">{{ $keluar->no_transaksi }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Tanggal</td>
            <td class="no-border">:</td>
            <td class="no-border">{{ \Carbon\Carbon::parse($keluar->tanggal)->format('d F Y') }}</td>
        </tr>
        <tr class="no-border">
            <td class="no-border">Keterangan</td>
            <td class="no-border">:</td>
            <td class="no-border">{{ $keluar->keterangan }}</td>
        </tr>
    </table>

    <h4>Detail Barang</h4>
    <table>
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $keluar->barang->kode_barang }}</td>
                <td>{{ $keluar->barang->nama_barang }}</td>
                <td class="text-center">{{ $keluar->qty }}</td>
                <td class="text-center">{{ $keluar->barang->satuan }}</td>
            </tr>
        </tbody>
    </table>

    @if($jurnals->count() > 0)
    <h4>Catatan Akuntansi (Jurnal)</h4>
    <table>
        <thead>
            <tr>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th>Debet</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jurnals as $jurnal)
            <tr>
                <td>{{ $jurnal->kode_akun_debet }}</td>
                <td>{{ $jurnal->akunDebet->nama_akun ?? '-' }}</td>
                <td class="text-right">{{ number_format($jurnal->jumlah, 0, ',', '.') }}</td>
                <td class="text-right">0</td>
            </tr>
            <tr>
                <td>{{ $jurnal->kode_akun_kredit }}</td>
                <td>{{ $jurnal->akunKredit->nama_akun ?? '-' }}</td>
                <td class="text-right">0</td>
                <td class="text-right">{{ number_format($jurnal->jumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div style="margin-top: 50px;">
        <table class="no-border">
            <tr class="no-border">
                <td class="no-border text-center" width="50%">
                    Diserahkan Oleh,<br><br><br><br>
                    (..........................)
                </td>
                <td class="no-border text-center" width="50%">
                    Dibuat Oleh,<br><br><br><br>
                    ( {{ $keluar->user->name ?? 'Admin' }} )
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
