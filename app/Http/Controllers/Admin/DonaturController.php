<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DonaturController extends Controller
{
    public function index(Request $request)
    {
        $query = Donatur::query();

        // Filter Jenis Donatur
        if ($request->filled('jenis_donatur')) {
            $query->where('jenis_donatur', 'like', '%' . $request->jenis_donatur . '%');
        }

        // Filter Klasifikasi
        if ($request->filled('klasifikasi')) {
            $query->where('klasifikasi', $request->klasifikasi);
        }

        // Search Nama / Kode / Kota
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_donatur', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('kota', 'like', "%{$search}%");
            });
        }

        // Eager load relasi untuk total_donasi (hindari N+1)
        $donaturs = $query->with('penerimaanDonasi')
            ->orderBy('kode_donatur')
            ->paginate(15);

        $donaturs->appends($request->all());

        return view('admin.donatur.index', compact('donaturs'));
    }

    public function create()
    {
        return view('admin.donatur.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_donatur'    => 'nullable|string|max:50',
            'nama'             => 'required|string|max:150',
            'alamat_lengkap'   => 'nullable|string',
            'kota'             => 'nullable|string|max:50',
            'telepon'          => 'nullable|string|max:20',
            'jenis_kelamin'    => 'nullable|in:L,P',
            'pekerjaan'        => 'nullable|string|max:100',
            'klasifikasi'      => 'nullable|in:tetap,tidak tetap',
            'tanggal_daftar'   => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        // Generate kode otomatis jika belum ada
        if (empty($data['kode_donatur'])) {
            $last = Donatur::orderBy('kode_donatur', 'desc')->first();
            $next = $last ? (int)substr($last->kode_donatur, 1) + 1 : 1;
            $data['kode_donatur'] = 'D' . str_pad($next, 3, '0', STR_PAD_LEFT);
        }

        Donatur::create($data);

        return redirect()->route('admin.donatur.index')
            ->with('success', 'Donatur berhasil ditambahkan (Kode: ' . $data['kode_donatur'] . ')');
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
            'jenis_donatur'    => 'nullable|string|max:50',
            'nama'             => 'required|string|max:150',
            'alamat_lengkap'   => 'nullable|string',
            'kota'             => 'nullable|string|max:50',
            'telepon'          => 'nullable|string|max:20',
            'jenis_kelamin'    => 'nullable|in:L,P',
            'pekerjaan'        => 'nullable|string|max:100',
            'klasifikasi'      => 'nullable|in:tetap,tidak tetap',
            'tanggal_daftar'   => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $donatur->update($request->all());

        return redirect()->route('admin.donatur.index')
            ->with('success', 'Donatur berhasil diperbarui.');
    }
    public function struk($kode_donatur)
    {
        $donatur = Donatur::findOrFail($kode_donatur);
        $identitas = \App\Models\IdentitasPanti::getData();

        return view('admin.donatur.struk', compact('donatur', 'identitas'));
    }

    public function destroy($kode_donatur)
    {
        $donatur = Donatur::findOrFail($kode_donatur);
        $donatur->delete();

        return redirect()->route('admin.donatur.index')
            ->with('success', 'Donatur berhasil dihapus (soft delete).');
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

        return redirect()->route('admin.donatur.trash')
            ->with('success', 'Donatur berhasil direstore.');
    }

    public function forceDelete($kode_donatur)
    {
        $donatur = Donatur::withTrashed()->findOrFail($kode_donatur);
        $donatur->forceDelete();

        return redirect()->route('admin.donatur.trash')
            ->with('success', 'Donatur berhasil dihapus permanen.');
    }

    public function forceDeleteAll(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|in:YA',
        ], [
            'confirmation.in' => 'Harap ketik "YA" untuk konfirmasi penghapusan permanen.',
        ]);

        // Hapus permanen semua data di trash
        Donatur::onlyTrashed()->forceDelete();

        return redirect()->route('admin.donatur.trash')
            ->with('success', 'Semua donatur di trash berhasil dihapus permanen!');
    }

    /**
     * Hapus semua data donatur (truncate) dengan aman meski ada foreign key
     */
    public function truncate(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|in:YA',
        ], [
            'confirmation.in' => 'Harap ketik "YA" untuk konfirmasi penghapusan permanen.',
        ]);

        // Nonaktifkan pengecekan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus semua data dari tabel donatur + reset auto increment
        Donatur::truncate();

        // Aktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('admin.donatur.index')
            ->with('success', 'Semua data donatur berhasil dihapus permanen!');
    }
}
