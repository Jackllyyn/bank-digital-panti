<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenerimaanDonasi;
use App\Models\JurnalUmum;
use App\Models\DaftarAkun;
use App\Models\Donatur;
use App\Models\IdentitasPanti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PenerimaanDonasiExport;
use Illuminate\Validation\Rule;

class PenerimaanDonasiController extends Controller
{
    public function index(Request $request)
    {
        $donasis = PenerimaanDonasi::with(['donatur', 'user', 'akunPendapatan'])
            ->latest()
            ->filter($request->all())
            ->paginate(15)
            ->withQueryString();

        // Hitung total donasi HARI INI (jumlah nominal, bukan count)
        $totalHariIni = PenerimaanDonasi::whereDate('tanggal', today())
            ->sum('jumlah');

        $jumlahDonasiHariIni = PenerimaanDonasi::whereDate('tanggal', today())
            ->count();

        // Data untuk dropdown filter
        $akunPendapatan = DaftarAkun::where('kelompok', 'PENDAPATAN')
            ->orderBy('kode_akun')
            ->get();

        $donaturList = Donatur::orderBy('nama')->get();

        return view('admin.penerimaan-donasi.index', compact(
            'donasis',
            'akunPendapatan',
            'donaturList',
            'totalHariIni',
            'jumlahDonasiHariIni'
        ));
    }

    public function create()
    {
        $akunPendapatan = DaftarAkun::where('kelompok', 'PENDAPATAN')->orderBy('kode_akun')->get();
        $donaturs       = Donatur::orderBy('nama')->get();

        return view('admin.penerimaan-donasi.create', compact('akunPendapatan', 'donaturs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'              => 'required|date',
            'kode_donatur'         => 'nullable|exists:donatur,kode_donatur',
            'kode_pendapatan'      => [
                'required',
                Rule::exists('daftar_akun', 'kode_akun')->where('kelompok', 'PENDAPATAN'),
            ],
            'keterangan'           => 'required|string|max:255',
            'jumlah'               => 'required|numeric|min:1',
            'cara_bayar'           => 'required|in:tunai,transfer',
        ]);

        DB::transaction(function () use ($request) {
            // Generate No Transaksi: DON-YYYYMMDD-XXXXX
            $prefix = 'DON' . date('Ymd', strtotime($request->tanggal));
            $last = PenerimaanDonasi::where('no_transaksi', 'like', $prefix . '%')
                ->orderByDesc('no_transaksi')
                ->first();
            $next = $last ? (int) substr($last->no_transaksi, -5) + 1 : 1;
            $noTransaksi = $prefix . str_pad($next, 5, '0', STR_PAD_LEFT);

            $donasi = PenerimaanDonasi::create([
                'no_transaksi'         => $noTransaksi,
                'tanggal'              => $request->tanggal,
                'kode_donatur'         => $request->kode_donatur,
                'kode_pendapatan'      => $request->kode_pendapatan,
                'keterangan'           => $request->keterangan,
                'jumlah'               => $request->jumlah,
                'cara_bayar'           => $request->cara_bayar,
                'user_id'              => auth()->id(),
            ]);

            // Update akumulasi donasi donatur
            if ($request->kode_donatur) {
                $total = PenerimaanDonasi::where('kode_donatur', $request->kode_donatur)->sum('jumlah');
                Donatur::withTrashed()->where('kode_donatur', $request->kode_donatur)->update(['total_donasi' => $total]);
            }

            // Tentukan akun debet: 1001 (Kas) untuk Tunai, 1002 (Bank) untuk Transfer
            $kodeDebet = null;
            if ($request->cara_bayar === 'transfer') {
                $akunBank = DaftarAkun::where('nama_akun', 'like', '%Bank%')->orderBy('kode_akun')->first();
                $kodeDebet = $akunBank ? $akunBank->kode_akun : '1002';
            } else {
                $akunKas = DaftarAkun::where('nama_akun', 'like', '%Kas%')->where('nama_akun', 'not like', '%Kecil%')->orderBy('kode_akun')->first();
                $kodeDebet = $akunKas ? $akunKas->kode_akun : '1001';
            }

            JurnalUmum::create([
                'tanggal'          => $request->tanggal,
                'no_transaksi'     => $noTransaksi,
                'uraian'           => 'Penerimaan donasi (' . ucfirst($request->cara_bayar) . ') - ' . $request->keterangan,
                'kode_akun_debet'  => $kodeDebet,
                'kode_akun_kredit' => $request->kode_pendapatan,
                'jumlah'           => $request->jumlah,
                'user_id'          => auth()->id(),
            ]);
        });

        return redirect()->route('admin.penerimaan-donasi.index')
            ->with('success', 'Donasi berhasil dicatat beserta jurnal otomatis.');
    }

