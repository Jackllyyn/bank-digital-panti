<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsetTetap;
use App\Models\JurnalUmum;
use App\Models\DaftarAkun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyusutanController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        // Ambil aset yang diperoleh sebelum atau pada tahun yang dipilih
        $assets = AsetTetap::whereYear('tanggal_perolehan', '<=', $tahun)
            ->orderBy('kode_aset')
            ->get();

        $listPenyusutan = [];

        foreach ($assets as $asset) {
            // Hitung penyusutan per tahun (Metode Garis Lurus)
            // Rumus: (Harga Perolehan - Nilai Residu) / Masa Manfaat
            if ($asset->masa_manfaat_tahun > 0) {
                $penyusutanPerTahun = ($asset->harga_perolehan - $asset->nilai_residu) / $asset->masa_manfaat_tahun;
            } else {
                $penyusutanPerTahun = 0;
            }

            // Cek apakah sudah disusutkan untuk tahun ini
            // Menggunakan pola uraian untuk pengecekan
            $isSusut = JurnalUmum::where('uraian', 'like', "Penyusutan Aset {$asset->kode_aset}%")
                ->whereYear('tanggal', $tahun)
                ->exists();

            // Hitung batas maksimal penyusutan (agar tidak minus di bawah residu)
            $maxDepresiasi = $asset->harga_perolehan - $asset->nilai_residu;
            $sisaDepresiasi = $maxDepresiasi - $asset->akumulasi_penyusutan;

            // Nominal penyusutan tahun ini adalah yang terkecil antara hitungan tahunan atau sisa
            // Jika sudah lunas (sisa <= 0), maka 0
            $nominal = max(0, min($penyusutanPerTahun, $sisaDepresiasi));

            // Hanya tampilkan jika masih ada nilai buku yang bisa disusutkan atau sudah disusutkan tahun ini
            if ($nominal > 0 || $isSusut) {
                $listPenyusutan[] = (object) [
                    'kode_aset'      => $asset->kode_aset,
                    'nama_aset'      => $asset->nama_aset,
                    'harga_perolehan'=> $asset->harga_perolehan,
                    'nilai_buku'     => $asset->nilaiBuku(),
                    'nominal'        => $nominal,
                    'sudah_diproses' => $isSusut,
                    'masa_manfaat'   => $asset->masa_manfaat_tahun
                ];
            }
        }

        return view('admin.penyusutan.index', compact('listPenyusutan', 'tahun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'assets' => 'required|array', // Array kode_aset yang dipilih
        ]);

        $tahun = $request->tahun;
        $processed = 0;

        try {
            DB::beginTransaction();

            // Cari Akun Beban & Akumulasi secara dinamis
            $akunBeban = DaftarAkun::where('nama_akun', 'like', '%Beban Penyusutan%')->first();
            $akunAkumulasi = DaftarAkun::where('nama_akun', 'like', '%Akumulasi Penyusutan%')->first();

            if (!$akunBeban || !$akunAkumulasi) {
                throw new \Exception("Akun 'Beban Penyusutan' atau 'Akumulasi Penyusutan' tidak ditemukan. Harap buat akun tersebut terlebih dahulu.");
            }

            foreach ($request->assets as $kodeAset) {
                $asset = AsetTetap::where('kode_aset', $kodeAset)->lockForUpdate()->first();

                if (!$asset) continue;

                // Cek apakah sudah disusutkan tahun ini (Double check)
                $cek = JurnalUmum::where('uraian', 'like', "Penyusutan Aset {$asset->kode_aset}%")
                    ->whereYear('tanggal', $tahun)
                    ->exists();

                if ($cek) continue;

                // Hitung Nominal Ulang
                if ($asset->masa_manfaat_tahun <= 0) continue;
                
                $penyusutanPerTahun = ($asset->harga_perolehan - $asset->nilai_residu) / $asset->masa_manfaat_tahun;
                $maxDepresiasi = $asset->harga_perolehan - $asset->nilai_residu;
                $sisaDepresiasi = $maxDepresiasi - $asset->akumulasi_penyusutan;
                $nominal = max(0, min($penyusutanPerTahun, $sisaDepresiasi));

                if ($nominal <= 0.01) continue;

                // 1. Update Akumulasi Penyusutan di Aset
                $asset->akumulasi_penyusutan += $nominal;
                $asset->save();

                // 2. Catat Jurnal Umum
                $noTransaksi = 'PNY-' . $tahun . '-' . $asset->kode_aset;

                JurnalUmum::create([
                    'tanggal'          => $tahun . '-12-31',
                    'no_transaksi'     => $noTransaksi,
                    'uraian'           => "Penyusutan Aset {$asset->kode_aset} ({$asset->nama_aset}) Tahun {$tahun}",
                    'kode_akun_debet'  => $akunBeban->kode_akun,
                    'kode_akun_kredit' => $akunAkumulasi->kode_akun,
                    'jumlah'           => $nominal,
                    'user_id'          => auth()->id(),
                ]);

                $processed++;
            }

            DB::commit();

            return redirect()->route('admin.penyusutan.index', ['tahun' => $tahun])
                ->with('success', "Berhasil memproses penyusutan untuk $processed aset.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses penyusutan: ' . $e->getMessage());
        }
    }
}
