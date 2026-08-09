<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JurnalUmum;
use App\Models\DaftarAkun;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel; // Tambahkan ini
use App\Exports\JurnalExport;

class JurnalUmumController extends Controller
{
    public function index(Request $request)
    {
        $query = JurnalUmum::query()
            ->with(['user', 'akunDebet', 'akunKredit'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc');

        // Filter tanggal
        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }

        // Filter akun
        if ($request->filled('akun')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_akun_debet', $request->akun)
                  ->orWhere('kode_akun_kredit', $request->akun);
            });
        }

        // Filter sumber transaksi
        if ($request->filled('sumber')) {
            if ($request->sumber === 'donasi_barang') {
                $query->where('no_transaksi', 'like', 'JU-DB-%');
            } elseif ($request->sumber === 'donasi_uang') {
                $query->where('no_transaksi', 'like', 'DON%');
            } elseif ($request->sumber === 'manual') {
                $query->where(function ($q) {
                    $q->where('no_transaksi', 'not like', 'JU-DB-%')
                      ->where('no_transaksi', 'not like', 'DON%');
                });
            }
        }

        $jurnals = $query->paginate(20)->withQueryString();
        $akuns   = DaftarAkun::orderBy('kode_akun')->get();

        return view('admin.jurnal-umum.index', compact('jurnals', 'akuns'));
    }

    /**
     * Export ke Excel dengan filter yang sama seperti index
     */
    public function exportExcel(Request $request)
    {
        $query = JurnalUmum::query()
            ->with(['user', 'akunDebet', 'akunKredit'])
            ->orderBy('tanggal')
            ->orderBy('no_transaksi');

        // Terapkan filter yang sama
        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }
        if ($request->filled('akun')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_akun_debet', $request->akun)
                  ->orWhere('kode_akun_kredit', $request->akun);
            });
        }
        if ($request->filled('sumber')) {
            if ($request->sumber === 'donasi_barang') {
                $query->where('no_transaksi', 'like', 'JU-DB-%');
            } elseif ($request->sumber === 'donasi_uang') {
                $query->where('no_transaksi', 'like', 'DON%');
            } elseif ($request->sumber === 'manual') {
                $query->where(function ($q) {
                    $q->where('no_transaksi', 'not like', 'JU-DB-%')
                      ->where('no_transaksi', 'not like', 'DON%');
                });
            }
        }

        // Ambil data untuk export (bukan paginate)
        $jurnals = $query->get();

        // Nama file dengan timestamp
        $filename = 'jurnal-umum-' . now()->format('Ymd-His') . '.xlsx';

        // PERBAIKAN UTAMA: Gunakan Excel::download()
        return Excel::download(
            new JurnalExport($jurnals, $request->dari, $request->sampai),
            $filename
        );
    }

    /**
     * Export ke PDF dengan filter yang sama
     */
    public function exportPdf(Request $request)
    {
        $query = JurnalUmum::query()
            ->with(['user', 'akunDebet', 'akunKredit'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc');

        // Filter yang sama seperti index
        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }
        if ($request->filled('akun')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_akun_debet', $request->akun)
                  ->orWhere('kode_akun_kredit', $request->akun);
            });
        }
        if ($request->filled('sumber')) {
            if ($request->sumber === 'donasi_barang') {
                $query->where('no_transaksi', 'like', 'JU-DB-%');
            } elseif ($request->sumber === 'donasi_uang') {
                $query->where('no_transaksi', 'like', 'DON%');
            } elseif ($request->sumber === 'manual') {
                $query->where(function ($q) {
                    $q->where('no_transaksi', 'not like', 'JU-DB-%')
                      ->where('no_transaksi', 'not like', 'DON%');
                });
            }
        }

        $jurnals = $query->get();

        $pdf = Pdf::loadView('admin.jurnal-umum.pdf', compact('jurnals'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('jurnal-umum-' . now()->format('Ymd-His') . '.pdf');
    }
}