<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KasKecil;
use App\Models\JurnalUmum;
use App\Models\DaftarAkun;
use App\Models\SaldoAwal;
use App\Models\IdentitasPanti;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class KasKecilController extends Controller
{
    /**
     * pencarian dan filter data Kas Kecil
     */
    public function index(Request $request)
    {
        $query = KasKecil::with(['akunDebet', 'akunKredit', 'user'])->latest();

        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }
        if ($request->filled('akun')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_akund', $request->akun)
                  ->orWhere('kode_akunk', $request->akun);
            });
        }

        $kas_kecils = $query->paginate(15)->withQueryString();
        $akuns = DaftarAkun::orderBy('kode_akun')->get();

        return view('admin.kas-kecil.index', compact('kas_kecils', 'akuns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $akuns = DaftarAkun::orderBy('kode_akun')->get();
        
        // Filter akun untuk Sumber Dana (Kas/Bank)
        $sumberDana = $akuns->filter(function ($akun) {
            return stripos($akun->nama_akun, 'Kas') !== false || stripos($akun->nama_akun, 'Bank') !== false;
        });

        return view('admin.kas-kecil.create', compact('akuns', 'sumberDana'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'           => 'required|date',
            'keterangan'        => 'required|string',
            'nama_akund'        => 'required|exists:daftar_akun,kode_akun',
            'nama_akunk'        => 'required|exists:daftar_akun,kode_akun|different:nama_akund',
            'jumlah'            => 'required|numeric|min:1',
            'no_transaksi'      => 'nullable|string|max:50',
            'no_bukti'          => 'nullable|string|max:50',

        ]);

        // Validasi Saldo Mencukupi
        $saldoTersedia = $this->hitungSaldo($request->nama_akunk, date('Y', strtotime($request->tanggal)));
        if ($request->jumlah > $saldoTersedia) {
            return back()->withInput()->withErrors(['jumlah' => 'Saldo tidak mencukupi! Saldo saat ini: Rp ' . number_format($saldoTersedia, 0, ',', '.')]);
        }

        try {
            DB::transaction(function () use ($request) {
                // Generate No Transaksi: BKK-YYYYMM-XXXX
                $prefix = 'BKK-' . date('Ym', strtotime($request->tanggal)) . '-';
                $lastRecord = KasKecil::where('no_transaksi', 'like', $prefix . '%')
                    ->orderBy('no_transaksi', 'desc')
                    ->lockForUpdate() // Mencegah duplikasi nomor saat input bersamaan
                    ->first();

                $nextNumber = $lastRecord ? (int) substr($lastRecord->no_transaksi, -4) + 1 : 1;
                $no_transaksi = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

                // Create Kas Kecil record
                KasKecil::create([
                    'no_transaksi'      => $no_transaksi,
                    'tanggal'           => $request->tanggal,
                    'keterangan'        => $request->keterangan,
                    'kode_akund'        => $request->nama_akund,
                    'kode_akunk'        => $request->nama_akunk,
                    'jumlah'            => $request->jumlah,
                    'no_bukti'          => $request->no_bukti,
                    'user_id'           => auth()->id(),
                ]);

                JurnalUmum::create([
                    'tanggal'          => $request->tanggal,
                    'no_transaksi'     => $no_transaksi,
                    'uraian'           => 'Kas Kecil: ' . $request->keterangan,
                    'kode_akun_debet'  => $request->nama_akund,
                    'kode_akun_kredit' => $request->nama_akunk,
                    'jumlah'           => $request->jumlah,
                    'no_bukti'         => $request->no_bukti,
                    'user_id'          => auth()->id(),
                ]);
            });

            return redirect()->route('admin.kas-kecil.index')
                ->with('success', 'Transaksi Kas Kecil berhasil Masuk!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage()]);
        }
    } 

    public function edit($id)
    {
        $kasKecil = KasKecil::findOrFail($id);
        $akuns = DaftarAkun::orderBy('kode_akun')->get();
        return view('admin.kas-kecil.edit', compact('kasKecil', 'akuns'));
    }

    public function update(Request $request, $id)
    {
        $kasKecil = KasKecil::findOrFail($id);
        $request->validate([
            'tanggal'           => 'required|date',
            'keterangan'        => 'required|string',
            'nama_akund'        => 'required|exists:daftar_akun,kode_akun',
            'nama_akunk'        => 'required|exists:daftar_akun,kode_akun|different:nama_akund',
            'jumlah'            => 'required|numeric|min:1',
            'no_transaksi'      => 'nullable|string|max:50',

        ]);

        // Validasi Saldo Mencukupi (Update)
        $tahun = date('Y', strtotime($request->tanggal));
        $saldoTersedia = $this->hitungSaldo($request->nama_akunk, $tahun);
        
        // Jika akun dan tahun sama, kembalikan saldo lama ke perhitungan (karena sedang diedit)
        if ($kasKecil->kode_akunk == $request->nama_akunk && date('Y', strtotime($kasKecil->tanggal)) == $tahun) {
            $saldoTersedia += $kasKecil->jumlah;
        }

        if ($request->jumlah > $saldoTersedia) {
            return back()->withInput()->withErrors(['jumlah' => 'Saldo tidak mencukupi! Saldo saat ini: Rp ' . number_format($saldoTersedia, 0, ',', '.')]);
        }

        try {
            DB::transaction(function () use ($request, $kasKecil) {
                $kasKecil->update([
                    'tanggal'      => $request->tanggal,
                    'keterangan'   => $request->keterangan,
                    'kode_akund'   => $request->nama_akund,
                    'kode_akunk'   => $request->nama_akunk,
                    'jumlah'       => $request->jumlah,
                    'no_bukti'     => $request->no_bukti,
                ]);

                JurnalUmum::where('no_transaksi', $kasKecil->no_transaksi)->update([
                    'tanggal'          => $request->tanggal,
                    'uraian'           => 'Kas Kecil: ' . $request->keterangan,
                    'kode_akun_debet'  => $request->nama_akund,
                    'kode_akun_kredit' => $request->nama_akunk,
                    'jumlah'           => $request->jumlah,
                    'no_bukti'         => $request->no_bukti,
                ]);
            });

            return redirect()->route('admin.kas-kecil.index')->with('success', 'Transaksi Kas Kecil berhasil diperbarui!');
        
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Terjadi kesalahan saat memperbarui transaksi: ' . $e->getMessage())->withInput();
        }
        
    }

    public function destroy($id)
    {
        $kasKecil = KasKecil::findOrFail($id);
        
        try {
            DB::transaction(function () use ($kasKecil) {
                JurnalUmum::where('no_transaksi', $kasKecil->no_transaksi)->delete();
                $kasKecil->delete();
            });

            return redirect()->route('admin.kas-kecil.index')
                ->with('success', 'Transaksi Kas Kecil berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.kas-kecil.index')
                ->withErrors('Terjadi kesalahan saat menghapus transaksi: ' . $e->getMessage());
        }
    }

// cetak struk kas kecil
public function struk($id)
{
    // Mengambil data dengan relasi agar nama akun muncul di preview
    $data = KasKecil::with(['akunDebet', 'akunKredit', 'user'])->findOrFail($id);
    $identitas = IdentitasPanti::first();
    
    // Fungsi terbilang untuk profesionalitas bukti transaksi
    $terbilang = $this->terbilang($data->jumlah) . " RUPIAH";

        $pdf = Pdf::loadView('admin.kas-kecil.print', compact('data', 'identitas', 'terbilang'))
              ->setPaper('a4', 'portrait');

    // Menggunakan stream() alih-alih download() untuk memunculkan Preview
    return $pdf->stream('Bukti_Kas_Kecil_' . $data->no_transaksi . '.pdf');
}

    private function hitungSaldo($kodeAkun, $tahun)
    {
        $akun = DaftarAkun::where('kode_akun', $kodeAkun)->first();
        
        // Validasi saldo hanya wajib untuk akun ASET (Kas/Bank)
        if (!$akun || $akun->kelompok !== 'ASET') {
            return PHP_FLOAT_MAX; 
        }

        $saldoAwal = SaldoAwal::where('kode_akun', $kodeAkun)
            ->where('tahun', $tahun)
            ->value('saldo') ?? 0;

        $debit = JurnalUmum::where('kode_akun_debet', $kodeAkun)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        $kredit = JurnalUmum::where('kode_akun_kredit', $kodeAkun)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        return $saldoAwal + $debit - $kredit;
    }

private function terbilang($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) { $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) { $temp = $this->terbilang($nilai - 10). " belas";
    } else if ($nilai <100) { $temp = $this->terbilang($nilai/10)." puluh". $this->terbilang($nilai % 10);
    } else if ($nilai <200) { $temp = " seratus" . $this->terbilang($nilai - 100);
    } else if ($nilai <1000) { $temp = $this->terbilang($nilai/100) . " ratus" . $this->terbilang($nilai % 100);
    } else if ($nilai <2000) { $temp = " seribu" . $this->terbilang($nilai - 1000);
    } else if ($nilai <1000000) { $temp = $this->terbilang($nilai/1000) . " ribu" . $this->terbilang($nilai % 1000);
    } else if ($nilai <1000000000) { $temp = $this->terbilang($nilai/1000000) . " juta" . $this->terbilang($nilai % 1000000);
    }
    return strtoupper($temp);
    }

    public function exportExcel(Request $request)
    {
        $query = KasKecil::with(['akunDebet', 'akunKredit', 'user'])->latest();

        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }
        if ($request->filled('akun')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_akund', $request->akun)
                  ->orWhere('kode_akunk', $request->akun);
            });
        }

        $data = $query->get();

        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\ShouldAutoSize, \Maatwebsite\Excel\Concerns\WithMapping, \Maatwebsite\Excel\Concerns\WithStyles, \Maatwebsite\Excel\Concerns\WithColumnFormatting {
            protected $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function collection()
            {
                return $this->data;
            }

            public function headings(): array
            {
                return ['No Transaksi', 'Tanggal', 'Keterangan', 'Akun Debet', 'Akun Kredit', 'Jumlah', 'No Bukti', 'Dibuat Oleh'];
            }

            public function map($row): array
            {
                return [
                    $row->no_transaksi,
                    \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y'),
                    $row->keterangan,
                    $row->akunDebet->nama_akun ?? '-',
                    $row->akunKredit->nama_akun ?? '-',
                    $row->jumlah,
                    $row->no_bukti,
                    $row->user->name ?? '-',
                ];
            }

            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet) { return [1 => ['font' => ['bold' => true]]]; }
            public function columnFormats(): array { return ['F' => '#,##0']; }
        }, 'Laporan_Kas_Kecil_' . date('Y-m-d_His') . '.xlsx');
    }
}