<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use App\Models\IdentitasPanti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class DonaturController extends Controller
{
    public function index(Request $request)
    {
        $query = Donatur::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('kode_donatur', 'like', '%' . $request->search . '%')
                    ->orWhere('kota', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('jenis_donatur')) {
            $query->where('jenis_donatur', $request->jenis_donatur);
        }

        if ($request->filled('klasifikasi')) {
            $query->where('klasifikasi', $request->klasifikasi);
        }

        $donaturs = $query->withMax('penerimaanDonasi', 'tanggal')
            ->withMax('donasiBarang', 'tanggal')
            ->orderByDesc('kode_donatur')
            ->paginate(50)->withQueryString();

        $trashCount = Donatur::onlyTrashed()->count();

        return view('admin.donatur.index', compact('donaturs', 'trashCount'));
    }

    public function create()
    {
        return view('admin.donatur.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:100',
            'jenis_donatur'  => 'required|in:individu,organisasi,kelompok',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'alamat_lengkap' => 'nullable|string',
            'kota'           => 'nullable|string|max:50',
            'telepon'        => 'nullable|string|max:20',
            'pekerjaan'      => 'nullable|string|max:50',
            'klasifikasi'    => 'nullable|string|max:50',
            'tanggal_daftar' => 'required|date',
        ]);

        $last = Donatur::withTrashed()->orderByDesc('kode_donatur')->first();
        $next = $last ? (int) substr($last->kode_donatur, 3) + 1 : 1;
        $kode = 'DON' . str_pad($next, 4, '0', STR_PAD_LEFT);

        $data = $request->all();
        $data['kode_donatur'] = $kode;

        Donatur::create($data);

        return redirect()->route('admin.donatur.index')
            ->with('success', 'Donatur berhasil ditambahkan dengan kode ' . $kode);
    }

    public function edit($kode_donatur)
    {
        $donatur = Donatur::where('kode_donatur', $kode_donatur)->firstOrFail();
        return view('admin.donatur.edit', compact('donatur'));
    }

    public function update(Request $request, $kode_donatur)
    {
        $donatur = Donatur::where('kode_donatur', $kode_donatur)->firstOrFail();

        $request->validate([
            'nama'           => 'required|string|max:100',
            'jenis_donatur'  => 'required|in:individu,organisasi,kelompok',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'alamat_lengkap' => 'nullable|string',
            'kota'           => 'nullable|string|max:50',
            'telepon'        => 'nullable|string|max:20',
            'pekerjaan'      => 'nullable|string|max:50',
            'klasifikasi'    => 'nullable|string|max:50',
            'tanggal_daftar' => 'required|date',
        ]);

        $donatur->update($request->all());

        return redirect()->route('admin.donatur.index')
            ->with('success', 'Data donatur berhasil diperbarui');
    }

    public function destroy($kode_donatur)
    {
        $donatur = Donatur::where('kode_donatur', $kode_donatur)->firstOrFail();
        $donatur->delete();

        return redirect()->route('admin.donatur.index')->with('success', 'Data berhasil dihapus');
    }

    public function trash()
    {
        $donaturs = Donatur::onlyTrashed()->orderBy('kode_donatur')->paginate(50);
        return view('admin.donatur.trash', compact('donaturs'));
    }

    public function restore($kode_donatur)
    {
        $donatur = Donatur::onlyTrashed()->where('kode_donatur', $kode_donatur)->firstOrFail();
        $donatur->restore();

        return back()->with('success', 'Donatur berhasil dipulihkan');
    }

    public function forceDelete($kode_donatur)
    {
        $donatur = Donatur::onlyTrashed()->where('kode_donatur', $kode_donatur)->firstOrFail();
        $donatur->forceDelete();

        return back()->with('success', 'Donatur berhasil dihapus permanen');
    }

    public function forceDeleteAll(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|in:YA'
        ], [
            'confirmation.required' => 'Anda harus mencentang kotak konfirmasi untuk melanjutkan.'
        ]);

        Donatur::onlyTrashed()->forceDelete();
        return back()->with('success', 'Semua donatur di sampah berhasil dihapus permanen');
    }

    public function truncate(Request $request)
    {
        $request->validate(['confirmation' => 'required|in:YA']);
        Donatur::truncate();
        return redirect()->route('admin.donatur.index')->with('success', 'Semua data donatur berhasil dihapus permanen');
    }

    public function exportPdf(Request $request)
    {
        $query = Donatur::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('kode_donatur', 'like', '%' . $request->search . '%')
                    ->orWhere('kota', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('jenis_donatur')) {
            $query->where('jenis_donatur', $request->jenis_donatur);
        }

        if ($request->filled('klasifikasi')) {
            $query->where('klasifikasi', $request->klasifikasi);
        }

        // === LOGIKA LAPORAN PERIODE (AKUNTANSI) ===
        $tglAwal = $request->tgl_awal;
        $tglAkhir = $request->tgl_akhir;

        if ($tglAwal && $tglAkhir) {
            // 1. Filter donatur yang memiliki transaksi pada periode ini
            $query->where(function($q) use ($tglAwal, $tglAkhir) {
                $q->whereHas('penerimaanDonasi', function($sub) use ($tglAwal, $tglAkhir) {
                    $sub->whereBetween('tanggal', [$tglAwal, $tglAkhir]);
                })->orWhereHas('donasiBarang', function($sub) use ($tglAwal, $tglAkhir) {
                    $sub->whereBetween('tanggal', [$tglAwal, $tglAkhir]);
                });
            });

            // 2. Hitung total uang (SUM) khusus periode ini
            $query->withSum(['penerimaanDonasi' => function($q) use ($tglAwal, $tglAkhir) {
                $q->whereBetween('tanggal', [$tglAwal, $tglAkhir]);
            }], 'jumlah');

            // 3. Load relasi barang untuk perhitungan manual (karena struktur detail)
            $query->with(['donasiBarang' => function($q) use ($tglAwal, $tglAkhir) {
                $q->whereBetween('tanggal', [$tglAwal, $tglAkhir])->with('details');
            }]);
        }

        $donaturs = $query->withMax('penerimaanDonasi', 'tanggal')
            ->withMax('donasiBarang', 'tanggal')
            ->orderByDesc('kode_donatur')
            ->get();

        // === POST-PROCESSING DATA PERIODE ===
        if ($tglAwal && $tglAkhir) {
            foreach ($donaturs as $donatur) {
                // Override total uang dengan hasil sum periode
                $donatur->total_donasi = $donatur->penerimaan_donasi_sum_jumlah ?? 0;

                // Hitung total barang periode manual dari relasi yang sudah diload
                $totalBarang = 0;
                if ($donatur->donasiBarang) {
                    foreach ($donatur->donasiBarang as $db) {
                        foreach ($db->details as $detail) {
                            $totalBarang += $detail->total_nilai;
                        }
                    }
                }
                $donatur->total_nilai_donasi_barang = $totalBarang;

                // Update Total Keseluruhan untuk tampilan
                $donatur->total_keseluruhan = $donatur->total_donasi + $donatur->total_nilai_donasi_barang;
            }
        }

        $identitas = IdentitasPanti::first();

        $pdf = Pdf::loadView('admin.donatur.export-pdf', compact('donaturs', 'identitas', 'request'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan_Donatur_' . date('Y-m-d_His') . '.pdf');
    }

    public function recalculate()
    {
        // Naikkan limit waktu eksekusi
        set_time_limit(300);

        $count = 0;

        Donatur::withTrashed()->chunk(100, function ($donaturs) use (&$count) {
            foreach ($donaturs as $donatur) {
                $totalUang = $donatur->penerimaanDonasi()->sum('jumlah');

                $statsBarang = DB::table('donasi_barang')
                    ->join('donasi_barang_detail', 'donasi_barang.id', '=', 'donasi_barang_detail.donasi_barang_id')
                    ->where('donasi_barang.kode_donatur', $donatur->kode_donatur)
                    ->selectRaw('SUM(donasi_barang_detail.qty) as total_qty, SUM(donasi_barang_detail.total_nilai) as total_nilai')
                    ->first();

                DB::table('donatur')
                    ->where('kode_donatur', $donatur->kode_donatur)
                    ->update([
                        'total_donasi'              => $totalUang,
                        'total_qty_donasi_barang'   => $statsBarang->total_qty ?? 0,
                        'total_nilai_donasi_barang' => $statsBarang->total_nilai ?? 0,
                    ]);
                
                $count++;
            }
        });

        return redirect()->route('admin.donatur.index')
            ->with('success', "Sinkronisasi selesai. Total donasi (uang & barang) untuk {$count} donatur telah diperbarui.");
    }

    public function struk($kode_donatur)
    {
        $donatur = Donatur::with(['penerimaanDonasi' => function ($query) {
            $query->latest();
        }, 'donasiBarang.details'])->where('kode_donatur', $kode_donatur)->firstOrFail();

        $identitas = IdentitasPanti::first();

        $totalUang       = $donatur->total_donasi ?? 0;
        $totalBarang     = $donatur->total_nilai_donasi_barang ?? 0;
        $totalKeseluruhan = $donatur->total_keseluruhan;

        $donasi = (object) [
            'kode_transaksi'     => 'KUMULATIF-' . $donatur->kode_donatur,
            'tanggal'            => $donatur->penerimaanDonasi->first()?->tanggal ?? now(),
            'jumlah_uang'        => $totalUang,
            'nilai_barang'       => $totalBarang,
            'total_keseluruhan' => $totalKeseluruhan,
            'terbilang'          => $this->terbilang($totalKeseluruhan) . ' RUPIAH',
        ];

        return view('admin.donatur.struk', compact('donatur', 'donasi', 'identitas'));
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

    public function print($kode_donatur)
    {
        $donatur = Donatur::with(['penerimaanDonasi' => function ($query) {
            $query->latest();
        }, 'donasiBarang.details'])->where('kode_donatur', $kode_donatur)->firstOrFail();

        $identitas = IdentitasPanti::first();

        return view('admin.donatur.print', compact('donatur', 'identitas'));
    }

    public function exportPdfDetail($kode_donatur)
    {
        $donatur = Donatur::with(['penerimaanDonasi' => function ($query) {
            $query->latest();
        }, 'donasiBarang.details'])->where('kode_donatur', $kode_donatur)->firstOrFail();

        $identitas = IdentitasPanti::first();

        $pdf = Pdf::loadView('admin.donatur.print', compact('donatur', 'identitas'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan_Donatur_' . $donatur->kode_donatur . '.pdf');
    }
}