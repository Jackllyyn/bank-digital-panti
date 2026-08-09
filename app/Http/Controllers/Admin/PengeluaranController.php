<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use App\Models\JurnalUmum;
use App\Models\DaftarAkun;
use App\Models\SaldoAwal;
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

        // Tentukan Akun Kredit (Sumber Dana: Kas)
        $akunKas = DaftarAkun::where('nama_akun', 'like', '%Kas%')
            ->where('nama_akun', 'not like', '%Kecil%')
            ->orderBy('kode_akun')
            ->first();
        $kodeKredit = $akunKas ? $akunKas->kode_akun : '1001';

        // Validasi Saldo Kas
        $tahun = date('Y', strtotime($request->tanggal));
        $saldoAwal = SaldoAwal::where('kode_akun', $kodeKredit)->where('tahun', $tahun)->value('saldo') ?? 0;
        $debit     = JurnalUmum::where('kode_akun_debet', $kodeKredit)->whereYear('tanggal', $tahun)->sum('jumlah');
        $kredit    = JurnalUmum::where('kode_akun_kredit', $kodeKredit)->whereYear('tanggal', $tahun)->sum('jumlah');
        $saldoTersedia = $saldoAwal + $debit - $kredit;

        if ($request->jumlah > $saldoTersedia) {
            return back()->withInput()->withErrors(['jumlah' => 'Saldo Kas tidak mencukupi! Saldo saat ini: Rp ' . number_format($saldoTersedia, 0, ',', '.')]);
        }

        DB::transaction(function () use ($request, $kodeKredit) {
            $pengeluaran = Pengeluaran::create($request->all() + ['user_id' => auth()->id()]);
            
            $noTransaksi = 'OUT' . date('Ymd') . str_pad($pengeluaran->id, 5, '0', STR_PAD_LEFT);

            JurnalUmum::create([
                'tanggal'          => $request->tanggal,
                'no_transaksi'     => $noTransaksi,
                'uraian'           => 'Pengeluaran: ' . $request->keterangan,
                'kode_akun_debet'  => $request->kode_akun,  // Beban
                'kode_akun_kredit' => $kodeKredit,          // Kas
                'jumlah'           => $request->jumlah,
                'user_id'          => auth()->id(),
            ]);
        });

        return redirect()->route('admin.pengeluaran.index')
            ->with('success', 'Pengeluaran berhasil dicatat + jurnal otomatis!');
    }
}