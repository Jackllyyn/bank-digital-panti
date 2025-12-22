<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use App\Models\IdentitasPanti;
use Illuminate\Http\Request;

class DonaturController extends Controller
{
    public function index(Request $request)
    {
        $query = Donatur::query();

        if ($request->filled('jenis')) {
            $query->where('jenis_donatur', $request->jenis);
        }

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->cari . '%')
                    ->orWhere('kode_donatur', 'like', '%' . $request->cari . '%')
                    ->orWhere('telepon', 'like', '%' . $request->cari . '%');
            });
        }

        $donaturs = $query->orderBy('kode_donatur')->paginate(15)->withQueryString();

        return view('admin.donatur.index', compact('donaturs'));
    }

    public function create()
    {
        return view('admin.donatur.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:100',
            'jenis_donatur'  => 'required|in:perorangan,lembaga,perusahaan,lainnya',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'alamat_lengkap' => 'nullable|string',
            'kota'           => 'nullable|string|max:50',
            'telepon'        => 'nullable|string|max:20',
            'pekerjaan'      => 'nullable|string|max:50',
            'klasifikasi'    => 'nullable|string|max:50',
            'tanggal_daftar' => 'required|date',
        ]);

        $last = Donatur::orderByDesc('kode_donatur')->first();
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
            'jenis_donatur'  => 'required|in:perorangan,lembaga,perusahaan,lainnya',
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

        return response()->json(['success' => true]);
    }

    public function trash()
    {
        $donaturs = Donatur::onlyTrashed()->orderBy('kode_donatur')->paginate(15);
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

    public function forceDeleteAll()
    {
        Donatur::onlyTrashed()->forceDelete();
        return back()->with('success', 'Semua donatur di sampah berhasil dihapus permanen');
    }

    public function truncate(Request $request)
    {
        $request->validate(['confirmation' => 'required|in:YA']);
        Donatur::truncate();
        return redirect()->route('admin.donatur.index')->with('success', 'Semua data donatur berhasil dihapus permanen');
    }

    /**
     * Cetak struk kumulatif total donasi seorang donatur
     */
    /**
     * Cetak struk kumulatif total donasi seorang donatur
     */
    public function struk($kode_donatur)
    {
        $donatur = Donatur::with(['penerimaanDonasi' => function ($query) {
            $query->latest();
        }])->where('kode_donatur', $kode_donatur)->firstOrFail();

        // Total donasi kumulatif
        $totalDonasi = $donatur->penerimaanDonasi->sum('jumlah');

        $identitas = IdentitasPanti::first();

        // View yang benar: admin.donatur.struk
        return view('admin.donatur.struk', [
            'donatur'    => $donatur,
            'donasi'     => (object)[
                'kode_transaksi' => 'KUMULATIF-' . $donatur->kode_donatur,
                'tanggal'        => $donatur->penerimaanDonasi->first()?->tanggal ?? now(),
                'jumlah'         => $totalDonasi,
            ],
            'identitas'  => $identitas,
        ]);
    }
}
