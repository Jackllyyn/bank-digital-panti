<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Donasi - {{ $donatur->nama }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; color: #000; background: #fff; font-size: 12px; line-height: 1.4; }
        .struk { width: 100%; max-width: 350px; margin: 20px auto; padding: 20px; border: 1px solid #000; border-radius: 6px; background: #fff; box-sizing: border-box; }
        .kop { text-align: center; margin-bottom: 15px; }
        .kop img { max-height: 60px; margin-bottom: 8px; }
        .kop h1 { margin: 0; font-size: 16px; font-weight: bold; text-transform: uppercase; }
        .kop h2 { margin: 4px 0; font-size: 13px; font-weight: bold; }
        .kop p { margin: 2px 0; font-size: 11px; }
        .hr-kop { height: 2px; background: #000; margin: 12px 0; }
        .title { text-align: center; font-size: 15px; font-weight: bold; margin: 15px 0; text-transform: uppercase; }
        table { width: 100%; margin: 10px 0; border-collapse: collapse; font-size: 12px; }
        table td { padding: 4px 0; vertical-align: top; }
        .label { width: 100px; font-weight: bold; }
        .jumlah { font-size: 16px; font-weight: bold; }
        .terbilang { font-style: italic; font-size: 11px; color: #444; margin-top: 5px; }
        .tanggal { text-align: right; margin: 20px 0 30px; font-size: 12px; }
        .ttd { display: flex; justify-content: space-between; margin-top: 30px; font-size: 12px; }
        .ttd div { text-align: center; width: 48%; }
        .ttd .jabatan { font-weight: bold; margin-bottom: 5px; }
        .ttd .line { border-top: 1px solid #000; margin: 40px 0 8px 0; }
        .ttd .nama { font-weight: bold; }
        .footer { text-align: center; margin-top: 30px; font-size: 10px; color: #555; }
        @media print { body { margin: 0; padding: 10px; } .struk { margin: 0; padding: 15px; max-width: none; } }
    </style>
</head>
<body onload="window.print(); window.onafterprint = function(){ window.close(); }">

<div class="struk">
    <div class="kop">
        @if($identitas?->logo)
            <img src="{{ public_path($identitas->logo) }}" alt="Logo Panti">
        @endif
        <h1>{{ $identitas->nama_panti ?? 'Panti Muhammadiyah Pesantunan' }}</h1>
        <h2>{{ $identitas->alamat ?? '-' }}</h2>
        <p>Telp: {{ $identitas->telepon ?? '-' }}</p>
    </div>
    <div class="hr-kop"></div>

    <div class="title">Bukti Penerimaan Donasi</div>

    <table>
        <tr>
            <td class="label">No. Referensi</td>
            <td>: {{ $donasi->kode_transaksi ?? 'KUMULATIF' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td>: {{ $donasi->tanggal?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Nama Donatur</td>
            <td>: {{ $donatur->nama }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td>: {{ $donatur->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Telepon</td>
            <td>: {{ $donatur->telepon ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jumlah Donasi</td>
            <td class="jumlah">Rp {{ number_format($donasi->jumlah ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="2" class="terbilang">
                <em>Terbilang: 
                    <?php
                    $jumlah = (int) ($donasi->jumlah ?? 0);
                    echo ucfirst(trim(terbilang($jumlah))) . ' Rupiah';
                    ?>
                </em>
            </td>
        </tr>
    </table>

    <p style="margin-top: 15px; font-size: 12px; text-align: center;">
        Atas nama Pengurus Panti mengucapkan<br>
        <strong>terima kasih banyak</strong> atas dukungan Bapak/Ibu.
    </p>
    <p style="font-weight: bold; text-align: center; margin: 15px 0;">
        Jazaakumullahu khairan katsiira
    </p>

    <div class="tanggal">
        Brebes, {{ now()->translatedFormat('d F Y') }}
    </div>

    <div class="ttd">
        <div>
            <div class="jabatan">Pemimpin Panti</div>
            <div class="line"></div>
            <div class="nama">{{ $identitas->pimpinan ?? '_________________' }}</div>
        </div>
        <div>
            <div class="jabatan">Donatur</div>
            <div class="line"></div>
            <div class="nama">{{ $donatur->nama }}</div>
        </div>
    </div>

    <div class="footer">
        <p>Terima kasih atas kebaikan Anda ❤️</p>
        <p>Dicetak: {{ now()->translatedFormat('d F Y H:i') }}</p>
    </div>
</div>

</body>
</html>