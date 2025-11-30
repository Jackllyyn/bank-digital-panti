<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DonaturController extends Controller
{ 

    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Donatur::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_donatur', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('kota', 'like', "%{$search}%");
            });
        }

        $donaturs = $query->orderBy('kode_donatur')->paginate(15);

       
        $donaturs->appends(['search' => $search]);

        return view('admin.donatur.index', compact('donaturs'));
    }

    public function create()
    {
        return view('admin.donatur.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_donatur' => 'nullable|string|max:50',
            'nama' => 'required|string|max:150',
            'alamat_lengkap' => 'nullable|string',
            'kota' => 'nullable|string|max:50',
            'telepon' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:L,P',
            'pekerjaan' => 'nullable|string|max:100',
            'klasifikasi' => 'nullable|in:tetap,tidak tetap',
            'tanggal_daftar' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $existing = Donatur::whereRaw('LOWER(nama) = ?', [Str::lower($request->nama)])->first();
        if ($existing) {

            $existing->update($request->except('kode_donatur'));
            return redirect()->route('admin.donatur.index')->with('success', 'Donatur sudah ada, data diperbarui dengan kode existing: ' . $existing->kode_donatur);
        }


        $lastDonatur = Donatur::orderBy('kode_donatur', 'desc')->first();
        $nextNumber = $lastDonatur ? (int) substr($lastDonatur->kode_donatur, 1) + 1 : 1;
        $kode = 'D' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $data = $request->all();
        $data['kode_donatur'] = $kode;
        Donatur::create($data);

        return redirect()->route('admin.donatur.index')->with('success', 'Donatur berhasil ditambahkan dengan kode: ' . $kode);
    }

    public function edit($kode_donatur)
    {
        $donatur = Donatur::findOrFail($kode_donatur);
        return view('admin.donatur.edit', compact('donatur'));
    }

    public function update(Request $request, $kode_donatur)
    {
        $donatur = Donatur::findOrFail($kode_donatur);

        $validator = Validator::make($request->all(), [
            'jenis_donatur' => 'nullable|string|max:50',
            'nama' => 'required|string|max:150',
            'alamat_lengkap' => 'nullable|string',
            'kota' => 'nullable|string|max:50',
            'telepon' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|in:L,P',
            'pekerjaan' => 'nullable|string|max:100',
            'klasifikasi' => 'nullable|in:tetap,tidak tetap',
            'tanggal_daftar' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $donatur->update($request->all());

        return redirect()->route('admin.donatur.index')->with('success', 'Donatur berhasil diperbarui.');
    }

    public function destroy($kode_donatur)
    {
        $donatur = Donatur::findOrFail($kode_donatur);
        $donatur->delete();

        return redirect()->route('admin.donatur.index')->with('success', 'Donatur berhasil dihapus (soft delete).');
    }

    public function trash()
    {
        $donaturs = Donatur::onlyTrashed()->orderBy('kode_donatur')->paginate(10);
        return view('admin.donatur.trash', compact('donaturs'));
    }

    public function restore($kode_donatur)
    {
        $donatur = Donatur::withTrashed()->findOrFail($kode_donatur);
        $donatur->restore();

        return redirect()->route('admin.donatur.trash')->with('success', 'Donatur berhasil direstore.');
    }

    public function forceDelete($kode_donatur)
    {
        $donatur = Donatur::withTrashed()->findOrFail($kode_donatur);
        $donatur->forceDelete();

        return redirect()->route('admin.donatur.trash')->with('success', 'Donatur berhasil dihapus permanen.');
    }
}
