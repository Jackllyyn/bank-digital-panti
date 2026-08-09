<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DaftarAkun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DaftarAkunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahun = date('Y'); // Tahun berjalan (2025 saat ini)

        $akuns = DaftarAkun::with(['saldoAwal' => function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        }])->orderBy('kode_akun')->get();

        return view('admin.daftar-akun.index', compact('akuns', 'tahun'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.daftar-akun.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_akun'     => 'required|string|max:255',
            'kelompok'      => 'required|in:ASET,LIABILITAS,EKUITAS,PENDAPATAN,BEBAN',
            'posisi_saldo'  => 'required|in:DEBET,KREDIT',
            'saldo_awal'    => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Tentukan prefix berdasarkan kelompok
            $prefix = match (strtoupper($request->kelompok)) {
                'ASET'        => '1',
                'LIABILITAS'  => '2',
                'EKUITAS'     => '3',
                'PENDAPATAN'  => '4',
                'BEBAN'       => '5',
                default       => throw new \Exception('Kelompok akun tidak valid'),
            };

            // Cari akun terakhir di kelompok yang sama (berdasarkan prefix)
            $lastAkun = DaftarAkun::where('kode_akun', 'like', $prefix . '%')
                ->orderBy('kode_akun', 'desc')
                ->first();

            // Tentukan nomor berikutnya
            $nextNumber = 0;
            if ($lastAkun) {
                // Ambil 3 digit setelah prefix (contoh: 1405 → 405)
                $nextNumber = (int) substr($lastAkun->kode_akun, 1) + 1;
            }

            // Generate kode baru (format 4 digit: prefix + 3 digit)
            $kodeAkunBaru = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Cek duplikat (race condition prevention)
            $attempt = 0;
            while (DaftarAkun::where('kode_akun', $kodeAkunBaru)->exists()) {
                $attempt++;
                $nextNumber++;
                $kodeAkunBaru = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

                if ($attempt > 100) {
                    throw new \Exception('Gagal generate kode akun unik setelah 100 percobaan');
                }
            }

            // Buat akun baru
            $akun = DaftarAkun::create([
                'kode_akun'     => $kodeAkunBaru,
                'nama_akun'     => $request->nama_akun,
                'kelompok'      => $request->kelompok,
                'posisi_saldo'  => $request->posisi_saldo,
                'saldo_awal'    => $request->saldo_awal ?? 0,
                'tahun'         => date('Y'),
            ]);

            DB::commit();

            return redirect()->route('admin.daftar-akun.index')
                ->with('success', "Akun berhasil dibuat: {$akun->nama_akun} (Kode: {$akun->kode_akun})");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menambah akun: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kode_akun)
    {
        $akun = DaftarAkun::where('kode_akun', $kode_akun)->firstOrFail();
        return view('admin.daftar-akun.edit', compact('akun'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kode_akun)
    {
        $request->validate([
            'nama_akun'     => 'required|string|max:255',
            'posisi_saldo'  => 'required|in:DEBET,KREDIT',
            'saldo_awal'    => 'nullable|numeric|min:0',
        ]);

        try {
            $akun = DaftarAkun::where('kode_akun', $kode_akun)->firstOrFail();

            $akun->update([
                'nama_akun'     => $request->nama_akun,
                'posisi_saldo'  => $request->posisi_saldo,
                'saldo_awal'    => $request->saldo_awal ?? $akun->saldo_awal,
            ]);

            return redirect()->route('admin.daftar-akun.index')
                ->with('success', 'Akun berhasil diperbarui');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui akun: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kode_akun)
    {
        try {
            $akun = DaftarAkun::where('kode_akun', $kode_akun)->firstOrFail();
            $akun->delete();

            return redirect()->route('admin.daftar-akun.index')
                ->with('success', 'Akun berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus akun: ' . $e->getMessage());
        }
    }
}