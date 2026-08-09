<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $karyawan->nama }} - {{ $periode }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; color: #333; }
        .container { width: 100%; margin: 0 auto; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; }
        .header p { margin: 5px 0; }
        .content h2 { text-align: center; font-size: 16px; margin-bottom: 20px; text-decoration: underline; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 4px 0; }
        .salary-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .salary-table th, .salary-table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .salary-table th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .total-row td { border-top: 2px solid #000; font-weight: bold; }
        .terbilang { margin-top: 20px; font-style: italic; }
        .signatures { margin-top: 40px; width: 100%; }
        .signatures td { width: 50%; text-align: center; padding-top: 60px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $identitas->nama_panti ?? 'Nama Panti Asuhan' }}</h1>
            <p>{{ $identitas->alamat ?? 'Alamat Panti' }}</p>
            <p>Telepon: {{ $identitas->telepon ?? '-' }} | Email: {{ $identitas->email ?? '-' }}</p>
        </div>

        <div class="content">
            <h2>SLIP GAJI KARYAWAN</h2>

            <table class="info-table">
                <tr>
                    <td width="120px"><strong>NIP</strong></td>
                    <td width="10px">:</td>
                    <td>{{ $karyawan->nip }}</td>
                    <td width="120px"><strong>Periode Gaji</strong></td>
                    <td width="10px">:</td>
                    <td>{{ $periode }}</td>
                </tr>
                <tr>
                    <td><strong>Nama Karyawan</strong></td>
                    <td>:</td>
                    <td>{{ $karyawan->nama }}</td>
                    <td><strong>Tanggal Cetak</strong></td>
                    <td>:</td>
                    <td>{{ now()->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Jabatan</strong></td>
                    <td>:</td>
                    <td colspan="4">{{ $karyawan->jabatan ?? '-' }}</td>
                </tr>
            </table>

            <table class="salary-table">
                <thead>
                    <tr>
                        <th colspan="2">PENERIMAAN</th>
                        <th colspan="2">POTONGAN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Gaji Pokok</td>
                        <td class="text-right">{{ $karyawan->gaji_pokok_rp }}</td>
                        <td>Potongan Gaji</td>
                        <td class="text-right">{{ $karyawan->potongan_gaji_rp }}</td>
                    </tr>
                    <tr>
                        <td>Tunjangan</td>
                        <td class="text-right">{{ $karyawan->tunjangan_rp }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="total-row">
                        <td class="font-bold">Total Penerimaan</td>
                        <td class="text-right font-bold">{{ 'Rp ' . number_format($karyawan->gaji_pokok + $karyawan->tunjangan, 0, ',', '.') }}</td>
                        <td class="font-bold">Total Potongan</td>
                        <td class="text-right font-bold">{{ $karyawan->potongan_gaji_rp }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="total-row" style="background-color: #f2f2f2;">
                        <td colspan="3" class="font-bold text-right">GAJI BERSIH (TAKE HOME PAY)</td>
                        <td class="text-right font-bold">{{ $karyawan->gaji_bersih_rp }}</td>
                    </tr>
                </tfoot>
            </table>

            <div class="terbilang">
                <strong>Terbilang:</strong> {{ $terbilang }}
            </div>
        </div>

        <table class="signatures">
            <tr>
                <td>
                    <p>Penerima,</p>
                    <br><br><br>
                    <p>( {{ $karyawan->nama }} )</p>
                </td>
                <td>
                    <p>{{ $identitas->kota ?? 'Kota' }}, {{ now()->translatedFormat('d F Y') }}</p>
                    <p>Bagian Keuangan,</p>
                    <br><br><br>
                    <p>(_________________________)</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
