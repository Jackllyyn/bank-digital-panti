<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JurnalUmum;
use App\Models\DaftarAkun;
use Illuminate\Http\Request;

class JurnalUmumController extends Controller
{
    public function index(Request $request)
    {
        $query = JurnalUmum::with(['user', 'akunDebet', 'akunKredit'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc');

        // Filter Tanggal
        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }
        if ($request->filled('akun')) {
            $query->where(function($q) use ($request) {
                $q->where('kode_akun_debet', $request->akun)
                  ->orWhere('kode_akun_kredit', $request->akun);
            });
        }

        $jurnals = $query->paginate(20)->withQueryString();
        $akuns = DaftarAkun::orderBy('kode_akun')->get();

        return view('admin.jurnal-umum.index', compact('jurnals', 'akuns'));
    }
}