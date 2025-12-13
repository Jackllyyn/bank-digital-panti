<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Donasi - {{ $donatur->nama }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.5;
            background: #fff;
        }
        .struk {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            border: 2px solid #000;
            border-radius: 8px;
            background: #fff;
        }
        .kop {
            text-align: center;
            margin-bottom: 20px;
        }
        .kop img {
            max-height: 80px;
            margin-bottom: 10px;
        }
        .kop h1 { margin: 0; font-size: 22px; font-weight: bold; text-transform: uppercase; }
        .kop h2 { margin: 4px 0; font-size: 16px; font-weight: bold; }
        .kop p { margin: 3px 0; font-size: 13px; }
        .hr-kop {
            width: 100%;
            height: 2px;
            background: #000;
            margin: 15px 0 20px;
        }
        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 15px 0 25px;
            text-transform: uppercase;
        }
        .terima {
            margin: 20px 0 25px;
            font-size: 15px;
            line-height: 1.6;
        }
        table {
            width: 100%;
            margin: 15px 0 20px;
            border-collapse: collapse;
        }
        table td {
            padding: 6px 0;
            vertical-align: top;
        }
        .label { width: 170px; font-weight: bold; }
        .jumlah { font-size: 18px; font-weight: bold; color: #000; }
        .terbilang { font-style: italic; margin-top: 4px; font-size: 14px; color: #444; }
        .tanggal {
            text-align: right;
            margin: 25px 0 40px;
            font-size: 14px;
        }
        .ttd {
            display: flex;
            justify-content: space-between;
            padding: 0 50px;
            margin-top: 50px;
        }
        .ttd div {
            text-align: center;
            width: 220px;
        }
        .ttd .line {
            border-top: 2px solid #000;
            margin-top: 50px;
            margin-bottom: 8px;
        }
        .ttd .nama {
            font-weight: bold;
            font-size: 15px;
            margin-top: 5px;
        }
        .ttd .jabatan {
            font-size: 14px;
            margin-top: 2px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>

<div class="struk">
    <!-- Kop Surat -->
    <div class="kop">
        @if ($identitas->logo)
            <img src="{{ Storage::disk('public')->url($identitas->logo) }}" alt="Logo Panti">
        @endif
        <h1>{{ $identitas->nama_yayasan ?? 'YAYASAN' }}</h1>
        <h2>{{ $identitas->nama_panti ?? 'PANTI ASUHAN' }}</h2>
        <p>{{ $identitas->alamat ?? '-' }} • {{ $identitas->kota ?? '-' }} {{ $identitas->kode_pos ?? '' }}</p>
        <p>Telp: {{ $identitas->telepon ?? '-' }} • Email: {{ $identitas->email ?? '-' }}</p>
        @if($identitas->website)
            <p>Website: {{ $identitas->website }}</p>
        @endif
        @if($identitas->npwp)
            <p>NPWP: {{ $identitas->npwp }}</p>
        @endif
        @if($identitas->no_rekening)
            <p>Rekening: {{ $identitas->no_rekening }} ({{ $identitas->nama_bank }})</p>
        @endif
    </div>

    <hr class="hr-kop">

    <div class="title">BUKTI DONASI</div>

    <div class="terima">
        <p>Telah terima sumbangan uang dari :</p>

        <table>
            <tr>
                <td class="label">Kode Donatur</td>
                <td>: {{ $donatur->kode_donatur }}</td>
            </tr>
            <tr>
                <td class="label">Nama Donatur</td>
                <td>: {{ $donatur->nama }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Donatur</td>
                <td>: {{ $donatur->jenis_donatur ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kota</td>
                <td>: {{ $donatur->kota ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Pekerjaan</td>
                <td>: {{ $donatur->pekerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Daftar</td>
                <td>: {{ $donatur->tanggal_daftar_formatted }}</td>
            </tr>
            <tr>
                <td class="label">Jumlah Donasi</td>
                <td class="jumlah">{{ $donatur->total_donasi_rp }}</td>
            </tr>
            <tr>
                <td class="terbilang">
                    Terbilang: 
                    <?php
                    // Ambil jumlah dari total_donasi yang sudah dihitung di controller
                    $jumlah = (int) ($donatur->total_donasi ?? 0);

                    // Panggil fungsi terbilang yang sudah Anda daftarkan di helper
                    echo ucfirst(trim(terbilang($jumlah))) . ' Rupiah';
                    ?>
                </td>
            </tr>
        </table>
        <p style="margin-top: 15px;">Atas nama Pengurus Panti Muhammadiyah Pesantunan mengucapkan terima kasih.</p>
        <p><strong>Jazaakallahu khairan jazaa.</strong></p>
    </div>

    <!-- Tanggal -->
    <div class="tanggal">
        <p>Brebes, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <!-- Tanda Tangan -->
    <div class="ttd">
        <div>
            <div class="jabatan">Pemimpin Panti</div>
            <div class="line"></div>
            <div class="nama">{{ $identitas->pimpinan ?? '...................................' }}</div>
        </div>

        <div>
            <div class="jabatan">Donatur</div>
            <div class="line"></div>
            <div class="nama">{{ $donatur->nama }}</div>
        </div>
    </div>

    <div class="footer">
        <p>Terima kasih atas dukungan dan kebaikan hati Anda.</p>
        <p>{{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} • Dicetak oleh Sistem Panti</p>
    </div>
</div>

<script>
    window.onload = function() {
        window.print();
    };
</script>

</body>
</html>