    public function edit($id)
    {
        $donasi = PenerimaanDonasi::findOrFail($id);
        $akunPendapatan = DaftarAkun::where('kelompok', 'PENDAPATAN')->orderBy('kode_akun')->get();
        $donaturs       = Donatur::orderBy('nama')->get();

        return view('admin.penerimaan-donasi.edit', compact('donasi', 'akunPendapatan', 'donaturs'));
    }

    public function update(Request $request, $id)
    {
        $donasi = PenerimaanDonasi::findOrFail($id);

        $request->validate([
            'tanggal'              => 'required|date',
            'kode_donatur'         => 'nullable|exists:donatur,kode_donatur',
            'kode_pendapatan'      => [
                'required',
                Rule::exists('daftar_akun', 'kode_akun')->where('kelompok', 'PENDAPATAN'),
            ],
            'keterangan'           => 'required|string|max:255',
            'jumlah'               => 'required|numeric|min:1',
            'cara_bayar'           => 'required|in:tunai,transfer',
        ]);

        DB::transaction(function () use ($request, $donasi) {

            // Cek jika tanggal berubah, sesuaikan No Transaksi agar konsisten (Format: DON-YYYYMMDD-XXXXX)
            $oldNoTransaksi = $donasi->no_transaksi;
            $newNoTransaksi = $oldNoTransaksi;

            if (date('Y-m-d', strtotime($request->tanggal)) !== date('Y-m-d', strtotime($donasi->tanggal))) {
                $prefix = 'DON' . date('Ymd', strtotime($request->tanggal));
                $last = PenerimaanDonasi::where('no_transaksi', 'like', $prefix . '%')
                    ->orderByDesc('no_transaksi')
                    ->first();
                $next = $last ? (int) substr($last->no_transaksi, -5) + 1 : 1;
                $newNoTransaksi = $prefix . str_pad($next, 5, '0', STR_PAD_LEFT);
            }

            $oldKodeDonatur = $donasi->kode_donatur;

            // 2. Update data donasi
            $donasi->update([
                'no_transaksi'         => $newNoTransaksi,
                'tanggal'              => $request->tanggal,
                'kode_donatur'         => $request->kode_donatur,
                'kode_pendapatan'      => $request->kode_pendapatan,
                'keterangan'           => $request->keterangan,
                'jumlah'               => $request->jumlah,
                'cara_bayar'           => $request->cara_bayar,
            ]);

            // 3. Update saldo donatur (Recalculate agar akurat)
            if ($oldKodeDonatur) {
                $totalOld = PenerimaanDonasi::where('kode_donatur', $oldKodeDonatur)->sum('jumlah');
                Donatur::withTrashed()->where('kode_donatur', $oldKodeDonatur)->update(['total_donasi' => $totalOld]);
            }

            if ($request->kode_donatur && $request->kode_donatur !== $oldKodeDonatur) {
                $totalNew = PenerimaanDonasi::where('kode_donatur', $request->kode_donatur)->sum('jumlah');
                Donatur::withTrashed()->where('kode_donatur', $request->kode_donatur)->update(['total_donasi' => $totalNew]);
            }

            // 4. Update Jurnal Umum
            $kodeDebet = null;
            if ($request->cara_bayar === 'transfer') {
                $akunBank = DaftarAkun::where('nama_akun', 'like', '%Bank%')->orderBy('kode_akun')->first();
                $kodeDebet = $akunBank ? $akunBank->kode_akun : '1002';
            } else {
                $akunKas = DaftarAkun::where('nama_akun', 'like', '%Kas%')->where('nama_akun', 'not like', '%Kecil%')->orderBy('kode_akun')->first();
                $kodeDebet = $akunKas ? $akunKas->kode_akun : '1001';
            }
            
            JurnalUmum::where('no_transaksi', $oldNoTransaksi)->update([
                'no_transaksi'     => $newNoTransaksi,
                'tanggal'          => $request->tanggal,
                'uraian'           => 'Penerimaan donasi (' . ucfirst($request->cara_bayar) . ') - ' . $request->keterangan,
                'kode_akun_debet'  => $kodeDebet,
                'kode_akun_kredit' => $request->kode_pendapatan,
                'jumlah'           => $request->jumlah,
            ]);
        });

        return redirect()->route('admin.penerimaan-donasi.index')
            ->with('success', 'Data donasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $donasi = PenerimaanDonasi::findOrFail($id);

        DB::transaction(function () use ($donasi) {
            $kodeDonatur = $donasi->kode_donatur;

            // 1. Hapus Jurnal
            JurnalUmum::where('no_transaksi', $donasi->no_transaksi)->delete();

            // 2. Hapus Donasi
            $donasi->delete();

            // 3. Update saldo donatur (Recalculate setelah hapus)
            if ($kodeDonatur) {
                $total = PenerimaanDonasi::where('kode_donatur', $kodeDonatur)->sum('jumlah');
                Donatur::withTrashed()->where('kode_donatur', $kodeDonatur)->update(['total_donasi' => $total]);
            }
        });

        return back()->with('success', 'Data donasi berhasil dihapus.');
    }

    public function struk($id)
    {
        $donasi = PenerimaanDonasi::with(['donatur', 'user', 'akunPendapatan'])
            ->findOrFail($id);

        $identitas = IdentitasPanti::first();
        $terbilang = $this->terbilang($donasi->jumlah) . ' RUPIAH';

        // Ukuran kertas 1/4 Folio (10.75 cm x 16.5 cm) dalam point (1 cm = 28.35 pt)
        $customPaper = [0, 0, 304.72, 467.72];

        $pdf = Pdf::loadView('admin.penerimaan-donasi.struk', compact('donasi', 'identitas', 'terbilang'));
        $pdf->setPaper($customPaper, 'portrait');

        return $pdf->stream('Struk_' . $donasi->no_transaksi . '.pdf');
    }

    public function truncate(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|in:YA',
        ], [
            'confirmation.in' => 'Harap ketik "YA" untuk konfirmasi penghapusan permanen.',
        ]);

