<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonasiBarang;
use App\Models\DonasiBarangDetail;
use App\Models\Barang;
use App\Models\Donatur;
use App\Models\PersediaanMasuk;
use App\Models\JurnalUmum;
use App\Models\DaftarAkun;
use App\Models\IdentitasPanti;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DonasiBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DonasiBarang::query()
            ->with(['donatur', 'user', 'details.barang', 'akun'])
            ->withSum('details', 'qty')
            ->withSum('details', 'total_nilai')
            ->latest();

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        $donasis = $query->paginate(15)->withQueryString();

        return view('admin.donasi-barang.index', compact('donasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs  = Barang::orderBy('nama_barang')->get();
        $donaturs = Donatur::orderBy('nama')->get();
        $akuns    = DaftarAkun::where('kelompok', 'PENDAPATAN')->orderBy('kode_akun')->get();
        $akunDebet = DaftarAkun::where('kelompok', 'ASET')->orderBy('kode_akun')->get();
        return view('admin.donasi-barang.create', compact('barangs', 'donaturs', 'akuns', 'akunDebet'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'           => 'required|date',
            'kode_donatur'      => 'nullable|exists:donatur,kode_donatur',
            'kode_akun'         => 'required|exists:daftar_akun,kode_akun',
            'kode_akun_debet'   => 'required|exists:daftar_akun,kode_akun',
            'keterangan'        => 'nullable|string',
            'items'             => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.qty'       => 'required|integer|min:1',
            'items.*.nilai_satuan' => 'required|numeric|min:0',
            'items.*.deskripsi_barang' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Generate nomor transaksi donasi
            $prefix = 'DB-' . date('Ymd', strtotime($request->tanggal));
            $lastDonasi = DonasiBarang::where('no_transaksi', 'like', $prefix . '%')->orderByDesc('no_transaksi')->first();
            $nextNo = $lastDonasi ? (int) substr($lastDonasi->no_transaksi, -5) + 1 : 1;
            $noTransaksi = $prefix . str_pad($nextNo, 5, '0', STR_PAD_LEFT);

            // Simpan header donasi
            $donasi = DonasiBarang::create([
                'tanggal'      => $request->tanggal,
                'no_transaksi' => $noTransaksi,
                'kode_donatur' => $request->kode_donatur,
                'kode_akun'    => $request->kode_akun,
                'keterangan'   => $request->keterangan,
                'user_id'      => auth()->id(),
            ]);

            $totalNilaiDonasi = 0;
            $totalQty = 0;

            foreach ($request->items as $item) {
                $nilaiItem = $item['qty'] * $item['nilai_satuan'];
                $totalNilaiDonasi += $nilaiItem;
                $totalQty += $item['qty'];

                // Simpan detail donasi
                DonasiBarangDetail::create([
                    'donasi_barang_id' => $donasi->id,
                    'barang_id'        => $item['barang_id'],
                    'qty'              => $item['qty'],
                    'deskripsi_barang' => $item['deskripsi_barang'] ?? null,
                    'nilai_satuan'     => $item['nilai_satuan'],
                    'total_nilai'      => $nilaiItem,
                ]);

                // Simpan persediaan masuk (harga 0, hanya catatan estimasi)
                $prefix = 'PM' . now()->format('Ymd');
                $lastMasuk = PersediaanMasuk::where('no_transaksi', 'like', $prefix . '%')
                    ->orderByDesc('no_transaksi')
                    ->first();

                $nomorMasuk       = $lastMasuk ? (int) substr($lastMasuk->no_transaksi, -5) + 1 : 1;
                $noTransaksiMasuk = $prefix . str_pad($nomorMasuk, 5, '0', STR_PAD_LEFT);

                PersediaanMasuk::create([
                    'no_transaksi'     => $noTransaksiMasuk,
                    'barang_id'        => $item['barang_id'],
                    'tanggal'          => $request->tanggal,
                    'qty'              => $item['qty'],
                    'harga_satuan'     => $item['nilai_satuan'],
                    'total_harga'      => $nilaiItem,
                    'keterangan'       => 'Donasi barang - No: ' . $noTransaksi . ' (estimasi nilai: Rp ' . number_format($nilaiItem, 0, ',', '.') . ')',
                    'user_id'          => auth()->id(),
                ]);

                // Update stok master barang
                $barang = Barang::find($item['barang_id']);
                if ($barang) {
                    $barang->increment('stok_saat_ini', $item['qty']);
                }
            }

            // Update total di tabel donatur (jika ada donatur)
            if ($request->kode_donatur) {
                $this->recalculateDonatur($request->kode_donatur);
            }

            // ───────────────────────────────────────────────────────────────
            // PENCATATAN JURNAL UMUM OTOMATIS (dipisah try-catch sendiri)
            // ───────────────────────────────────────────────────────────────
            $jurnalSuccess = false;
            $jurnalMessage = '';

            try {
                // Gunakan akun debet yang dipilih user (Aset/Persediaan)
                $kodeDebet = $request->kode_akun_debet;
                $kodeKredit = $request->kode_akun;

                // Log untuk debug
                Log::info('Kode akun yang akan digunakan', [
                    'debet'  => $kodeDebet,
                    'kredit' => $kodeKredit,
                ]);

                // Validasi ulang (throw jika null atau kosong)
                if (empty($kodeDebet) || empty($kodeKredit)) {
                    throw new \Exception("Kode akun kosong: debet={$kodeDebet}, kredit={$kodeKredit}");
                }

                $noJurnal = 'JU-' . $noTransaksi;
                $uraian   = "Donasi barang " . count($request->items) . " jenis ({$totalQty} unit) - {$noTransaksi} "
                          . "(nilai wajar Rp " . number_format($totalNilaiDonasi, 0, ',', '.') . ")";

                // JURNAL TUNGGAL (Debet: Persediaan, Kredit: Pendapatan)
                JurnalUmum::create([
                    'tanggal'          => $request->tanggal,
                    'no_transaksi'     => $noJurnal,
                    'no_bukti'         => $noTransaksi,
                    'uraian'           => $uraian,
                    'kode_akun_debet'  => $kodeDebet,
                    'kode_akun_kredit' => $kodeKredit,
                    'jumlah'           => $totalNilaiDonasi,
                    'user_id'          => auth()->id(),
                ]);

                $jurnalSuccess = true;

            } catch (\Exception $jurnalError) {
                $jurnalMessage = $jurnalError->getMessage();
                Log::error('Gagal mencatat jurnal untuk donasi barang', [
                    'no_transaksi' => $noTransaksi,
                    'error'        => $jurnalMessage,
                    'trace'        => $jurnalError->getTraceAsString(),
                ]);
            }

            DB::commit();

            $successMessage = 'Donasi barang berhasil dicatat. Stok bertambah, nilai donasi tercatat.';
            if (!$jurnalSuccess) {
                $successMessage .= ' (Jurnal umum gagal: ' . $jurnalMessage . ')';
            } else {
                $successMessage .= ' Jurnal umum juga tercatat otomatis.';
            }

            return redirect()->route('admin.donasi-barang.index')
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Gagal menyimpan donasi barang sepenuhnya', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return back()->withInput()->with('error', 'Gagal mencatat donasi: ' . $e->getMessage());
        }
    }

    // Method show dan struk tetap sama seperti sebelumnya
    public function show($id)
    {
        $donasi = DonasiBarang::with(['donatur', 'details.barang', 'user'])->findOrFail($id);
        return view('admin.donasi-barang.show', compact('donasi'));
    }

    public function struk($id)
    {
        $donasi = DonasiBarang::with(['donatur', 'details.barang', 'user'])->findOrFail($id);
        $identitas = IdentitasPanti::first();
        $terbilang = $this->terbilang($donasi->details->sum('total_nilai')) . ' RUPIAH';

        $pdf = Pdf::loadView('admin.donasi-barang.struk', compact('donasi', 'identitas', 'terbilang'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Bukti_Donasi_Barang_' . $donasi->no_transaksi . '.pdf');
    }

    public function exportPdf(Request $request)
    {
        $query = DonasiBarang::query()
            ->with(['donatur', 'user', 'details.barang'])
            ->withSum('details', 'qty')
            ->withSum('details', 'total_nilai')
            ->latest();

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        $donasis = $query->get();
        $identitas = IdentitasPanti::first();

        $pdf = Pdf::loadView('admin.donasi-barang.export-pdf', compact('donasis', 'identitas', 'request'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan_Donasi_Barang_' . date('Y-m-d_His') . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $donasi = DonasiBarang::with(['details', 'donatur'])->findOrFail($id);
        $barangs  = Barang::orderBy('nama_barang')->get();
        $donaturs = Donatur::orderBy('nama')->get();
        $akuns    = DaftarAkun::where('kelompok', 'PENDAPATAN')->orderBy('kode_akun')->get();
        $akunDebet = DaftarAkun::where('kelompok', 'ASET')->orderBy('kode_akun')->get();
        
        $currentDebit = JurnalUmum::where('no_bukti', $donasi->no_transaksi)->value('kode_akun_debet');

        // Format items untuk AlpineJS
        $items = $donasi->details->map(function ($detail) {
            return [
                'barang_id'        => $detail->barang_id,
                'qty'              => $detail->qty,
                'nilai_satuan'     => $detail->nilai_satuan,
                'deskripsi_barang' => $detail->deskripsi_barang,
            ];
        });

        return view('admin.donasi-barang.edit', compact('donasi', 'barangs', 'donaturs', 'items', 'akuns', 'akunDebet', 'currentDebit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $donasi = DonasiBarang::findOrFail($id);

        $request->validate([
            'tanggal'           => 'required|date',
            'kode_donatur'      => 'nullable|exists:donatur,kode_donatur',
            'kode_akun'         => 'required|exists:daftar_akun,kode_akun',
            'kode_akun_debet'   => 'required|exists:daftar_akun,kode_akun',
            'keterangan'        => 'nullable|string',
            'items'             => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.qty'       => 'required|integer|min:1',
            'items.*.nilai_satuan' => 'required|numeric|min:0',
            'items.*.deskripsi_barang' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $oldKodeDonatur = $donasi->kode_donatur;

            // 1. Hapus dampak transaksi lama (Jurnal, Persediaan Masuk, Detail)
            // Hapus Jurnal
            JurnalUmum::where('no_bukti', $donasi->no_transaksi)->delete();

            // Hapus Persediaan Masuk & Kembalikan Stok
            $oldPersediaan = PersediaanMasuk::where('keterangan', 'like', 'Donasi barang - No: ' . $donasi->no_transaksi . '%')->get();
            foreach ($oldPersediaan as $pm) {
                $barang = Barang::find($pm->barang_id);
                if ($barang) $barang->decrement('stok_saat_ini', $pm->qty);
                $pm->delete();
            }

            // Hapus Detail Lama
            $donasi->details()->delete();

            // 2. Update Header
            $donasi->update([
                'tanggal'      => $request->tanggal,
                'kode_donatur' => $request->kode_donatur,
                'kode_akun'    => $request->kode_akun,
                'keterangan'   => $request->keterangan,
            ]);

            // 3. Simpan Detail Baru & Persediaan Masuk Baru
            $totalNilaiDonasi = 0;
            $totalQty = 0;

            foreach ($request->items as $item) {
                $nilaiItem = $item['qty'] * $item['nilai_satuan'];
                $totalNilaiDonasi += $nilaiItem;
                $totalQty += $item['qty'];

                DonasiBarangDetail::create([
                    'donasi_barang_id' => $donasi->id,
                    'barang_id'        => $item['barang_id'],
                    'qty'              => $item['qty'],
                    'deskripsi_barang' => $item['deskripsi_barang'] ?? null,
                    'nilai_satuan'     => $item['nilai_satuan'],
                    'total_nilai'      => $nilaiItem,
                ]);

                // Buat Persediaan Masuk Baru
                $prefix = 'PM' . now()->format('Ymd');
                $lastMasuk = PersediaanMasuk::where('no_transaksi', 'like', $prefix . '%')->orderByDesc('no_transaksi')->first();
                $nomorMasuk = $lastMasuk ? (int) substr($lastMasuk->no_transaksi, -5) + 1 : 1;
                $noTransaksiMasuk = $prefix . str_pad($nomorMasuk, 5, '0', STR_PAD_LEFT);

                PersediaanMasuk::create([
                    'no_transaksi'     => $noTransaksiMasuk,
                    'barang_id'        => $item['barang_id'],
                    'tanggal'          => $request->tanggal,
                    'qty'              => $item['qty'],
                    'harga_satuan'     => $item['nilai_satuan'],
                    'total_harga'      => $nilaiItem,
                    'keterangan'       => 'Donasi barang - No: ' . $donasi->no_transaksi . ' (estimasi nilai: Rp ' . number_format($nilaiItem, 0, ',', '.') . ')',
                    'user_id'          => auth()->id(),
                ]);

                // Update stok master barang (tambah baru)
                $barang = Barang::find($item['barang_id']);
                if ($barang) {
                    $barang->increment('stok_saat_ini', $item['qty']);
                }
            }

            // 4. Buat Jurnal Baru (Panggil logika jurnal yang sama dengan store, atau copy paste logic jurnal di sini)
            $jurnalSuccess = false;
            $jurnalMessage = '';
            
            try {
                $kodeDebet = $request->kode_akun_debet;
                $kodeKredit = $request->kode_akun;
                
                if (empty($kodeDebet) || empty($kodeKredit)) {
                    throw new \Exception("Kode akun kosong: debet={$kodeDebet}, kredit={$kodeKredit}");
                }

                $noJurnal = 'JU-' . $donasi->no_transaksi;
                $uraian   = "Donasi barang " . count($request->items) . " jenis ({$totalQty} unit) - {$donasi->no_transaksi} (nilai wajar Rp " . number_format($totalNilaiDonasi, 0, ',', '.') . ")";

                // JURNAL TUNGGAL
                JurnalUmum::create([
                    'tanggal'          => $request->tanggal,
                    'no_transaksi'     => $noJurnal,
                    'no_bukti'         => $donasi->no_transaksi,
                    'uraian'           => $uraian,
                    'kode_akun_debet'  => $kodeDebet,
                    'kode_akun_kredit' => $kodeKredit,
                    'jumlah'           => $totalNilaiDonasi,
                    'user_id'          => auth()->id(),
                ]);
                
                $jurnalSuccess = true;
            } catch (\Exception $jurnalError) {
                $jurnalMessage = $jurnalError->getMessage();
                Log::error('Gagal mencatat jurnal update donasi barang', [
                    'no_transaksi' => $donasi->no_transaksi,
                    'error'        => $jurnalMessage
                ]);
            }

            // 5. Update Total Donatur (Recalculate)
            if ($request->kode_donatur) {
                $this->recalculateDonatur($request->kode_donatur);
            }
            
            // Jika donatur berubah, update juga donatur lama
            if ($oldKodeDonatur && $oldKodeDonatur !== $request->kode_donatur) {
                $this->recalculateDonatur($oldKodeDonatur);
            }

            DB::commit();
            
            $successMessage = 'Donasi barang berhasil diperbarui.';
            if (!$jurnalSuccess && !empty($jurnalMessage)) {
                $successMessage .= ' (Namun jurnal umum gagal diperbarui: ' . $jurnalMessage . ')';
            }
            
            return redirect()->route('admin.donasi-barang.index')->with('success', $successMessage);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui donasi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $donasi = DonasiBarang::findOrFail($id);
        try {
            DB::beginTransaction();
            
            // 1. Hapus Jurnal
            JurnalUmum::where('no_bukti', $donasi->no_transaksi)->delete();

            // 2. Hapus Persediaan Masuk
            $oldPersediaan = PersediaanMasuk::where('keterangan', 'like', 'Donasi barang - No: ' . $donasi->no_transaksi . '%')->get();
            foreach ($oldPersediaan as $pm) {
                $barang = Barang::find($pm->barang_id);
                if ($barang) $barang->decrement('stok_saat_ini', $pm->qty);
                $pm->delete();
            }

            // 3. Hapus Detail
            $donasi->details()->delete();

            // 4. Simpan kode donatur untuk recalculate sebelum hapus header
            $kodeDonatur = $donasi->kode_donatur;

            // 5. Hapus Header
            $donasi->delete();

            // 6. Update Total Donatur
            if ($kodeDonatur) {
                $this->recalculateDonatur($kodeDonatur);
            }

            DB::commit();
            return redirect()->route('admin.donasi-barang.index')->with('success', 'Donasi barang berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus donasi: ' . $e->getMessage());
        }
    }

    // Helper untuk hitung ulang total donatur
    private function recalculateDonatur($kodeDonatur)
    {
        $stats = DB::table('donasi_barang')
            ->join('donasi_barang_detail', 'donasi_barang.id', '=', 'donasi_barang_detail.donasi_barang_id')
            ->where('donasi_barang.kode_donatur', $kodeDonatur)
            ->selectRaw('SUM(donasi_barang_detail.qty) as total_qty, SUM(donasi_barang_detail.total_nilai) as total_nilai')
            ->first();

        Donatur::withTrashed()->where('kode_donatur', $kodeDonatur)->update([
            'total_qty_donasi_barang'   => $stats->total_qty ?? 0,
            'total_nilai_donasi_barang' => $stats->total_nilai ?? 0
        ]);
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