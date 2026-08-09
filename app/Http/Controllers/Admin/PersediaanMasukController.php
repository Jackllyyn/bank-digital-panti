<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersediaanMasuk;
use App\Models\Barang;
use App\Models\JurnalUmum;
use App\Models\DaftarAkun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersediaanMasukController extends Controller
{
    public function index()
    {
        $masuks = PersediaanMasuk::with(['barang', 'user'])
            ->latest()
            ->paginate(15);

        return view('admin.persediaan.masuk.index', compact('masuks'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('admin.persediaan.masuk.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'      => 'required|date',
            'barang_id'    => 'required|exists:barang,id',
            'qty'          => 'required|numeric|min:0.01',
            'harga_satuan' => 'required|numeric|min:0',
            'keterangan'   => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $no = 'MASUK-' . date('ymd') . '-' . str_pad(PersediaanMasuk::count() + 1, 5, '0', STR_PAD_LEFT);

            PersediaanMasuk::create([
                'tanggal'      => $request->tanggal,
                'no_transaksi' => $no,
                'barang_id'    => $request->barang_id,
                'qty'          => $request->qty,
                'harga_satuan' => $request->harga_satuan,
                'total_harga'  => $request->qty * $request->harga_satuan,
                'keterangan'   => $request->keterangan,
                'user_id'      => auth()->id(),
            ]);

            // PENCATATAN JURNAL UMUM (Otomatis)
            // Debit: Persediaan Barang
            // Kredit: Kas (Asumsi pembelian tunai)
            
            $kodePersediaan = config('akuntansi.kode_akun.persediaan_barang', '1000');
            if (!DaftarAkun::where('kode_akun', $kodePersediaan)->exists()) {
                 $akunPersediaan = DaftarAkun::where('nama_akun', 'like', '%Persediaan%')->first();
                 $kodePersediaan = $akunPersediaan ? $akunPersediaan->kode_akun : '1000';
            }
            
            $akunKas = DaftarAkun::where('nama_akun', 'like', '%Kas%')->where('nama_akun', 'not like', '%Kecil%')->first();
            $kodeKredit = $akunKas ? $akunKas->kode_akun : '1001';

            JurnalUmum::create([
                'tanggal'          => $request->tanggal,
                'no_transaksi'     => 'JU-' . $no,
                'uraian'           => 'Pembelian Persediaan (' . $request->qty . ' unit) - ' . $request->keterangan,
                'kode_akun_debet'  => $kodePersediaan,
                'kode_akun_kredit' => $kodeKredit,
                'jumlah'           => $request->qty * $request->harga_satuan,
                'user_id'          => auth()->id(),
            ]);
        });

        return redirect()->route('admin.persediaan.masuk.index')
            ->with('success', 'Penerimaan barang berhasil dicatat.');
    }
}