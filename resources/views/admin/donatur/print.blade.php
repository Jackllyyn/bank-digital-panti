<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Donatur - {{ $donatur->nama }}</title>
<style>
    @page { size: A4; margin: 2cm; }
    body { font-family: Arial, sans-serif; font-size: 11pt; line-height: 1.3; color: #000; }
    .header { text-align: center; margin-bottom: 20px; border-bottom: 3px double #000; padding-bottom: 10px; }
    .header h1 { font-size: 14pt; font-weight: bold; margin: 0; text-transform: uppercase; }
    .header p { margin: 2px 0; font-size: 10pt; }
    .title { text-align: center; font-size: 12pt; font-weight: bold; margin: 20px 0; text-decoration: underline; text-transform: uppercase; }
    .info-table { width: 100%; margin-bottom: 20px; }
    .info-table td { padding: 4px; vertical-align: top; }
    .content-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .content-table th, .content-table td { border: 1px solid #000; padding: 6px; }
    .content-table th { background-color: #f0f0f0; text-align: center; font-weight: bold; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .footer { margin-top: 40px; text-align: right; page-break-inside: avoid; }
    @media print {
        body { -webkit-print-color-adjust: exact; }
        .no-print { display: none; }
    }
</style>
</head>
<body onload="window.print()">

    <div class="header">
        <h1>{{ $identitas->nama_yayasan ?? 'YAYASAN PANTI ASUHAN' }}</h1>
        <p>{{ $identitas->nama_panti ?? 'LKSA PANTI ASUHAN' }}</p>
        <p>{{ $identitas->alamat ?? '' }} {{ $identitas->kota ?? '' }}</p>
        <p>Telp: {{ $identitas->telepon ?? '-' }}</p>
    </div>

    <div class="title">LAPORAN RIWAYAT DONATUR</div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Kode Donatur</strong></td>
            <td width="2%">:</td>
            <td width="33%">{{ $donatur->kode_donatur }}</td>
            <td width="15%"><strong>Tanggal Daftar</strong></td>
            <td width="2%">:</td>
            <td>{{ \Carbon\Carbon::parse($donatur->tanggal_daftar)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>Nama Lengkap</strong></td>
            <td>:</td>
            <td>{{ $donatur->nama }}</td>
            <td><strong>Klasifikasi</strong></td>
            <td>:</td>
            <td>{{ ucwords($donatur->klasifikasi) }}</td>
        </tr>
        <tr>
            <td><strong>Alamat</strong></td>
            <td>:</td>
            <td>{{ $donatur->alamat_lengkap ?? '-' }}</td>
            <td><strong>Telepon</strong></td>
            <td>:</td>
            <td>{{ $donatur->telepon ?? '-' }}</td>
        </tr>
    </table>

    <h3>Ringkasan Donasi</h3>
    <table class="content-table">
        <tr>
            <td width="70%">Total Donasi Uang</td>
            <td class="text-right">Rp {{ number_format($donatur->total_donasi, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total Nilai Barang</td>
            <td class="text-right">Rp {{ number_format($donatur->total_nilai_donasi_barang, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="background-color: #eee;"><strong>Total Keseluruhan</strong></td>
            <td class="text-right" style="background-color: #eee;"><strong>Rp {{ number_format($donatur->total_donasi + $donatur->total_nilai_donasi_barang, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <h3>Riwayat Donasi Uang</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th>Keterangan</th>
                <th width="20%">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donatur->penerimaanDonasi as $index => $uang)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $uang->tanggal->format('d/m/Y') }}</td>
                <td>{{ $uang->keterangan }}</td>
                <td class="text-right">{{ number_format($uang->jumlah, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada data donasi uang.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Riwayat Donasi Barang</h3>
    <table class="content-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th>Nama Barang</th>
                <th width="15%">Jumlah</th>
                <th width="20%">Estimasi Nilai (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($donatur->donasiBarang as $header)
                @foreach($header->details as $detail)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-center">{{ $header->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $detail->nama_barang }}</td>
                    <td class="text-center">{{ $detail->qty }} {{ $detail->satuan }}</td>
                    <td class="text-right">{{ number_format($detail->total_nilai, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data donasi barang.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>{{ $identitas->kota ?? 'Kota' }}, {{ now()->translatedFormat('d F Y') }}</p>
        <br><br><br>
        <p><strong>( {{ auth()->user()->name ?? 'Admin' }} )</strong></p>
    </div>
</body>
</html>