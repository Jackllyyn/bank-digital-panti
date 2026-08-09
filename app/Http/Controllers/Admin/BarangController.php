<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\PersediaanMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        if ($request->filled('filter')) {
            $filter = $request->filter;
            $query->where(function ($q) use ($filter) {
                $q->where('kode_barang', 'like', "%{$filter}%")
                  ->orWhere('nama_barang', 'like', "%{$filter}%");
            });
        }

        $barangs = $query->orderBy('kode_barang')->paginate(15);

        return view('admin.barang.index', compact('barangs'));
    }

    public function create()
    {
        $tahun = date('y');
        $last = Barang::where('kode_barang', 'like', "KB{$tahun}%")
                      ->orderByDesc('kode_barang')
                      ->first();

        $nomor = $last ? (int) substr($last->kode_barang, -5) + 1 : 1;
        $preview_kode = "KB{$tahun}" . str_pad($nomor, 5, '0', STR_PAD_LEFT);

        return view('admin.barang.create', compact('preview_kode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang'      => 'required|string|max:150',
            'satuan'           => 'required|string|max:50',
            'kategori'         => 'required|in:baku,tidak_baku',
            'stok_awal'        => 'required|numeric|min:0',
            'harga_beli_rata2' => 'nullable|numeric|min:0',
            'keterangan'       => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Generate kode barang
            $tahun = date('y');
            $lastBarang = Barang::where('kode_barang', 'like', "KB{$tahun}%")
                                ->orderByDesc('kode_barang')
                                ->first();

            $nomorBarang = $lastBarang ? (int) substr($lastBarang->kode_barang, -5) + 1 : 1;
            $kode_barang = "KB{$tahun}" . str_pad($nomorBarang, 5, '0', STR_PAD_LEFT);

            $barang = Barang::create([
                'kode_barang'      => $kode_barang,
                'nama_barang'      => $validated['nama_barang'],
                'satuan'           => $validated['satuan'],
                'kategori'         => $validated['kategori'],
                'harga_beli_rata2' => $validated['harga_beli_rata2'] ?? 0,
                'keterangan'       => $validated['keterangan'] ?? null,
            ]);

            // Jika stok awal > 0, catat sebagai persediaan masuk pertama
            if ($validated['stok_awal'] > 0) {
                $prefix = 'PM' . now()->format('Ymd');
                $lastMasuk = PersediaanMasuk::where('no_transaksi', 'like', $prefix . '%')
                                            ->orderByDesc('no_transaksi')
                                            ->first();

                $nomorMasuk = $lastMasuk ? (int) substr($lastMasuk->no_transaksi, -5) + 1 : 1;
                $noTransaksi = $prefix . str_pad($nomorMasuk, 5, '0', STR_PAD_LEFT);

                PersediaanMasuk::create([
                    'no_transaksi'     => $noTransaksi,
                    'barang_id'        => $barang->id,
                    'tanggal'          => now()->toDateString(),
                    'qty'              => $validated['stok_awal'],
                    'harga_satuan'     => $validated['harga_beli_rata2'] ?? 0,
                    'total_harga'      => $validated['stok_awal'] * ($validated['harga_beli_rata2'] ?? 0),
                    'keterangan'       => 'Stok awal saat pembuatan master barang',
                    'user_id'          => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->route('admin.barang.index')
                ->with('success', 'Barang berhasil ditambahkan dengan kode: ' . $kode_barang);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan barang: ' . $e->getMessage());
        }
    }

      public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $validated = $request->validate([
            'nama_barang'      => 'required|string|max:150',
            'satuan'           => 'required|string|max:50',
            'kategori'         => 'required|in:baku,tidak_baku',
            'harga_beli_rata2' => 'nullable|numeric|min:0',
            'keterangan'       => 'nullable|string',
        ]);

        $barang->update($validated);

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->donasiBarangDetails()->exists()) {
            return redirect()->route('admin.barang.index')
                ->with('error', 'Barang tidak bisa dihapus karena sudah pernah digunakan dalam donasi barang.');
        }

        if ($barang->persediaanMasuk()->exists() || $barang->persediaanKeluar()->exists()) {
            return redirect()->route('admin.barang.index')
                ->with('error', 'Barang tidak bisa dihapus karena sudah ada transaksi persediaan masuk/keluar.');
        }

        $barang->delete();

        return redirect()->route('admin.barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}