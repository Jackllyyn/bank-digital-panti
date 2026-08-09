<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersediaanKeluar;
use App\Models\Barang;
use App\Models\JurnalUmum;
use App\Models\DaftarAkun;
use App\Models\IdentitasPanti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PersediaanKeluarController extends Controller
{
    public function index()
    {
        $keluars = PersediaanKeluar::with(['barang', 'user'])
            ->latest()
            ->paginate(15);

        return view('admin.penjualan-pemakaian-barang.index', compact('keluars'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        
        // Ambil akun Kas/Bank untuk tujuan penerimaan uang penjualan
        $akunKas = DaftarAkun::where('kelompok', 'ASET')
            ->where(function($q) {
                $q->where('nama_akun', 'like', '%Kas%')
                  ->orWhere('nama_akun', 'like', '%Bank%');
            })->orderBy('kode_akun')->get();

        // Ambil akun Pendapatan
        $akunPendapatan = DaftarAkun::where('kelompok', 'PENDAPATAN')->orderBy('kode_akun')->get();

        // Ambil akun Beban (untuk Pemakaian)
        $akunBeban = DaftarAkun::where('kelompok', 'BEBAN')->orderBy('kode_akun')->get();

        // Ambil akun Persediaan (untuk Pemakaian - Kredit)
        $akunPersediaan = DaftarAkun::where('kelompok', 'ASET')->where('nama_akun', 'like', '%Persediaan%')->orderBy('kode_akun')->get();

        return view('admin.penjualan-pemakaian-barang.create', compact('barangs', 'akunKas', 'akunPendapatan', 'akunBeban', 'akunPersediaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'         => 'required|date',
            'jenis_transaksi' => 'required|in:pemakaian,penjualan',
            'keterangan'      => 'nullable|string',
            
            // Validasi Array Items
            'items'           => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.qty'       => 'required|integer|min:1',

            // Validasi khusus penjualan
            'items.*.harga_jual'   => 'required_if:jenis_transaksi,penjualan|numeric|min:0',
            'kode_akun_kas'        => 'required_if:jenis_transaksi,penjualan|exists:daftar_akun,kode_akun',
            'kode_akun_pendapatan' => 'required_if:jenis_transaksi,penjualan|exists:daftar_akun,kode_akun',
            
            // Validasi khusus pemakaian
            'items.*.total_nilai'  => 'required_if:jenis_transaksi,pemakaian|numeric|min:0',
            'kode_akun_beban'      => 'required_if:jenis_transaksi,pemakaian|exists:daftar_akun,kode_akun',
            'kode_akun_persediaan' => 'required_if:jenis_transaksi,pemakaian|exists:daftar_akun,kode_akun',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $prefix = $request->jenis_transaksi == 'penjualan' ? 'JUAL-' : 'PAKAI-';
                $prefix .= date('ymd', strtotime($request->tanggal)) . '-';

                // Ambil nomor urut terakhir untuk hari ini
                $last = PersediaanKeluar::where('no_transaksi', 'like', $prefix . '%')
                    ->orderByDesc('no_transaksi')
                    ->first();
                $next = $last ? (int) substr($last->no_transaksi, -5) + 1 : 1;

                // Persiapan Akun HPP & Persediaan (untuk Penjualan) di luar loop
                $kodePersediaanDefault = config('akuntansi.kode_akun.persediaan_barang', '1000');
                if (!DaftarAkun::where('kode_akun', $kodePersediaanDefault)->exists()) {
                    $akunPersediaan = DaftarAkun::where('nama_akun', 'like', '%Persediaan%')->first();
                    $kodePersediaanDefault = $akunPersediaan ? $akunPersediaan->kode_akun : '1000';
                }
                $akunHPP = DaftarAkun::where('nama_akun', 'like', '%Beban Pokok%')
                                    ->orWhere('nama_akun', 'like', '%HPP%')
                                    ->orWhere('kelompok', 'BEBAN')
                                    ->first();
                $kodeHPP = $akunHPP ? $akunHPP->kode_akun : '5000';

                foreach ($request->items as $item) {
                    $barang = Barang::findOrFail($item['barang_id']);

                    // Cek stok
                    if ($barang->stok_saat_ini < $item['qty']) {
                        throw new \Exception("Stok barang {$barang->nama_barang} tidak mencukupi. Sisa: {$barang->stok_saat_ini}");
                    }

                    // Generate No Transaksi Unik per Item
                    $no = $prefix . str_pad($next, 5, '0', STR_PAD_LEFT);
                    $next++; // Increment untuk item berikutnya

                    PersediaanKeluar::create([
                        'tanggal'      => $request->tanggal,
                        'no_transaksi' => $no,
                        'barang_id'    => $item['barang_id'],
                        'qty'          => $item['qty'],
                        'keterangan'   => ucfirst($request->jenis_transaksi) . ' - ' . $request->keterangan,
                        'user_id'      => auth()->id(),
                    ]);

                    // Kurangi stok
                    $barang->decrement('stok_saat_ini', $item['qty']);

                    // Hitung Cost
                    $totalCost = $item['qty'] * $barang->harga_beli_rata2;

                    if ($request->jenis_transaksi == 'pemakaian') {
                        // --- SKENARIO 1: PEMAKAIAN ---
                        $nilaiPemakaian = $item['total_nilai'] ?? $totalCost;
                        
                        JurnalUmum::create([
                            'tanggal'          => $request->tanggal,
                            'no_transaksi'     => 'JU-' . $no,
                            'no_bukti'         => $no,
                            'uraian'           => 'Pemakaian Persediaan (' . $item['qty'] . ' ' . $barang->satuan . ') - ' . $request->keterangan,
                            'kode_akun_debet'  => $request->kode_akun_beban,
                            'kode_akun_kredit' => $request->kode_akun_persediaan,
                            'jumlah'           => $nilaiPemakaian,
                            'user_id'          => auth()->id(),
                        ]);

                    } else {
                        // --- SKENARIO 2: PENJUALAN ---
                        
                        // A. Pendapatan
                        JurnalUmum::create([
                            'tanggal'          => $request->tanggal,
                            'no_transaksi'     => 'JU-' . $no,
                            'no_bukti'         => $no,
                            'uraian'           => 'Penjualan Barang (' . $item['qty'] . ' ' . $barang->satuan . ') - ' . $request->keterangan,
                            'kode_akun_debet'  => $request->kode_akun_kas,
                            'kode_akun_kredit' => $request->kode_akun_pendapatan,
                            'jumlah'           => $item['harga_jual'],
                            'user_id'          => auth()->id(),
                        ]);

                        // B. HPP
                        if ($totalCost > 0) {
                            JurnalUmum::create([
                                'tanggal'          => $request->tanggal,
                                'no_transaksi'     => 'JU-' . $no . '-HPP',
                                'no_bukti'         => $no,
                                'uraian'           => 'HPP Penjualan (' . $item['qty'] . ' ' . $barang->satuan . ')',
                                'kode_akun_debet'  => $kodeHPP,
                                'kode_akun_kredit' => $kodePersediaanDefault,
                                'jumlah'           => $totalCost,
                                'user_id'          => auth()->id(),
                            ]);
                        }
                    }
                }
            });
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }

        return redirect()->route('admin.penjualan-pemakaian-barang.index')
            ->with('success', 'Transaksi stok keluar berhasil dicatat.');
    }

    public function edit($id)
    {
        $keluar = PersediaanKeluar::findOrFail($id);
        $barangs = Barang::orderBy('nama_barang')->get();

        // Tentukan jenis transaksi dari no_transaksi atau keterangan
        $jenis_transaksi = str_contains($keluar->no_transaksi, 'JUAL') ? 'penjualan' : 'pemakaian';

        // Ambil akun Kas/Bank
        $akunKas = DaftarAkun::where('kelompok', 'ASET')
            ->where(function($q) {
                $q->where('nama_akun', 'like', '%Kas%')
                  ->orWhere('nama_akun', 'like', '%Bank%');
            })->orderBy('kode_akun')->get();

        // Ambil akun Pendapatan
        $akunPendapatan = DaftarAkun::where('kelompok', 'PENDAPATAN')->orderBy('kode_akun')->get();

        // Ambil akun Beban (untuk Pemakaian)
        $akunBeban = DaftarAkun::where('kelompok', 'BEBAN')->orderBy('kode_akun')->get();

        // Ambil akun Persediaan (untuk Pemakaian - Kredit)
        $akunPersediaan = DaftarAkun::where('kelompok', 'ASET')->where('nama_akun', 'like', '%Persediaan%')->orderBy('kode_akun')->get();

        // Coba ambil data jurnal lama untuk mengisi form (khusus penjualan)
        $jurnalKas = JurnalUmum::where('no_bukti', $keluar->no_transaksi)
                        ->whereIn('kode_akun_debet', $akunKas->pluck('kode_akun'))
                        ->first();

        $jurnalPendapatan = JurnalUmum::where('no_bukti', $keluar->no_transaksi)
                            ->whereIn('kode_akun_kredit', $akunPendapatan->pluck('kode_akun'))
                            ->first();

        $harga_jual = $jurnalKas ? $jurnalKas->jumlah : 0;
        $kode_akun_kas = $jurnalKas ? $jurnalKas->kode_akun_debet : null;
        $kode_akun_pendapatan = $jurnalPendapatan ? $jurnalPendapatan->kode_akun_kredit : null;

        // Data jurnal lama untuk pemakaian
        $jurnalBeban = JurnalUmum::where('no_bukti', $keluar->no_transaksi)
                        ->whereIn('kode_akun_debet', $akunBeban->pluck('kode_akun'))
                        ->first();
        
        $total_nilai = $jurnalBeban ? $jurnalBeban->jumlah : 0;
        $kode_akun_beban = $jurnalBeban ? $jurnalBeban->kode_akun_debet : null;
        $kode_akun_persediaan = $jurnalBeban ? $jurnalBeban->kode_akun_kredit : null;

        // Bersihkan keterangan dari prefix otomatis
        $keterangan_clean = str_ireplace(['Pemakaian - ', 'Penjualan - '], '', $keluar->keterangan);

        return view('admin.penjualan-pemakaian-barang.edit', compact(
            'keluar', 'barangs', 'akunKas', 'akunPendapatan',
            'akunBeban', 'akunPersediaan',
            'jenis_transaksi', 'harga_jual', 'kode_akun_kas',
            'kode_akun_pendapatan', 'keterangan_clean',
            'total_nilai', 'kode_akun_beban', 'kode_akun_persediaan'
        ));
    }

    public function update(Request $request, $id)
    {
        $keluar = PersediaanKeluar::findOrFail($id);

        $request->validate([
            'tanggal'         => 'required|date',
            'barang_id'       => 'required|exists:barang,id',
            'qty'             => 'required|integer|min:1',
            'jenis_transaksi' => 'required|in:pemakaian,penjualan',
            'keterangan'      => 'nullable|string',
            'harga_jual'           => 'required_if:jenis_transaksi,penjualan|numeric|min:0',
            'kode_akun_kas'        => 'required_if:jenis_transaksi,penjualan|exists:daftar_akun,kode_akun',
            'kode_akun_pendapatan' => 'required_if:jenis_transaksi,penjualan|exists:daftar_akun,kode_akun',
            'total_nilai'          => 'required_if:jenis_transaksi,pemakaian|numeric|min:0',
            'kode_akun_beban'      => 'required_if:jenis_transaksi,pemakaian|exists:daftar_akun,kode_akun',
            'kode_akun_persediaan' => 'required_if:jenis_transaksi,pemakaian|exists:daftar_akun,kode_akun',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        // Validasi Stok (Stok tersedia = Stok Real Saat Ini + Qty Lama yang akan diedit)
        if ($request->barang_id != $keluar->barang_id) {
             if ($barang->stok_saat_ini < $request->qty) {
                return back()->withErrors(['qty' => 'Stok barang baru tidak mencukupi.'])->withInput();
             }
        } else {
             $available = $barang->stok_saat_ini + $keluar->qty;
             if ($available < $request->qty) {
                return back()->withErrors(['qty' => 'Stok tidak mencukupi. Maksimal: ' . number_format($available, 0, ',', '.')])->withInput();
             }
        }

        DB::transaction(function () use ($request, $keluar, $barang) {
            // 1. Kembalikan stok lama terlebih dahulu
            if ($keluar->barang) {
                $keluar->barang->increment('stok_saat_ini', $keluar->qty);
            }

            // Cek perubahan jenis transaksi untuk update No Transaksi
            $oldNo = $keluar->no_transaksi;
            $newNo = $oldNo;
            $currentType = str_contains($oldNo, 'JUAL') ? 'penjualan' : 'pemakaian';
            $dateChanged = date('Y-m-d', strtotime($keluar->tanggal)) !== date('Y-m-d', strtotime($request->tanggal));

            if ($currentType !== $request->jenis_transaksi || $dateChanged) {
                $prefix = $request->jenis_transaksi == 'penjualan' ? 'JUAL-' : 'PAKAI-';
                $prefix .= date('ymd', strtotime($request->tanggal)) . '-';
                
                $last = PersediaanKeluar::where('no_transaksi', 'like', $prefix . '%')->orderByDesc('no_transaksi')->first();
                $next = $last ? (int) substr($last->no_transaksi, -5) + 1 : 1;
                $newNo = $prefix . str_pad($next, 5, '0', STR_PAD_LEFT);
            }

            // 2. Update Data Persediaan
            $keluar->update([
                'tanggal'      => $request->tanggal,
                'no_transaksi' => $newNo,
                'barang_id'    => $request->barang_id,
                'qty'          => $request->qty,
                'keterangan'   => ucfirst($request->jenis_transaksi) . ' - ' . $request->keterangan,
            ]);

            // 3. Kurangi stok baru (dari barang yang dipilih di form)
            $barang->decrement('stok_saat_ini', $request->qty);

            // 4. Update Jurnal (Hapus lama, buat baru)
            JurnalUmum::where('no_bukti', $oldNo)->delete();

            // Gunakan logika yang sama dengan store() untuk membuat jurnal baru
            $no = $newNo;
            $totalCost = $request->qty * $barang->harga_beli_rata2;

            if ($request->jenis_transaksi == 'pemakaian') {
                $nilaiPemakaian = $request->total_nilai ?? $totalCost;
                JurnalUmum::create([
                    'tanggal'          => $request->tanggal,
                    'no_transaksi'     => 'JU-' . $no,
                    'no_bukti'         => $no,
                    'uraian'           => 'Pemakaian Persediaan (' . $request->qty . ' ' . $barang->satuan . ') - ' . $request->keterangan,
                    'kode_akun_debet'  => $request->kode_akun_beban,
                    'kode_akun_kredit' => $request->kode_akun_persediaan,
                    'jumlah'           => $nilaiPemakaian,
                    'user_id'          => auth()->id()
                ]);
            } else {
                // Penjualan: Jurnal Pendapatan
                JurnalUmum::create([
                    'tanggal'          => $request->tanggal,
                    'no_transaksi'     => 'JU-' . $no,
                    'no_bukti'         => $no,
                    'uraian'           => 'Penjualan Barang (' . $request->qty . ' ' . $barang->satuan . ') - ' . $request->keterangan,
                    'kode_akun_debet'  => $request->kode_akun_kas,
                    'kode_akun_kredit' => $request->kode_akun_pendapatan,
                    'jumlah'           => $request->harga_jual,
                    'user_id'          => auth()->id()
                ]);

                // Tentukan Akun Persediaan (Kredit) untuk HPP
                $kodePersediaan = config('akuntansi.kode_akun.persediaan_barang', '1000');
                if (!DaftarAkun::where('kode_akun', $kodePersediaan)->exists()) {
                     $akunPersediaan = DaftarAkun::where('nama_akun', 'like', '%Persediaan%')->first();
                     $kodePersediaan = $akunPersediaan ? $akunPersediaan->kode_akun : '1000';
                }
                // Penjualan: Jurnal HPP
                $akunHPP = DaftarAkun::where('nama_akun', 'like', '%Beban Pokok%')->orWhere('nama_akun', 'like', '%HPP%')->orWhere('kelompok', 'BEBAN')->first();
                $kodeHPP = $akunHPP ? $akunHPP->kode_akun : '5000';

                if ($totalCost > 0) {
                    JurnalUmum::create([
                        'tanggal'          => $request->tanggal,
                        'no_transaksi'     => 'JU-' . $no . '-HPP',
                        'no_bukti'         => $no,
                        'uraian'           => 'HPP Penjualan (' . $request->qty . ' ' . $barang->satuan . ')',
                        'kode_akun_debet'  => $kodeHPP,
                        'kode_akun_kredit' => $kodePersediaan,
                        'jumlah'           => $totalCost,
                        'user_id'          => auth()->id()
                    ]);
                }
            }
        });

        return redirect()->route('admin.penjualan-pemakaian-barang.index')->with('success', 'Transaksi stok keluar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $keluar = PersediaanKeluar::findOrFail($id);
        DB::transaction(function () use ($keluar) {
            // Kembalikan stok sebelum menghapus transaksi
            if ($keluar->barang) {
                $keluar->barang->increment('stok_saat_ini', $keluar->qty);
            }
            
            JurnalUmum::where('no_bukti', $keluar->no_transaksi)->delete();
            $keluar->delete();
        });
        return redirect()->route('admin.penjualan-pemakaian-barang.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function print($id)
    {
        $keluar = PersediaanKeluar::with(['barang', 'user'])->findOrFail($id);
        $identitas = IdentitasPanti::first();
        $jurnals = JurnalUmum::where('no_bukti', $keluar->no_transaksi)->get();
        $pdf = Pdf::loadView('admin.penjualan-pemakaian-barang.print', compact('keluar', 'identitas', 'jurnals'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Bukti_Keluar_' . $keluar->no_transaksi . '.pdf');
    }
}