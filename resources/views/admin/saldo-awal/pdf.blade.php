<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Neraca Saldo Awal Tahun {{ $tahun }}</title>
    @vite(['resources/css/app.css'])
    <style>
        body {
            margin: 0;
            padding: 70px 90px;
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }
        .container { max-width: 800px; margin: 0 auto; }

        /* KOP SURAT — STANDAR RESMI PANTI ASUHAN */
        .kop {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 40px;
            margin-bottom: 30px;
        }
        .logo {
            width: 110px;
            height: 110px;
            object-fit: contain;
        }
        .kop-text {
            text-align: center;
            flex: 1;
        }
        .kop-yayasan {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            letter-spacing: 1px;
        }
        .kop-panti {
            font-size: 18pt;
            font-weight: bold;
            margin: 8px 0;
            letter-spacing: 1.5px;
        }
        .kop-alamat {
            font-size: 12pt;
            margin: 10px 0;
        }
        .kop-kontak {
            font-size: 11.5pt;
        }

        /* GARIS DOUBLE BAWAH KOP — STANDAR RESMI */
        .garis-double {
            border-top: 4px double #000;
            margin: 35px 0;
        }

        .judul {
            text-align: center;
            margin: 40px 0;
        }
        .judul h2 {
            font-size: 18pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
        }
        .judul p {
            font-size: 13pt;
            margin: 15px 0 0;
        }

        table.tabel {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
            margin-top: 15px;
        }
        table.tabel th, table.tabel td {
            border: 1px solid #333;
            padding: 10px 12px;
        }
        table.tabel th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .underline { text-decoration: underline; }
        .kelompok { background-color: #d1fae5; font-weight: bold; text-align: center; }
        .subtotal { background-color: #ecfdf5; }
        .total { background-color: #065f46; color: white; font-weight: bold; font-size: 13pt; }

        .ttd {
            margin-top: 120px;
            font-size: 12pt;
        }
        .ttd table { width: 100%; border: none; }
        .ttd td { border: none; text-align: center; }
        .ttd-nama {
            margin-top: 80px;
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 10px;
            display: inline-block;
            width: 280px;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- KOP SURAT — STANDAR RESMI PANTI ASUHAN MUHAMMADIYAH -->
    <div class="kop">
        <div>
            @if($identitas->logo)
                @php
                    $logoPath = public_path('storage/' . $identitas->logo);
                    $type = pathinfo($logoPath, PATHINFO_EXTENSION);
                    $base64 = file_exists($logoPath)
                        ? 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($logoPath))
                        : null;
                @endphp
                @if($base64)
                    <img src="{{ $base64 }}" alt="Logo Panti" class="logo">
                @endif
            @endif
        </div>

        <div class="kop-text">
            <div class="kop-yayasan">LKSA PANTI MUHAMMADIYAH</div>
            <div class="kop-panti">
                {{ strtoupper($identitas->nama_panti) }}
            </div>
            <div class="kop-alamat">
                {{ $identitas->alamat }}
            </div>
            <div class="kop-kontak">
                No. Telpon : {{ $identitas->telepon }}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Kode Pos : {{ $identitas->kode_pos }}
            </div>
        </div>
    </div>

    <!-- GARIS DOUBLE — STANDAR KOP SURAT RESMI -->
    <div class="garis-double"></div>

    <!-- JUDUL -->
    <div class="judul">
        <h2>NERACA SALDO AWAL</h2>
        <p>Per tanggal {{ $tanggal }}</p>
    </div>

    <!-- TABEL -->
    <table class="tabel">
        <thead>
            <tr>
                <th width="13%">Kode Akun</th>
                <th width="40%">Nama Akun</th>
                <th width="13%">Kelompok</th>
                <th width="9%">Posisi</th>
                <th width="25%">Saldo Awal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach(['ASET','LIABILITAS','EKUITAS','PENDAPATAN','BEBAN'] as $kelompok)
                @php
                    $items = $akuns->where('kelompok', $kelompok);
                    if($items->isEmpty()) continue;
                    $subtotal = 0;
                @endphp
                <tr class="kelompok"><td colspan="5">{{ $kelompok }}</td></tr>
                @foreach($items as $akun)
                    @php $saldo = $akun->saldoAwal->first()->saldo ?? 0; $subtotal += $saldo; $grandTotal += $saldo; @endphp
                    <tr>
                        <td>{{ $akun->kode_akun }}</td>
                        <td>{{ $akun->nama_akun }}</td>
                        <td class="text-center">{{ $akun->kelompok }}</td>
                        <td class="text-center font-bold">{{ $akun->posisi_saldo == 'DEBET' ? 'D' : 'K' }}</td>
                        <td class="text-right">{{ number_format($saldo, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="subtotal font-bold">
                    <td colspan="4" class="text-right">Subtotal {{ $kelompok }}</td>
                    <td class="text-right underline">{{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="4" class="text-right">TOTAL KESELURUHAN</td>
                <td class="text-right underline">{{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- TANDA TANGAN — STANDAR RESMI -->
    <div class="ttd">
        <table>
            <tr>
                <td width="50%">
                    <div>Mengetahui,</div>
                    <div class="mt-3">Pimpinan</div>
                    <div class="ttd-nama">{{ $identitas->pimpinan }}</div>
                </td>
                <td width="50%">
                    <div>Brebes, {{ $tanggal }}</div>
                    <div class="mt-3">Bendahara</div>
                    <div class="ttd-nama">{{ $identitas->bendahara }}</div>
                </td>
            </tr>
        </table>
    </div>

</div>
</body>
</html>