        DB::transaction(function () {
            // Hapus jurnal terkait donasi
            JurnalUmum::where('no_transaksi', 'like', 'DON%')->delete();

            // Reset total donasi di tabel donatur
            DB::table('donatur')->update(['total_donasi' => 0]);

            // Hapus semua data penerimaan donasi
            PenerimaanDonasi::truncate();
        });

        return redirect()->route('admin.penerimaan-donasi.index')
            ->with('success', 'Semua data penerimaan donasi berhasil dihapus permanen!');
    }

    public function filter(Request $request)
    {
        return redirect()->route('admin.penerimaan-donasi.index', [
            'dari'   => $request->dari,
            'sampai' => $request->sampai,
            'cara'   => $request->cara,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $donasis = PenerimaanDonasi::with(['donatur', 'user', 'akunPendapatan'])
            ->latest()
            ->filter($request->all())
            ->get();

        $totalDonasi = $donasis->sum('jumlah');
        $identitas = IdentitasPanti::first();

        $pdf = Pdf::loadView('admin.penerimaan-donasi.export-pdf', compact('donasis', 'identitas', 'totalDonasi'));

        $pdf->setPaper('A4', 'landscape');

        $filename = 'Laporan_Penerimaan_Donasi_' . date('Y-m-d_His') . '.pdf';

        return $pdf->stream($filename);
    }

    public function exportExcel(Request $request)
    {
        $donasis = PenerimaanDonasi::with(['donatur', 'user', 'akunPendapatan'])
            ->latest()
            ->filter($request->all())
            ->get();

        $filename = 'Penerimaan_Donasi_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new PenerimaanDonasiExport($donasis), $filename);
    }

    public function exportAll()
    {
        // Export tanpa filter
        return $this->exportExcel(new Request());
    }

    private function terbilang($nilai)
    {
        $nilai = abs((int) $nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->terbilang($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->terbilang($nilai / 10) . " puluh" . $this->terbilang($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->terbilang($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->terbilang($nilai / 100) . " ratus" . $this->terbilang($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->terbilang($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->terbilang($nilai / 1000) . " ribu" . $this->terbilang($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->terbilang($nilai / 1000000) . " juta" . $this->terbilang($nilai % 1000000);
        }
        return trim(strtoupper($temp));
    }
}
