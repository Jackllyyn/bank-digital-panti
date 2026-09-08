<?php
// app/Http/Controllers/Admin/PengurusController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengurusController extends Controller
{
    public function index()
    {
        $pengurus = Pengurus::orderBy('urutan', 'asc')->get();
        return view('admin.pengurus.index', compact('pengurus'));
    }

    public function create()
    {
        return view('admin.pengurus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean',
            'foto' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? true : false;
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pengurus', 'public');
        }

        Pengurus::create($data);

        return redirect()->route('admin.pengurus.index')
            ->with('success', 'Pengurus berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pengurus = Pengurus::findOrFail($id);
        return view('admin.pengurus.edit', compact('pengurus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean',
            'foto' => 'nullable|image|max:2048'
        ]);

        $pengurus = Pengurus::findOrFail($id);
        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? true : false;

        if ($request->hasFile('foto')) {
            if ($pengurus->foto) {
                Storage::disk('public')->delete($pengurus->foto);
            }
            $data['foto'] = $request->file('foto')->store('pengurus', 'public');
        }

        $pengurus->update($data);

        return redirect()->route('admin.pengurus.index')
            ->with('success', 'Pengurus berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengurus = Pengurus::findOrFail($id);
        
        if ($pengurus->foto) {
            Storage::disk('public')->delete($pengurus->foto);
        }
        
        $pengurus->delete();

        return redirect()->route('admin.pengurus.index')
            ->with('success', 'Pengurus berhasil dihapus!');
    }
}