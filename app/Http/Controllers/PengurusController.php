<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengurus = Pengurus::orderBy('urutan', 'asc')->get();
        return view('admin.pengurus.index', compact('pengurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pengurus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'jabatan'   => 'required|string|max:255',
            'email'     => 'nullable|email|max:255',
            'telepon'   => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'urutan'    => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pengurus', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        Pengurus::create($validated);

        return redirect()
            ->route('admin.pengurus.index')
            ->with('success', 'Data pengurus berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengurus $pengurus)
    {
        return view('admin.pengurus.edit', compact('pengurus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengurus $pengurus)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'jabatan'   => 'required|string|max:255',
            'email'     => 'nullable|email|max:255',
            'telepon'   => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'urutan'    => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($pengurus->foto && Storage::disk('public')->exists($pengurus->foto)) {
                Storage::disk('public')->delete($pengurus->foto);
            }
            $validated['foto'] = $request->file('foto')->store('pengurus', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $pengurus->update($validated);

        return redirect()
            ->route('admin.pengurus.index')
            ->with('success', 'Data pengurus berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengurus $pengurus)
    {
        if ($pengurus->foto && Storage::disk('public')->exists($pengurus->foto)) {
            Storage::disk('public')->delete($pengurus->foto);
        }

        $pengurus->delete();

        return redirect()
            ->route('admin.pengurus.index')
            ->with('success', 'Data pengurus berhasil dihapus.');
    }
}