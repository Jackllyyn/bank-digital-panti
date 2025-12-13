<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventaris;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $query = Inventaris::query();
        if ($search) {
            $query->where('kode_barang', 'like', "%$search%")
                  ->orWhere('nama_barang', 'like', "%$search%");
        }
        $inventaris = $query->orderBy('kode_barang')->paginate(15);
        return view('admin.inventaris.index', compact('inventaris'));
    }

    public function create()
    {
        $kode = Inventaris::generateKode();
        return view('admin.inventaris.create', compact('kode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:inventaris,kode_barang',
            'nama_barang' => 'required|string|max:150',
            'satuan' => 'nullable|string|max:20',
            'stok' => 'required|numeric|min:0',
            'harga_rata2' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('inventaris', 'public');
        }

        Inventaris::create($data);

        return redirect()->route('admin.inventaris.index')->with('success', 'Barang inventaris berhasil ditambahkan.');
    }

    public function edit($kode_barang)
    {
        $inventari = Inventaris::findOrFail($kode_barang);
        return view('admin.inventaris.edit', compact('inventari'));
    }

    public function update(Request $request, $kode_barang)
    {
        $inventari = Inventaris::findOrFail($kode_barang);

        $request->validate([
            'kode_barang' => 'required|unique:inventaris,kode_barang,' . $kode_barang . ',kode_barang',
            'nama_barang' => 'required|string|max:150',
            'satuan' => 'nullable|string|max:20',
            'stok' => 'required|numeric|min:0',
            'harga_rata2' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->kode_barang !== $kode_barang) {
            $data['kode_barang'] = $request->kode_barang;
        }

        if ($request->hasFile('foto')) {
            if ($inventari->foto) \Storage::disk('public')->delete($inventari->foto);
            $data['foto'] = $request->file('foto')->store('inventaris', 'public');
        }

        $inventari->update($data);

        return redirect()->route('admin.inventaris.index')->with('success', 'Barang inventaris berhasil diperbarui.');
    }

    public function destroy($kode_barang)
    {
        $inventari = Inventaris::findOrFail($kode_barang);
        if ($inventari->foto) \Storage::disk('public')->delete($inventari->foto);
        $inventari->delete();

        return back()->with('success', 'Barang inventaris berhasil dihapus.');
    }
}