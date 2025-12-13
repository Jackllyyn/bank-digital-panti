<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnakPanti;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AnakPantiImport;

class AnakPantiController extends Controller
{
    public function index(Request $request)
    {
        $query = AnakPanti::query();

        if ($request->filled('niap')) {
            $query->where('niap', 'like', "%{$request->niap}%");
        }

        if ($request->filled('nama')) {
            $query->where('nama', 'like', "%{$request->nama}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('dari') && $request->filled('sampai')) {
            $query->whereBetween('tanggal_masuk', [$request->dari, $request->sampai]);
        }

        $anak = $query->orderBy('niap')->paginate(15);
        $anak->appends($request->query());

        return view('admin.anak-panti.index', compact('anak'));
    }

    public function create()
    {
        return view('admin.anak-panti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_masuk' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $last = AnakPanti::orderBy('niap', 'desc')->first();
        $next = $last ? (int)substr($last->niap, 1) + 1 : 1;
        $niap = 'A' . str_pad($next, 3, '0', STR_PAD_LEFT);

        $data = $request->all();
        $data['niap'] = $niap;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('anak-panti', 'public');
        }

        AnakPanti::create($data);

        return redirect()->route('admin.anak-panti.index')
            ->with('success', "Anak panti berhasil ditambahkan dengan NIAP: $niap");
    }

    public function edit($niap)
    {
        $anak = AnakPanti::findOrFail($niap);
        return view('admin.anak-panti.edit', compact('anak'));
    }

    public function update(Request $request, $niap)
    {
        $anak = AnakPanti::findOrFail($niap);

        $request->validate([
            'niap'          => 'required|string|max:15|unique:anak_panti,niap,' . $anak->niap . ',niap',
            'nama'          => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_masuk' => 'required|date',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->niap !== $anak->niap) {
            $anak->niap = $request->niap;
        }

        if ($request->hasFile('foto')) {
            if ($anak->foto) \Storage::disk('public')->delete($anak->foto);
            $data['foto'] = $request->file('foto')->store('anak-panti', 'public');
        }

        $anak->update($data);

        return redirect()->route('admin.anak-panti.index')
            ->with('success', 'Data anak panti berhasil diperbarui (NIAP: ' . $request->niap . ')');
    }

    public function destroy($niap)
    {
        $anak = AnakPanti::findOrFail($niap);
        if ($anak->foto) \Storage::disk('public')->delete($anak->foto);
        $anak->delete();

        return back()->with('success', 'Anak panti berhasil dihapus');
    }

    public function truncate(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|in:YA',
        ], [
            'confirmation.in' => 'Harap ketik "YA" untuk konfirmasi penghapusan permanen.',
        ]);

        AnakPanti::truncate();

        return redirect()->route('admin.anak-panti.index')
            ->with('success', 'Semua data anak panti berhasil dihapus permanen!');
    }

    // Method baru: proses import langsung di halaman ini
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new \App\Imports\AnakPantiImport, $request->file('file'));

            return redirect()->route('admin.anak-panti.index')
                ->with('success', 'Data anak panti berhasil diimport!');
        } catch (\Throwable $e) {
            return redirect()->route('admin.anak-panti.index')
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}