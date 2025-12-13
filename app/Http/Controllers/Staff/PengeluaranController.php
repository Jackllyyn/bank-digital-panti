<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use App\Models\JurnalUmum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    public function create()
    {
        $akuns = \App\Models\DaftarAkun::where('kelompok', 'BEBAN')->orderBy('kode_akun')->get();
        return view('staff.pengeluaran.create', compact('akuns'));
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
                'kode_akun_debet'  => $request->kode_akun,
                'kode_akun_kredit' => '101',
                'jumlah'           => $request->jumlah,
                'user_id'          => auth()->id(),
            ]);
        });

        return redirect()->route('staff.dashboard')
            ->with('success', 'Pengeluaran berhasil dicatat + jurnal otomatis!');
    }
}