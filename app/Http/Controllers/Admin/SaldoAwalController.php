<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SaldoAwal;
use App\Models\DaftarAkun;
use App\Models\IdentitasPanti;
use App\Exports\SaldoAwalExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SaldoAwalController extends Controller
{
    public function index()
    {
        $tahun = date('Y');

        $akuns = DaftarAkun::orderBy('kode_akun')->get();

        $saldoAwal = SaldoAwal::where('tahun', $tahun)
            ->pluck('saldo', 'kode_akun')
            ->toArray();

        // Data untuk JavaScript (kelompokkan akun)
        $akunGrouped = $akuns->groupBy('kelompok')->map(function ($group) use ($saldoAwal) {
            return $group->mapWithKeys(function ($akun) use ($saldoAwal) {
                return [$akun->kode_akun => [
                    'kode'   => $akun->kode_akun,
                    'nama'   => $akun->nama_akun,
                    'posisi' => $akun->posisi_saldo,
                    'saldo'  => $saldoAwal[$akun->kode_akun] ?? 0
                ]];
            })->toArray();
        })->toArray();

        return view('admin.saldo-awal.index', compact('tahun', 'akunGrouped'));
    }

    public function store(Request $request)
    {
        $tahun = date('Y');

        $request->validate([
            'saldo' => 'required|array',
            'saldo.*' => 'nullable|numeric|min:0',
        ]);

        foreach ($request->saldo as $kode_akun => $saldo) {
            $saldo = $saldo ?: 0;

            SaldoAwal::updateOrCreate(
                ['kode_akun' => $kode_akun, 'tahun' => $tahun],
                ['saldo' => $saldo]
            );
        }

        return back()->with('success', "Saldo awal tahun $tahun berhasil disimpan!");
    }

    // EXPORT EXCEL - SEMUA KELOMPOK
    public function exportAll()
    {
        return Excel::download(
            new SaldoAwalExport(null),
            'Saldo_Awal_Tahun_' . date('Y') . '_Semua_Kelompok.xlsx'
        );
    }

    // EXPORT EXCEL - PER KELOMPOK
    public function exportKelompok(Request $request)
    {
        $request->validate(['kelompok' => 'required|in:ASET,LIABILITAS,EKUITAS,PENDAPATAN,BEBAN']);
        $kelompok = $request->kelompok;

        return Excel::download(
            new SaldoAwalExport($kelompok),
            'Saldo_Awal_Tahun_' . date('Y') . '_' . $kelompok . '.xlsx'
        );
    }

    // EXPORT PDF - DENGAN KOP SURAT DINAMIS DARI IDENTITAS PANTI + LOGO
    public function exportPdf()
    {
        $tahun     = date('Y');
        $identitas = IdentitasPanti::getData(); // PASTIKAN INI ADA!

        $akuns = DaftarAkun::with(['saldoAwal' => fn($q) => $q->where('tahun', $tahun)])
            ->orderBy('kode_akun')->get();

        $pdf = Pdf::loadView('admin.saldo-awal.pdf', [
            'tahun'     => $tahun,
            'tanggal'   => now()->translatedFormat('d F Y'),
            'identitas' => $identitas,
            'akuns'     => $akuns,
        ])
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'defaultFont' => 'Arial'
            ]);

        return $pdf->stream('Neraca_Saldo_Awal_' . $tahun . '.pdf');
    }
}
