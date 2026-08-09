<style>
    /* Tambahkan CSS ini agar tampilan preview di browser rapi */
    @page { margin: 1cm; }
    body { font-family: 'Courier', sans-serif; font-size: 12px; color: #333; }
    .border-box { border: 2px solid #000; padding: 15px; }
    .header { text-align: center; font-weight: bold; font-size: 16px; margin-bottom: 20px; }
    
    /* Tabel Detail Modern Tanpa Garis Baris Tengah */
    .table-detail { width: 100%; border-collapse: collapse; margin-top: 10px; border: 1px solid #000; }
    .table-detail th { border: 1px solid #000; padding: 8px; background: #eee; }
    /* Menghapus border-top dan border-bottom pada cell agar tidak ada garis pemisah antar akun */
    .table-detail td { border-left: 1px solid #000; border-right: 1px solid #000; padding: 5px 8px; border-top: none; border-bottom: none; }
    /* Memberikan border bawah hanya pada baris terakhir atau footer */
    .table-detail tr.last-row td { border-bottom: 1px solid #000; }
    
    .footer-sign { width: 100%; margin-top: 30px; }
</style>

<div style="text-align: center; margin-bottom: 20px;">
    <h2 style="margin: 0; font-size: 18px;">LKSA PANTI ASUHAN MUHAMMADIYAH</h2>
    <p style="margin: 0; font-size: 12px;">Jl. Teuku Cikditiro, Rt 01 / Rw 08, Pesantunan, Wanasari, Brebes</p>
    <p style="margin: 0; font-size: 12px;">Telp: 081542054789 Brebes 52212</p>
    @if($identitas && $identitas->logo) <img src="{{ public_path('storage/' . $identitas->logo) }}" alt="Logo" style="width: 70px; position: absolute; top: -20px; left: 40px;"> @endif
</div>

<div class="border-box">
    <div class="header">
        BUKTI KAS KECIL <br>
        <small>No: {{ $data->no_transaksi }}</small>
    </div>

    <table width="100%" style="margin-bottom: 10px;">
        <tr>
            <td width="15%">Tanggal</td>
            <td>: {{ $data->tanggal->format('d/m/Y') }}</td>
            <td align="right">Jenis: PENGELUARAN</td>
        </tr>
        <tr>
            <td width="15%">Keterangan</td>
            <td>: {{ $data->keterangan }}</td>
            <td align="right">No. Bukti: {{ $data->no_bukti ?? '-' }}</td>
        </tr>
    </table>

    <table class="table-detail">
        <thead>
            <tr>
                <th>Nama Akun</th>
                <th width="20%">Debet (Rp)</th>
                <th width="20%">Kredit (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-weight: bold; padding-top: 10px;">{{ $data->akunDebet->nama_akun }}</td>
                <td align="right" style="padding-top: 10px;">{{ number_format($data->jumlah, 0, ',', '.') }}</td>
                <td align="right" style="padding-top: 10px;">-</td>
            </tr>
            <tr class="last-row">
                <td style="padding-left: 30px; padding-bottom: 10px;">{{ $data->akunKredit->nama_akun }}</td>
                <td align="right" style="padding-bottom: 10px;">-</td>
                <td align="right" style="padding-bottom: 10px;">{{ number_format($data->jumlah, 0, ',', '.') }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr style="font-weight: bold; background-color: #f9f9f9;">
                <td align="right">Total</td>
                <td align="right">{{ number_format($data->jumlah, 0, ',', '.') }}</td>
                <td align="right">{{ number_format($data->jumlah, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <p style="margin-top: 15px;"><strong>Terbilang:</strong> <i> {{ $terbilang }} </i></p>

    <table class="footer-sign">
        <tr>
            <td align="center">Menyetujui,<br><br><br>(Drs. Akhlif)</td>
            <td align="center">Bagian Akuntansi,<br><br><br>(Zulfa Fuadi, SE)</td>
            <td align="center">Bagian Keuangan,<br><br><br>{{ $data->user->name ?? 'Admin' }}</td>
            <td align="center">Penerima,<br><br><br>(................)</td>
        </tr>
    </table>
</div>