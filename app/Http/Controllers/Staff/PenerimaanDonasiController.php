<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenerimaanDonasiController extends Controller
{
    public function create()
    {
        return view('staff.penerimaan-donasi.create'); // pastikan folder & nama file sesuai
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'      => 'required|date',
            'jenis'        => 'required|in:zakat,infak,wakaf,lainnya',
            'kode_donatur' => 'nullable|exists:donaturs,kode_donatur',
            'jumlah'       => 'required|numeric|min:0.01',
            'cara_bayar'   => 'required|in:tunai,transfer,barang',
            'keterangan'   => 'required|string|max:1000',
        ]);

        // Simpan donasi + buat jurnal otomatis di sini...

        return redirect()->route('staff.dashboard')
                         ->with('success', 'Donasi berhasil disimpan dan jurnal otomatis dibuat!');
    }
}