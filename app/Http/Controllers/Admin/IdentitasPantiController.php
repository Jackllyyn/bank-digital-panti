<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IdentitasPanti;
use Illuminate\Http\Request;

class IdentitasPantiController extends Controller
{
    public function edit()
    {
        $identitas = IdentitasPanti::firstOrCreate([]); 
        return view('admin.identitas-panti.edit', compact('identitas'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_yayasan'  => 'required|string|max:255',
            'nama_panti'    => 'required|string|max:255',
            'alamat'        => 'nullable|string',
            'telepon'       => 'nullable|string|max:20',
            'email'         => 'nullable|email',
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        $identitas = IdentitasPanti::firstOrCreate([]);
        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
           
            if ($identitas->logo && \Storage::disk('public')->exists($identitas->logo)) {
                \Storage::disk('public')->delete($identitas->logo);
            }
            $data['logo'] = $request->file('logo')->store('logo-panti', 'public');
        }

        $identitas->update($data);

        return back()->with('success', 'Identitas panti berhasil diperbarui!');
    }
}