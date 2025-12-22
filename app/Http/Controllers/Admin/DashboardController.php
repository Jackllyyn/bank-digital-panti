<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenerimaanDonasi;
use App\Models\Pengeluaran;
use App\Models\AnakPanti;
use App\Models\Donatur;
use App\Models\IdentitasPanti;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $tahun = date('Y');
        $bulanIni = date('Y-m');

        // Identitas Panti
        $identitas = IdentitasPanti::first();

        // Total Donasi Bulan Ini
        $donasiBulanIni = PenerimaanDonasi::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', date('m'))
            ->sum('jumlah');

        // Total Pengeluaran Bulan Ini
        $pengeluaranBulanIni = Pengeluaran::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', date('m'))
            ->sum('jumlah');

        // Surplus/Defisit Bulan Ini
        $surplusBulanIni = $donasiBulanIni - $pengeluaranBulanIni;

        // Total Anak Asuh Aktif
        $totalAnakAktif = AnakPanti::where('status', 'aktif')->count();

        // === TAMBAHAN: Hitung jumlah anak berdasarkan jenis kelamin ===
        $totalAnakLaki = AnakPanti::where('status', 'aktif')
            ->where('jenis_kelamin', 'L')
            ->count();

        $totalAnakPerempuan = AnakPanti::where('status', 'aktif')
            ->where('jenis_kelamin', 'P')
            ->count();
        // ============================================================

        // Total Donatur
        $totalDonatur = Donatur::count();

        // Aktivitas Terakhir (5 terakhir)
        $aktivitasTerakhir = \Spatie\Activitylog\Models\Activity::with('causer')
            ->latest()
            ->take(5)
            ->get();

        // Grafik Donasi vs Pengeluaran 6 Bulan Terakhir
        $grafik = collect(range(5, 0, -1))->map(function ($i) use ($tahun) {
            $bulan = date('Y-m', strtotime("-$i month"));
            return [
                'bulan' => date('M Y', strtotime($bulan)),
                'donasi' => PenerimaanDonasi::whereYear('tanggal', substr($bulan, 0, 4))
                    ->whereMonth('tanggal', substr($bulan, 5, 2))
                    ->sum('jumlah'),
                'pengeluaran' => Pengeluaran::whereYear('tanggal', substr($bulan, 0, 4))
                    ->whereMonth('tanggal', substr($bulan, 5, 2))
                    ->sum('jumlah'),
            ];
        });

        return view('admin.dashboard', compact(
            'identitas',
            'donasiBulanIni',
            'pengeluaranBulanIni',
            'surplusBulanIni',
            'totalAnakAktif',
            'totalAnakLaki',         // ← Tambahan
            'totalAnakPerempuan',   // ← Tambahan
            'totalDonatur',
            'aktivitasTerakhir',
            'grafik'
        ));
    }
}