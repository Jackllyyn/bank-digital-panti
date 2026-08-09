<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IdentitasPanti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IdentitasPantiController extends Controller
{
    public function edit()
    {
        $identitas = IdentitasPanti::firstOrCreate([]); 
        return view('admin.identitas-panti.edit', compact('identitas'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'nama_yayasan'  => 'required|string|max:255',
            'nama_panti'    => 'required|string|max:255',
            'alamat'        => 'nullable|string',
            'kota'          => 'nullable|string|max:100',
            'kode_pos'      => 'nullable|string|max:10',
            'telepon'       => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
            'website'       => 'nullable|url|max:255',
            'pimpinan'      => 'nullable|string|max:100',
            'bendahara'     => 'nullable|string|max:100',
            'npwp'          => 'nullable|string|max:50',
            'no_rekening'   => 'nullable|string|max:50',
            'nama_bank'     => 'nullable|string|max:50',
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        $identitas = IdentitasPanti::firstOrCreate([]);

        if ($request->hasFile('logo')) {
           
            if ($identitas->logo && Storage::disk('public')->exists($identitas->logo)) {
                Storage::disk('public')->delete($identitas->logo);
            }
            $validatedData['logo'] = $request->file('logo')->store('logo-panti', 'public');
        }

        $identitas->update($validatedData);

        return back()->with('success', 'Identitas panti berhasil diperbarui!');
    }
}