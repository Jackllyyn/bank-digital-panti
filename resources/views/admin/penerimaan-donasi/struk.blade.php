<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Donasi - {{ $donasi->no_transaksi }}</title>
    <style>
        @page {
            margin: 10px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }
        .container {
            width: 100%;
            padding: 5px;
        }
        .header {
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }
        .company-info h1 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
            color: #2c3e50;
        }
        .company-info p {
            margin: 4px 0 0;
            font-size: 10px;
            color: #555;
        }
        .receipt-title {
            text-align: center;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: 1px;
            text-decoration: underline;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .label {
            width: 100px;
            font-weight: 600;
            color: #555;
        }
        .separator {
            width: 20px;
            text-align: center;
        }
        .amount-row {
            background-color: #f8f9fa;
            border: 1px dashed #ccc;
        }
        .amount-row td {
            padding: 8px 5px;
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
        }
        .terbilang-box {
            background-color: #e9ecef;
            padding: 8px;
            border-radius: 4px;
            font-style: italic;
            margin-bottom: 15px;
            border-left: 4px solid #6c757d;
            font-size: 10px;
        }
        .footer {
            margin-top: 20px;
            width: 100%;
        }
        .signature {
            text-align: center;
        }
        .signature p {
            margin-bottom: 40px;
            font-weight: 600;
        }
        .signature-line {
            border-top: 1px solid #333;
            padding-top: 5px;
            display: inline-block;
            width: 80%;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Header -->
        <table class="header" width="100%">
            <tr>
                <td width="60">
                    @if(isset($identitas) && $identitas->logo)
                        <img src="{{ public_path('storage/' . $identitas->logo) }}" alt="Logo" class="logo">
                    @else
                        <div class="logo" style="background: #eee; text-align: center; line-height: 50px; font-weight: bold; color: #999; border-radius: 5px;">LOGO</div>
                    @endif
                </td>
                <td>
                    <div class="company-info">
                        <h1>{{ $identitas->nama_panti ?? 'YAYASAN PANTI ASUHAN' }}</h1>
                        <p>{{ $identitas->alamat ?? 'Alamat belum diatur' }}</p>
                        <p>Telp: {{ $identitas->telepon ?? '-' }}</p>
                    </div>
                </td>
            </tr>
        </table>

        <div class="receipt-title">BUKTI PENERIMAAN DONASI</div>

        <!-- Content -->
        <table class="info-table">
            <tr>
                <td class="label">No. Transaksi</td>
                <td class="separator">:</td>
                <td>{{ $donasi->no_transaksi }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal</td>
                <td class="separator">:</td>
                <td>{{ \Carbon\Carbon::parse($donasi->tanggal)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Diterima Dari</td>
                <td class="separator">:</td>
                <td>
                    <strong>{{ $donasi->donatur->nama ?? 'Hamba Allah' }}</strong>
                    @if($donasi->kode_donatur)
                        <span style="color: #777; font-size: 0.9em;">({{ $donasi->kode_donatur }})</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Metode Pembayaran</td>
                <td class="separator">:</td>
                <td>{{ ucfirst($donasi->cara_bayar) }}</td>
            </tr>
        </table>

        <div class="terbilang-box">
            "{{ $terbilang }}"
        </div>

        <table class="info-table">
            <tr class="amount-row">
                <td class="label" style="padding-left: 10px;">Jumlah Donasi</td>
                <td class="separator">:</td>
                <td>Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3" style="height: 10px;"></td>
            </tr>
            <tr>
                <td class="label">Keterangan</td>
                <td class="separator">:</td>
                <td>{{ $donasi->keterangan }}</td>
            </tr>
            <tr>
                <td class="label">Akun Pendapatan</td>
                <td class="separator">:</td>
                <td>{{ $donasi->akunPendapatan->nama_akun ?? '-' }}</td>
            </tr>
        </table>

        <!-- Footer / Signatures -->
        <table class="footer">
            <tr>
                <td class="signature" width="50%">
                    <p>Penyetor</p>
                    <div class="signature-line">
                        {{ $donasi->donatur->nama ?? 'Donatur' }}
                    </div>
                </td>
                <td class="signature" width="50%">
                    <p>Penerima</p>
                    <div class="signature-line">
                        {{ $donasi->user->name ?? 'Admin' }}
                    </div>
                </td>
            </tr>
        </table>

        <div style="margin-top: 20px; font-size: 9px; color: #999; text-align: center; border-top: 1px solid #eee; padding-top: 5px;">
            Dicetak: {{ now()->translatedFormat('d F Y H:i') }}
        </div>
    </div>

</body>
</html>
