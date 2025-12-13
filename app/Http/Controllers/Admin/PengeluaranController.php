<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use App\Models\JurnalUmum;
use App\Models\DaftarAkun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluaran::with(['akun', 'user'])->latest();

        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }
        if ($request->filled('akun')) {
            $query->where('kode_akun', $request->akun);
        }

        $pengeluarans = $query->paginate(15)->withQueryString();
        $akuns = DaftarAkun::where('kelompok', 'BEBAN')->orderBy('kode_akun')->get();

        return view('admin.pengeluaran.index', compact('pengeluarans', 'akuns'));
    }

    public function create()
    {
        $akuns = \App\Models\DaftarAkun::where('kelompok', 'BEBAN')
                    ->orderBy('kode_akun')
                    ->get();

        return view('admin.pengeluaran.create', compact('akuns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'     => 'required|date',
            'kode_akun'   => 'required|exists:daftar_akun,kode_akun',
            'keterangan'  => 'required|string',
            'jumlah'      => 'required|numeric|min:1',
            'no_bukti'    => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request) {
            $pengeluaran = Pengeluaran::create($request->all() + ['user_id' => auth()->id()]);

            JurnalUmum::create([
                'tanggal'          => $request->tanggal,
                'no_transaksi'     => 'OUT' . date('Ymd') . str_pad($pengeluaran->id, 5, '0', STR_PAD_LEFT),
                'uraian'           => 'Pengeluaran: ' . $request->keterangan,
                'kode_akun_debet'  => $request->kode_akun,  // Beban
                'kode_akun_kredit' => '101',                // Kas
                'jumlah'           => $request->jumlah,
                'user_id'          => auth()->id(),
            ]);
        });

        return redirect()->route('admin.pengeluaran.index')
            ->with('success', 'Pengeluaran berhasil dicatat + jurnal otomatis!');
    }
}