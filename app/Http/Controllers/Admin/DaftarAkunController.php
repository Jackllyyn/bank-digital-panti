<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DaftarAkun;
use Illuminate\Http\Request;

class DaftarAkunController extends Controller
{
    public function index()
    {
        $tahun = date('Y'); // Tahun berjalan (2025 saat ini)

        $akuns = DaftarAkun::with(['saldoAwal' => function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        }])->orderBy('kode_akun')->get();

        return view('admin.daftar-akun.index', compact('akuns', 'tahun'));
    }

    public function create()
    {
        return view('admin.daftar-akun.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_akun' => 'required|unique:daftar_akun,kode_akun',
            'nama_akun' => 'required',
            'kelompok' => 'required|in:ASET,LIABILITAS,EKUITAS,PENDAPATAN,BEBAN',
            'posisi_saldo' => 'required|in:DEBET,KREDIT',
            'saldo_awal' => 'nullable|numeric',
        ]);

        DaftarAkun::create($request->all());

        return redirect()->route('admin.daftar-akun.index')
            ->with('success', 'Akun berhasil ditambahkan');
    }

    public function edit($kode_akun)
    {
        $akun = DaftarAkun::where('kode_akun', $kode_akun)->firstOrFail();
        return view('admin.daftar-akun.edit', compact('akun'));
    }

    public function update(Request $request, $kode_akun)
    {
        $request->validate([
            'kode_akun' => 'required|unique:daftar_akun,kode_akun,' . $kode_akun . ',kode_akun',
            'nama_akun' => 'required',
            'kelompok' => 'required|in:ASET,LIABILITAS,EKUITAS,PENDAPATAN,BEBAN',
            'posisi_saldo' => 'required|in:DEBET,KREDIT',
            'saldo_awal' => 'nullable|numeric',
        ]);

        DaftarAkun::where('kode_akun', $kode_akun)
            ->update($request->except('_token', '_method'));

        return redirect()->route('admin.daftar-akun.index')
            ->with('success', 'Akun berhasil diperbarui');
    }

    // Tambahkan destroy jika belum ada
    public function destroy($kode_akun)
    {
        DaftarAkun::where('kode_akun', $kode_akun)->delete();
        return back()->with('success', 'Akun berhasil dihapus');
    }
}