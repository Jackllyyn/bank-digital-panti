<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KasBesar;
use App\Models\JurnalUmum;
use App\Models\DaftarAkun;
use App\Models\IdentitasPanti;
use App\Models\SaldoAwal;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KasBesarController extends Controller
{
    /**
     * pencarian dan filter data Kas Besar
     */
    public function index(Request $request)
    {
        $query = KasBesar::with(['akunDebet', 'akunKredit', 'user'])->latest();

        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }
        if ($request->filled('akun')) {
            $query->where('kode_akun', $request->akun);
        }
        if ($request->filled('keterangan')) {
            $query->where('keterangan', 'like', '%' . $request->keterangan . '%');
        }

        $kas_besars = $query->paginate(15)->withQueryString();
        $akuns = DaftarAkun::orderBy('kode_akun')->get();

        return view('admin.kas-besar.index', compact('kas_besars', 'akuns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $akuns = DaftarAkun::orderBy('kode_akun')->get();

        return view('admin.kas-besar.create', compact('akuns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'           => 'required|date',
            'keterangan'        => 'required|string',
            'nama_akund'        => 'required|exists:daftar_akun,kode_akun|different:nama_akunk',
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

        DB::transaction(function () use ($request) {
            // Generate No Transaksi: BKB-YYYYMM-XXXX
            $prefix = 'BKB-' . date('Ym', strtotime($request->tanggal)) . '-';
            $lastRecord = KasBesar::where('no_transaksi', 'like', $prefix . '%')->count();
            $no_transaksi = $prefix . str_pad($lastRecord + 1, 4, '0', STR_PAD_LEFT);

            // Create Kas Besar record
            $kas_besars = KasBesar::create([
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
                'uraian'           => 'Kas Besar: ' . $request->keterangan,
                'kode_akun_debet'  => $request->nama_akund,
                'kode_akun_kredit' => $request->nama_akunk,
                'jumlah'           => $request->jumlah,
                'user_id'          => auth()->id(),
            ]);
        });

        return redirect()->route('admin.kas-besar.index')
            ->with('success', 'Transaksi Kas Besar berhasil Masuk!');
    } 

    public function edit($id)
    {
        $kasBesar = KasBesar::findOrFail($id);
        $akuns = DaftarAkun::orderBy('kode_akun')->get();
        return view('admin.kas-besar.edit', compact('kasBesar', 'akuns'));
    }


    public function update(Request $request, $id)
    {
        $kasBesar = KasBesar::findOrFail($id);
        $request->validate([
            'tanggal'           => 'required|date',
            'keterangan'        => 'required|string',
            'nama_akund'        => 'required|exists:daftar_akun,kode_akun|different:nama_akunk',
            'nama_akunk'        => 'required|exists:daftar_akun,kode_akun|different:nama_akund',
            'jumlah'            => 'required|numeric|min:1',
            'no_transaksi'      => 'nullable|string|max:50',
            'no_bukti'          => 'nullable|string|max:50',
        ]);

        // Validasi Saldo Mencukupi (Update)
        $tahun = date('Y', strtotime($request->tanggal));
        $saldoTersedia = $this->hitungSaldo($request->nama_akunk, $tahun);
        
        // Jika akun dan tahun sama, kembalikan saldo lama ke perhitungan (karena sedang diedit)
        if ($kasBesar->kode_akunk == $request->nama_akunk && date('Y', strtotime($kasBesar->tanggal)) == $tahun) {
            $saldoTersedia += $kasBesar->jumlah;
        }

        if ($request->jumlah > $saldoTersedia) {
            return back()->withInput()->withErrors(['jumlah' => 'Saldo tidak mencukupi! Saldo saat ini: Rp ' . number_format($saldoTersedia, 0, ',', '.')]);
        }

        try {
            DB::transaction(function () use ($request, $kasBesar) {
                $kasBesar->update([
                    'tanggal'      => $request->tanggal,
                    'keterangan'   => $request->keterangan,
                    'kode_akund'   => $request->nama_akund,
                    'kode_akunk'   => $request->nama_akunk,
                    'jumlah'       => $request->jumlah,
                    'no_bukti'     => $request->no_bukti,
                ]);

                JurnalUmum::where('no_transaksi', $kasBesar->no_transaksi)->update([
                    'tanggal'          => $request->tanggal,
                    'uraian'           => 'Kas Besar: ' . $request->keterangan,
                    'kode_akun_debet'  => $request->nama_akund,
                    'kode_akun_kredit' => $request->nama_akunk,
                    'jumlah'           => $request->jumlah,
                    'no_bukti'         => $request->no_bukti,
                ]);
            });

            return redirect()->route('admin.kas-besar.index')->with('success', 'Transaksi Kas Besar berhasil diperbarui!');
        
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Terjadi kesalahan saat memperbarui transaksi: ' . $e->getMessage())->withInput();
        }
        
    }

    public function destroy($id)
    {
        $kasBesar = KasBesar::findOrFail($id);
        try {
        DB::transaction(function () use ($kasBesar) {
            JurnalUmum::where('no_transaksi', $kasBesar->no_transaksi)->delete();
            $kasBesar->delete();
        });

        return redirect()->route('admin.kas-besar.index')
            ->with('success', 'Transaksi Kas Besar berhasil dihapus!');
    } catch (\Exception $e) {
        return redirect()->route('admin.kas-besar.index')
            ->withErrors('Terjadi kesalahan saat menghapus transaksi: ' . $e->getMessage());
    }
    }


public function struk($id)
{
    // Mengambil data dengan relasi agar nama akun muncul di preview
    $data = KasBesar::with(['akunDebet', 'akunKredit', 'user'])->findOrFail($id);
    $identitas = IdentitasPanti::first();
    
    // Fungsi terbilang untuk profesionalitas bukti transaksi
    $terbilang = $this->terbilang($data->jumlah) . " RUPIAH";

    $pdf = Pdf::loadView('admin.kas-besar.print', compact('data', 'identitas', 'terbilang'))
              ->setPaper('a4', 'portrait');

    // Menggunakan stream() alih-alih download() untuk memunculkan Preview
    return $pdf->stream('Bukti_Kas_Besar_' . $data->no_transaksi . '.pdf');
}

    public function exportExcel(Request $request)
    {
        $query = KasBesar::with(['akunDebet', 'akunKredit', 'user'])->latest();

        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }
        if ($request->filled('akun')) {
            $query->where('kode_akun', $request->akun);
        }
        if ($request->filled('keterangan')) {
            $query->where('keterangan', 'like', '%' . $request->keterangan . '%');
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
                    $row->tanggal->format('d/m/Y'),
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
        }, 'Laporan_Kas_Besar_' . date('Y-m-d_His') . '.xlsx');
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

    private function terbilang($nilai)
    {
        $nilai = abs((int) $nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
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
        return strtoupper($temp);
    }
}