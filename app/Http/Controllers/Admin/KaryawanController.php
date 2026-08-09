<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\IdentitasPanti;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('jenis_karyawan')) {
            $query->where('jenis_karyawan', 'like', '%' . $request->jenis_karyawan . '%');
        }

        $karyawans = $query->orderBy('nama')->paginate(20)->withQueryString();

        // Data untuk dropdown bulan dan tahun
        $months = collect(range(1, 12))->mapWithKeys(function ($month) {
            return [$month => \Carbon\Carbon::create()->month($month)->translatedFormat('F')];
        });
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 5);

        return view('admin.karyawan.index', compact('karyawans', 'months', 'years'));
    }

    public function create()
    {
        return view('admin.karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:100',
            'jenis_karyawan'  => 'nullable|in:tetap,tidak tetap,lainnya',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'alamat_lengkap' => 'nullable|string',
            'kota'           => 'nullable|string|max:50',
            'telepon'        => 'nullable|string|max:20',
            'jabatan'        => 'nullable|string|max:50',
            'tanggal_daftar' => 'required|date',
            'gaji_pokok'     => 'nullable|numeric|min:0',
            'tunjangan'      => 'nullable|numeric|min:0',
            'potongan_gaji'  => 'nullable|numeric|min:0',
        ]);

        $last = Karyawan::orderBy('nip', 'desc')->first();
        if ($last) {
            $lastNumber = (int) substr($last->nip, 3);
            $next = $lastNumber + 1;
        } else {
            $next = 1;
        }
        $kode = 'KRY' . str_pad($next, 4, '0', STR_PAD_LEFT);

        $data = $request->all();
        $data['nip'] = $kode;

        Karyawan::create($data);

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan dengan kode ' . $kode);
    }

    public function edit($nip)
    {
        $karyawan = Karyawan::where('nip', $nip)->firstOrFail();
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, $nip)
    {
        $karyawan = Karyawan::where('nip', $nip)->firstOrFail();
        
        $request->validate([
            'nama'           => 'required|string|max:100',
            'jenis_karyawan'  => 'nullable|in:tetap,tidak tetap,lainnya',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'alamat_lengkap' => 'nullable|string',
            'kota'           => 'nullable|string|max:50',
            'telepon'        => 'nullable|string|max:20',
            'jabatan'        => 'nullable|string|max:50',
            'tanggal_daftar' => 'required|date',
            'gaji_pokok'     => 'nullable|numeric|min:0',
            'tunjangan'      => 'nullable|numeric|min:0',
            'potongan_gaji'  => 'nullable|numeric|min:0',
        ]);

        $karyawan->update($request->all());

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui');
    }

    public function destroy($nip)
    {
        $karyawan = Karyawan::where('nip', $nip)->firstOrFail();
        $karyawan->delete();

        return redirect()->route('admin.karyawan.index')->with('success', 'Data berhasil dihapus');
    }

    public function trash()
    {
        $karyawans = Karyawan::onlyTrashed()->orderBy('nip')->paginate(15);
        return view('admin.karyawan.trash', compact('karyawans'));
    }

    public function restore($nip)
    {
        $karyawan = Karyawan::onlyTrashed()->where('nip', $nip)->firstOrFail();
        $karyawan->restore();

        return back()->with('success', 'Karyawan berhasil dipulihkan');
    }

    public function forceDelete($nip)
    {
        $karyawan = Karyawan::onlyTrashed()->where('nip', $nip)->firstOrFail();
        $karyawan->forceDelete();

        return back()->with('success', 'Karyawan berhasil dihapus permanen');
    }

    public function forceDeleteAll(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|in:YA'
        ], [
            'confirmation.in' => 'Harap ketik "YA" untuk konfirmasi penghapusan permanen.'
        ]);

        Karyawan::onlyTrashed()->forceDelete();
        return back()->with('success', 'Semua karyawan di sampah berhasil dihapus permanen');
    }

    public function exportExcel(Request $request)
    {
        return back()->with('error', 'Fitur Export Excel belum tersedia.');
    }

    public function template()
    {
        return back()->with('error', 'Fitur Template belum tersedia.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);
        return back()->with('error', 'Fitur Import belum tersedia.');
    }

    public function truncate(Request $request)
    {
        $request->validate(['confirmation' => 'required|in:YA']);
        Karyawan::truncate();
        return redirect()->route('admin.karyawan.index')->with('success', 'Semua data karyawan berhasil dihapus permanen');
    }

    public function slip(Request $request, $nip)
    {
        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2000',
        ]);

        $karyawan = Karyawan::findOrFail($nip);
        $identitas = IdentitasPanti::first();

        $periode = \Carbon\Carbon::create()->year($request->tahun)->month($request->bulan)->translatedFormat('F Y');
        $terbilang = $this->terbilang($karyawan->gaji_bersih) . ' RUPIAH';

        $pdf = Pdf::loadView('admin.karyawan.slip', compact('karyawan', 'identitas', 'periode', 'terbilang'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('slip-gaji-' . $karyawan->nip . '-' . $request->bulan . '-' . $request->tahun . '.pdf');
    }

    private function terbilang($nilai)
    {
        $nilai = abs((int) $nilai);
        $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->terbilang($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->terbilang($nilai / 10) . " puluh" . $this->terbilang($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->terbilang($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->terbilang($nilai / 100) . " ratus" . $this->terbilang($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->terbilang($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->terbilang($nilai / 1000) . " ribu" . $this->terbilang($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->terbilang($nilai / 1000000) . " juta" . $this->terbilang($nilai % 1000000);
        }
        return trim(strtoupper($temp));
    }
}
