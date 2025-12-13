<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenerimaanDonasi;
use App\Models\JurnalUmum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenerimaanDonasiController extends Controller
{

    public function index(Request $request)
    {
        $query = PenerimaanDonasi::with(['donatur', 'user'])->latest();

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('cara')) {
            $query->where('cara_bayar', $request->cara);
        }
        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }

        $donasis = $query->paginate(15)->withQueryString();

        return view('admin.penerimaan-donasi.index', compact('donasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'      => 'required|date',
            'kode_donatur' => 'nullable|exists:donatur,kode_donatur',
            'jenis'        => 'required|in:zakat,infak,sedekah,wakaf,lainnya',
            'keterangan'   => 'required|string',
            'jumlah'       => 'required|numeric|min:1',
            'cara_bayar'   => 'required|in:tunai,transfer,barang',
        ]);

        DB::transaction(function () use ($request) {
            $donasi = PenerimaanDonasi::create([
                'tanggal'      => $request->tanggal,
                'kode_donatur' => $request->kode_donatur,
                'jenis'        => $request->jenis,
                'keterangan'   => $request->keterangan,
                'jumlah'       => $request->jumlah,
                'cara_bayar'   => $request->cara_bayar,
                'user_id'      => auth()->id(),
            ]);

            $akunKredit = match ($request->jenis) {
                'zakat'   => '401',
                'wakaf'   => '404',
                default   => '403',
            };

            JurnalUmum::create([
                'tanggal'          => $request->tanggal,
                'no_transaksi'     => 'DON' . date('Ymd') . str_pad($donasi->id, 5, '0', STR_PAD_LEFT),
                'uraian'           => 'Penerimaan ' . ucfirst($request->jenis) . ' - ' . $request->keterangan,
                'kode_akun_debet'  => '101',
                'kode_akun_kredit' => $akunKredit,
                'jumlah'           => $request->jumlah,
                'user_id'          => auth()->id(),
            ]);
        });

        return redirect()->route('admin.penerimaan-donasi.index')
            ->with('success', 'Donasi berhasil dicatat + jurnal otomatis!');
    }
}
