<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsetTetap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AsetTetapController extends Controller
{
    public function index()
    {
        $asets = AsetTetap::orderBy('kode_aset')->get();
        return view('admin.aset-tetap.index', compact('asets'));
    }

    public function create()
    {
        return view('admin.aset-tetap.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_aset'         => 'required|unique:aset_tetap,kode_aset',
            'nama_aset'         => 'required|string|max:150',
            'tanggal_perolehan' => 'required|date',
            'harga_perolehan'   => 'required|numeric|min:0',
            'masa_manfaat_tahun'=> 'nullable|integer|min:1',
            'nilai_residu'      => 'nullable|numeric|min:0',
            'keterangan'        => 'nullable|string',
            'foto'              => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('aset-tetap', 'public');
        }

        AsetTetap::create($data);

        return redirect()->route('admin.aset-tetap.index')
            ->with('success', 'Aset tetap berhasil ditambahkan');
    }

    public function edit($kode_aset)
    {
        $aset = AsetTetap::where('kode_aset', $kode_aset)->firstOrFail();
        return view('admin.aset-tetap.edit', compact('aset'));
    }

    public function update(Request $request, $kode_aset)
    {
        $aset = AsetTetap::where('kode_aset', $kode_aset)->firstOrFail();

        $request->validate([
            'kode_aset'         => 'required|unique:aset_tetap,kode_aset,'.$kode_aset.',kode_aset',
            'nama_aset'         => 'required|string|max:150',
            'tanggal_perolehan' => 'required|date',
            'harga_perolehan'   => 'required|numeric|min:0',
            'masa_manfaat_tahun'=> 'nullable|integer|min:1',
            'nilai_residu'      => 'nullable|numeric|min:0',
            'keterangan'        => 'nullable|string',
            'foto'              => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['_token', '_method']);

        if ($request->hasFile('foto')) {
            if ($aset->foto) {
                Storage::delete('public/' . $aset->foto);
            }
            $data['foto'] = $request->file('foto')->store('aset-tetap', 'public');
        }

        $aset->update($data);

        return redirect()->route('admin.aset-tetap.index')
            ->with('success', 'Aset tetap berhasil diperbarui');
    }

    public function destroy($kode_aset)
    {
        $aset = AsetTetap::where('kode_aset', $kode_aset)->firstOrFail();
        if ($aset->foto) {
            Storage::delete('public/' . $aset->foto);
        }
        $aset->delete();

        return response()->json(['success' => true]);
    }
}