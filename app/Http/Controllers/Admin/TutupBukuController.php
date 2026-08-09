<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DaftarAkun;
use App\Models\JurnalUmum;
use App\Models\SaldoAwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TutupBukuController extends Controller
{
    public function index()
    {
        $tahun = date('Y');
        // Ambil akun Ekuitas untuk menampung Laba/Rugi (biasanya Laba Ditahan atau Modal)
        $akunModal = DaftarAkun::where('kelompok', 'EKUITAS')->orderBy('kode_akun')->get();
        
        return view('admin.tutup-buku.index', compact('tahun', 'akunModal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'akun_tujuan' => 'required|exists:daftar_akun,kode_akun', // Akun Modal/Laba Ditahan
        ]);

        $tahun = $request->tahun;
        $akunTujuan = $request->akun_tujuan;
        $tanggalTutup = $tahun . '-12-31';

        // Cek apakah sudah ada jurnal tutup buku di tahun ini
        $cek = JurnalUmum::where('no_transaksi', 'LIKE', 'CL-'.$tahun.'%')->exists();
        if ($cek) {
            return back()->with('error', "Tutup buku tahun $tahun sudah pernah dilakukan.");
        }

        try {
            DB::beginTransaction();

            // Ambil semua akun Pendapatan dan Beban
            $akunNominal = DaftarAkun::whereIn('kelompok', ['PENDAPATAN', 'BEBAN'])->get();

            $totalPendapatan = 0;
            $totalBeban = 0;
            $detailJurnal = [];

            foreach ($akunNominal as $akun) {
                // Hitung Saldo Akhir Akun Tersebut
                $saldoAwal = SaldoAwal::where('kode_akun', $akun->kode_akun)
                    ->where('tahun', $tahun)
                    ->value('saldo') ?? 0;

                $mutasi = JurnalUmum::whereYear('tanggal', $tahun)
                    ->where(function($q) use ($akun) {
                        $q->where('kode_akun_debet', $akun->kode_akun)
                          ->orWhere('kode_akun_kredit', $akun->kode_akun);
                    })
                    ->selectRaw("
                        SUM(CASE WHEN kode_akun_debet = '{$akun->kode_akun}' THEN jumlah ELSE 0 END) as total_debet,
                        SUM(CASE WHEN kode_akun_kredit = '{$akun->kode_akun}' THEN jumlah ELSE 0 END) as total_kredit
                    ")
                    ->first();

                $saldoAkhir = 0;
                
                if ($akun->posisi_saldo == 'KREDIT') { // PENDAPATAN
                    $saldoAkhir = $saldoAwal + ($mutasi->total_kredit ?? 0) - ($mutasi->total_debet ?? 0);
                    if ($saldoAkhir > 0) {
                        // Untuk mengenalkan (menutup), kita harus DEBET
                        $detailJurnal[] = [
                            'posisi' => 'DEBET',
                            'kode_akun' => $akun->kode_akun,
                            'jumlah' => $saldoAkhir
                        ];
                        $totalPendapatan += $saldoAkhir;
                    }
                } else { // BEBAN (DEBET)
                    $saldoAkhir = $saldoAwal + ($mutasi->total_debet ?? 0) - ($mutasi->total_kredit ?? 0);
                    if ($saldoAkhir > 0) {
                        // Untuk mengenalkan (menutup), kita harus KREDIT
                        $detailJurnal[] = [
                            'posisi' => 'KREDIT',
                            'kode_akun' => $akun->kode_akun,
                            'jumlah' => $saldoAkhir
                        ];
                        $totalBeban += $saldoAkhir;
                    }
                }
            }

            if (empty($detailJurnal)) {
                throw new \Exception("Tidak ada saldo pendapatan atau beban yang perlu ditutup.");
            }

            // Hitung Selisih (Laba/Rugi)
            $labaRugi = $totalPendapatan - $totalBeban;
            $noTransaksi = 'CL-' . $tahun . '-001';

            // Simpan Jurnal Penutup (Looping detail)
            foreach ($detailJurnal as $detail) {
                JurnalUmum::create([
                    'tanggal' => $tanggalTutup,
                    'no_transaksi' => $noTransaksi,
                    'uraian' => 'Jurnal Penutup Tahun ' . $tahun,
                    'kode_akun_debet' => $detail['posisi'] == 'DEBET' ? $detail['kode_akun'] : null,
                    'kode_akun_kredit' => $detail['posisi'] == 'KREDIT' ? $detail['kode_akun'] : null,
                    'jumlah' => $detail['jumlah'],
                    'user_id' => auth()->id()
                ]);
            }

            // Selisih ke Akun Modal/Laba Ditahan
            if ($labaRugi != 0) {
                // Jika Laba (Pendapatan > Beban), Modal di KREDIT
                // Jika Rugi (Beban > Pendapatan), Modal di DEBET
                JurnalUmum::create([
                    'tanggal' => $tanggalTutup,
                    'no_transaksi' => $noTransaksi,
                    'uraian' => 'Jurnal Penutup (Laba/Rugi Berjalan) Tahun ' . $tahun,
                    'kode_akun_debet' => $labaRugi < 0 ? $akunTujuan : null, // Rugi -> Debet Modal
                    'kode_akun_kredit' => $labaRugi > 0 ? $akunTujuan : null, // Laba -> Kredit Modal
                    'jumlah' => abs($labaRugi),
                    'user_id' => auth()->id()
                ]);
            }

            // 5. Generate Saldo Awal Tahun Berikutnya (Opsional/Default)
            if ($request->has('generate_saldo_next_year')) {
                $nextYear = $tahun + 1;

                // Ambil Saldo Awal Tahun Ini
                $saldoAwalTahunIni = SaldoAwal::where('tahun', $tahun)->pluck('saldo', 'kode_akun');

                // Ambil Mutasi Tahun Ini (Termasuk Jurnal Penutup yang baru dibuat)
                $debet = JurnalUmum::whereYear('tanggal', $tahun)
                    ->groupBy('kode_akun_debet')
                    ->pluck(DB::raw('SUM(jumlah)'), 'kode_akun_debet');

                $kredit = JurnalUmum::whereYear('tanggal', $tahun)
                    ->groupBy('kode_akun_kredit')
                    ->pluck(DB::raw('SUM(jumlah)'), 'kode_akun_kredit');

                $allAkun = DaftarAkun::all();

                foreach ($allAkun as $akun) {
                    $awal = $saldoAwalTahunIni[$akun->kode_akun] ?? 0;
                    $d    = $debet[$akun->kode_akun] ?? 0;
                    $k    = $kredit[$akun->kode_akun] ?? 0;

                    // Hitung Saldo Akhir
                    $saldoAkhir = ($akun->posisi_saldo == 'DEBET')
                        ? ($awal + $d - $k)
                        : ($awal + $k - $d);

                    // Simpan sebagai Saldo Awal Tahun Depan
                    SaldoAwal::updateOrCreate(
                        ['kode_akun' => $akun->kode_akun, 'tahun' => $nextYear],
                        ['saldo' => $saldoAkhir]
                    );
                }
            }

            DB::commit();
            return redirect()->route('admin.jurnal-umum.index')->with('success', "Tutup buku tahun $tahun berhasil! Laba/Rugi sebesar Rp " . number_format($labaRugi, 0,',','.') . " telah dipindahkan ke akun modal.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal melakukan tutup buku: ' . $e->getMessage());
        }
    }
}