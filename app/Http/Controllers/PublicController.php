<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // <--- TAMBAHKAN INI
use App\Models\IdentitasPanti;
use App\Models\PenerimaanDonasi;
use App\Models\Pengeluaran;
use App\Models\AnakPanti;
use App\Models\Donatur;
use App\Models\Galeri;
use App\Models\Berita;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;

class PublicController extends Controller
{
    /**
     * Halaman Beranda
     */
    public function home()
    {
        $tahun = date('Y');
        
        // Identitas Panti
        $identitas = IdentitasPanti::first();
        
        // Total Donasi Bulan Ini
        $donasiBulanIni = PenerimaanDonasi::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', date('m'))
            ->sum('jumlah') ?? 0;
        
        // Total Pengeluaran Bulan Ini
        $pengeluaranBulanIni = Pengeluaran::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', date('m'))
            ->sum('jumlah') ?? 0;
        
        // Surplus/Defisit
        $surplusBulanIni = $donasiBulanIni - $pengeluaranBulanIni;
        
        // Data Anak Asuh
        $totalAnakAktif = AnakPanti::where('status', 'aktif')->count() ?? 0;
        $totalAnakLaki = AnakPanti::where('status', 'aktif')
            ->where('jenis_kelamin', 'L')
            ->count() ?? 0;
        $totalAnakPerempuan = AnakPanti::where('status', 'aktif')
            ->where('jenis_kelamin', 'P')
            ->count() ?? 0;
        
        // Total Donatur
        $totalDonatur = Donatur::count() ?? 0;
        
        // Aktivitas Terbaru (5 terakhir)
        $aktivitasTerbaru = Activity::with('causer')
            ->latest()
            ->take(5)
            ->get();
        
        // Grafik 6 Bulan Terakhir
        $grafik = $this->getGrafikData();
        
        // Total Donasi Tahun Ini
        $totalDonasiTahunIni = PenerimaanDonasi::whereYear('tanggal', $tahun)
            ->sum('jumlah') ?? 0;
        
        // Preview Pengurus (3 data)
        $pengurusPreview = collect();
        if (Schema::hasTable('pengurus')) { // <--- Perbaikan di sini
            $pengurusPreview = DB::table('pengurus')
                ->where('is_active', true)
                ->orderBy('urutan', 'asc')
                ->limit(3)
                ->get();
        }
        
        return view('public.home', compact(
            'identitas',
            'donasiBulanIni',
            'pengeluaranBulanIni',
            'surplusBulanIni',
            'totalAnakAktif',
            'totalAnakLaki',
            'totalAnakPerempuan',
            'totalDonatur',
            'aktivitasTerbaru',
            'grafik',
            'totalDonasiTahunIni',
            'pengurusPreview'
        ));
    }

/**
 * Halaman Tentang Kami
 */
public function about()
{
    $identitas = IdentitasPanti::first();

    // Statistik
    $totalAnakAsuh    = AnakPanti::count() ?? 0;
    $totalDonasi      = PenerimaanDonasi::sum('jumlah') ?? 0;
    $totalPengeluaran = Pengeluaran::sum('jumlah') ?? 0;
    $totalDonatur     = Donatur::count() ?? 0;

    // Data Pengurus (aktif, urut)
    $pengurus = collect();
    if (Schema::hasTable('pengurus')) {
        $pengurus = DB::table('pengurus')
            ->where('is_active', true)
            ->orderBy('urutan', 'asc')
            ->get();
    }

    // Laporan Keuangan (Transparansi)
    $laporanKeuangan = $this->getLaporanKeuangan();

    // Visi Misi
    $visi = 'Menjadi panti asuhan yang unggul dalam pengasuhan, pendidikan, dan pemberdayaan anak-anak yatim dan dhuafa.';
    $misi = [
        'Memberikan pengasuhan yang holistik kepada anak-anak asuh.',
        'Menyediakan akses pendidikan yang berkualitas.',
        'Mengembangkan kemandirian ekonomi melalui pelatihan keterampilan.',
        'Menjalin kemitraan dengan berbagai pihak untuk mendukung program.'
    ];

    $values = [
        (object) ['icon' => 'verified',   'title' => 'Amanah',    'description' => 'Menjalankan setiap amanah dengan penuh tanggung jawab'],
        (object) ['icon' => 'handshake',  'title' => 'Transparan', 'description' => 'Terbuka dalam pengelolaan dana dan program'],
        (object) ['icon' => 'favorite',   'title' => 'Peduli',     'description' => 'Memberikan kasih sayang tanpa batas kepada anak-anak asuh'],
        (object) ['icon' => 'lightbulb',  'title' => 'Inovatif',   'description' => 'Terus berinovasi dalam program pengasuhan dan pendidikan']
    ];

    return view('public.about', compact(
        'identitas',
        'totalAnakAsuh',
        'totalDonasi',
        'totalPengeluaran',
        'totalDonatur',
        'pengurus',
        'laporanKeuangan',
        'visi',
        'misi',
        'values'
    ));
}

    /**
     * Halaman Galeri
     */
    public function gallery(Request $request)
    {
        $perPage = 12;
        
        if (!Schema::hasTable('galeri')) { // <--- Perbaikan di sini
            $galleries = collect([]);
            $categories = collect([]);
            $identitas = IdentitasPanti::first();
            return view('public.gallery', compact('galleries', 'categories', 'identitas'));
        }
        
        $query = Galeri::where('is_published', true);
        
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }
        
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }
        
        $galleries = $query->orderBy('created_at', 'desc')->paginate($perPage);
        
        $categories = Galeri::select('kategori')
            ->distinct()
            ->where('is_published', true)
            ->whereNotNull('kategori')
            ->get()
            ->pluck('kategori');
        
        $identitas = IdentitasPanti::first();
        
        return view('public.gallery', compact('galleries', 'categories', 'identitas'));
    }

    /**
     * Detail Galeri
     */
    public function galleryDetail(string $slug) // <--- Tambahkan string
    {
        if (!Schema::hasTable('galeri')) { // <--- Perbaikan di sini
            abort(404);
        }
        
        $gallery = Galeri::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        
        $gallery->increment('views');
        
        $galleryTerkait = Galeri::where('is_published', true)
            ->where('id', '!=', $gallery->id)
            ->where('kategori', $gallery->kategori)
            ->limit(4)
            ->get();
        
        $identitas = IdentitasPanti::first();
        
        return view('public.gallery-detail', compact('gallery', 'galleryTerkait', 'identitas'));
    }

    /**
     * Halaman Berita
     */
    public function news(Request $request)
    {
        $perPage = 9;
        
        if (!Schema::hasTable('berita')) { // <--- Perbaikan di sini
            $berita = collect([]);
            $categories = collect([]);
            $beritaPopuler = collect([]);
            $identitas = IdentitasPanti::first();
            return view('public.news', compact('berita', 'categories', 'beritaPopuler', 'identitas'));
        }
        
        $query = Berita::where('is_published', true);
        
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }
        
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('konten', 'like', '%' . $request->search . '%');
            });
        }
        
        $berita = $query->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        
        $categories = Berita::select('kategori')
            ->distinct()
            ->where('is_published', true)
            ->whereNotNull('kategori')
            ->get()
            ->pluck('kategori');
        
        $beritaPopuler = Berita::where('is_published', true)
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();
        
        $identitas = IdentitasPanti::first();
        
        return view('public.news', compact('berita', 'categories', 'beritaPopuler', 'identitas'));
    }

    /**
     * Detail Berita
     */
    public function newsDetail(string $slug) // <--- Tambahkan string
    {
        if (!Schema::hasTable('berita')) { // <--- Perbaikan di sini
            abort(404);
        }
        
        $berita = Berita::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        
        $berita->increment('views');
        
        $beritaTerkait = Berita::where('is_published', true)
            ->where('id', '!=', $berita->id)
            ->where('kategori', $berita->kategori)
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();
        
        $identitas = IdentitasPanti::first();
        
        return view('public.news-detail', compact('berita', 'beritaTerkait', 'identitas'));
    }

    /**
     * Halaman Transparansi
     */
    public function transparansi()
    {
        $laporanBulanan = collect();
        
        for ($i = 11; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $tahun = $bulan->year;
            $bulanNumber = $bulan->month;
            
            $pemasukan = PenerimaanDonasi::whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulanNumber)
                ->sum('jumlah') ?? 0;
                
            $pengeluaran = Pengeluaran::whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulanNumber)
                ->sum('jumlah') ?? 0;
                
            $laporanBulanan->push((object) [
                'periode' => $bulan->format('F Y'),
                'bulan' => $bulan->format('F'),
                'tahun' => $tahun,
                'total_pemasukan' => $pemasukan,
                'total_pengeluaran' => $pengeluaran,
                'saldo_akhir' => $pemasukan - $pengeluaran
            ]);
        }
        
        $totalPemasukan = PenerimaanDonasi::sum('jumlah') ?? 0;
        $totalPengeluaran = Pengeluaran::sum('jumlah') ?? 0;
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;
        
        $identitas = IdentitasPanti::first();
        
        return view('public.transparansi', compact(
            'laporanBulanan',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
            'identitas'
        ));
    }

    /**
     * Halaman Kontak
     */
    public function contact()
    {
        $identitas = IdentitasPanti::first();
        return view('public.contact', compact('identitas'));
    }

    /**
     * Kirim Pesan Kontak
     */
    public function contactSend(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string'
        ]);
        
        Activity::create([
            'log_name' => 'contact',
            'description' => "Pesan kontak dari {$request->nama}",
            'properties' => [
                'nama' => $request->nama,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'subjek' => $request->subjek,
                'pesan' => $request->pesan
            ]
        ]);
        
        return redirect()->back()->with('success', 'Pesan Anda telah terkirim. Terima kasih!');
    }

    /**
     * Halaman Donasi
     */
    public function donation()
    {
        $identitas = IdentitasPanti::first();
        
        $categories = collect([
            (object) ['nama' => 'Zakat Fitrah', 'deskripsi' => 'Zakat fitrah untuk membersihkan diri'],
            (object) ['nama' => 'Zakat Mal', 'deskripsi' => 'Zakat harta untuk membantu sesama'],
            (object) ['nama' => 'Infak/Sedekah', 'deskripsi' => 'Infak dan sedekah untuk kebaikan'],
            (object) ['nama' => 'Wakaf', 'deskripsi' => 'Wakaf untuk keberkahan yang berkelanjutan'],
            (object) ['nama' => 'Lainnya', 'deskripsi' => 'Donasi untuk program lainnya']
        ]);
        
        $programs = $this->getPrograms();
        
        $totalDonasi = PenerimaanDonasi::sum('jumlah') ?? 0;
        $totalDonatur = Donatur::count() ?? 0;
        $totalAnakAktif = AnakPanti::where('status', 'aktif')->count() ?? 0;
        
        $donasiTerbaru = PenerimaanDonasi::with('donatur')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('public.donation', compact(
            'identitas',
            'categories',
            'programs',
            'totalDonasi',
            'totalDonatur',
            'totalAnakAktif',
            'donasiTerbaru'
        ));
    }

    /**
     * Proses Donasi
     */
    public function donationStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:20',
            'amount' => 'required|numeric|min:10000',
            'donation_type' => 'required|string',
            'program_id' => 'nullable|string',
            'pesan' => 'nullable|string',
            'metode_pembayaran' => 'required|string'
        ]);
        
        $donasi = PenerimaanDonasi::create([
            'tanggal' => now(),
            'kode_donatur' => null,
            'jenis' => strtolower($request->donation_type),
            'keterangan' => $request->pesan,
            'jumlah' => $request->amount,
            'kode_pendapatan' => '4003',
            'cara_bayar' => $request->metode_pembayaran,
            'user_id' => 1
        ]);
        
        return redirect()->route('donation.success')->with('success', 'Donasi berhasil disimpan!');
    }

    /**
     * Halaman Sukses Donasi
     */
    public function donationSuccess()
    {
        return view('public.donation-success');
    }

    /**
     * Halaman Aktivitas
     */
    public function activities()
    {
        $aktivitas = Activity::latest()->paginate(20);
        
        $totalDonasi = PenerimaanDonasi::sum('jumlah') ?? 0;
        $totalPengeluaran = Pengeluaran::sum('jumlah') ?? 0;
        $saldoAkhir = $totalDonasi - $totalPengeluaran;
        
        $identitas = IdentitasPanti::first();
        
        return view('public.activities', compact(
            'aktivitas',
            'totalDonasi',
            'totalPengeluaran',
            'saldoAkhir',
            'identitas'
        ));
    }

    /**
     * Halaman Program
     */
    public function programs(Request $request)
    {
        $perPage = 9;
        $page = $request->get('page', 1);
        
        $data = collect($this->getPrograms());
        
        $offset = ($page - 1) * $perPage;
        $items = $data->slice($offset, $perPage)->values();
        
        $programs = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $data->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        $identitas = IdentitasPanti::first();
        
        return view('public.programs', compact('programs', 'identitas'));
    }

    /**
     * Detail Program
     */
    public function programDetail(string $slug) // <--- Tambahkan string
    {
        $programs = $this->getProgramsAssoc();
        $program = $programs[$slug] ?? null;
        
        if (!$program) {
            abort(404);
        }
        
        $programTerkait = collect($programs)->filter(function($item, $key) use ($slug) {
            return $key !== $slug;
        })->take(3);
        
        $identitas = IdentitasPanti::first();
            
        return view('public.program-detail', compact('program', 'programTerkait', 'identitas'));
    }

    /**
     * Helper: Data Grafik 6 Bulan Terakhir
     */
    private function getGrafikData()
    {
        return collect(range(5, 0, -1))->map(function ($i) {
            $bulan = date('Y-m', strtotime("-$i month"));
            return [
                'bulan' => date('M Y', strtotime($bulan)),
                'donasi' => PenerimaanDonasi::whereYear('tanggal', substr($bulan, 0, 4))
                    ->whereMonth('tanggal', substr($bulan, 5, 2))
                    ->sum('jumlah'),
                'pengeluaran' => Pengeluaran::whereYear('tanggal', substr($bulan, 0, 4))
                    ->whereMonth('tanggal', substr($bulan, 5, 2))
                    ->sum('jumlah'),
            ];
        });
    }

    /**
     * Helper: Data Laporan Keuangan
     */
    private function getLaporanKeuangan()
    {
        $laporan = collect();
        
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $tahun = $bulan->year;
            $bulanNumber = $bulan->month;
            $namaBulan = $bulan->format('F');
            
            $pemasukan = PenerimaanDonasi::whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulanNumber)
                ->sum('jumlah') ?? 0;
                
            $pengeluaran = Pengeluaran::whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulanNumber)
                ->sum('jumlah') ?? 0;
            
            $laporan->push((object) [
                'judul' => "Laporan Keuangan {$namaBulan} {$tahun}",
                'periode' => "{$namaBulan} {$tahun}",
                'bulan' => $namaBulan,
                'tahun' => $tahun,
                'total_pemasukan' => $pemasukan,
                'total_pengeluaran' => $pengeluaran,
                'saldo_akhir' => $pemasukan - $pengeluaran,
                'is_published' => true
            ]);
        }
        
        return $laporan;
    }

    /**
     * Helper: Data Program
     */
    private function getPrograms()
    {
        return [
            (object) [
                'nama' => 'Pendidikan Berkualitas',
                'slug' => 'pendidikan-berkualitas',
                'deskripsi_singkat' => 'Menyediakan akses pendidikan formal dan non-formal untuk anak asuh.',
                'deskripsi_lengkap' => 'Program pendidikan yang mencakup biaya sekolah, seragam, buku, dan bimbingan belajar untuk anak-anak asuh.',
                'icon' => 'menu_book',
                'target_donasi' => 100000000,
                'terkumpul' => 75000000
            ],
            (object) [
                'nama' => 'Pengasuhan Holistik',
                'slug' => 'pengasuhan-holistik',
                'deskripsi_singkat' => 'Pengasuhan yang memperhatikan aspek fisik, mental, dan spiritual anak.',
                'deskripsi_lengkap' => 'Program pengasuhan yang mencakup kesehatan mental, konseling, dan pembinaan spiritual untuk anak-anak asuh.',
                'icon' => 'favorite',
                'target_donasi' => 50000000,
                'terkumpul' => 35000000
            ],
            (object) [
                'nama' => 'Kemandirian Ekonomi',
                'slug' => 'kemandirian-ekonomi',
                'deskripsi_singkat' => 'Melatih keterampilan untuk bekal hidup mandiri di masa depan.',
                'deskripsi_lengkap' => 'Program pelatihan keterampilan seperti menjahit, memasak, dan kerajinan tangan.',
                'icon' => 'handshake',
                'target_donasi' => 75000000,
                'terkumpul' => 45000000
            ],
            (object) [
                'nama' => 'Kesehatan & Gizi',
                'slug' => 'kesehatan-gizi',
                'deskripsi_singkat' => 'Menjamin kesehatan dan gizi anak-anak asuh.',
                'deskripsi_lengkap' => 'Program kesehatan yang mencakup pemeriksaan rutin, imunisasi, dan pemenuhan gizi seimbang.',
                'icon' => 'health_and_safety',
                'target_donasi' => 40000000,
                'terkumpul' => 25000000
            ],
            (object) [
                'nama' => 'Pembinaan Akhlak',
                'slug' => 'pembinaan-akhlak',
                'deskripsi_singkat' => 'Membentuk karakter dan akhlak mulia sesuai ajaran Islam.',
                'deskripsi_lengkap' => 'Program pembinaan akhlak melalui pengajian, tahfidz, dan kegiatan keagamaan lainnya.',
                'icon' => 'mosque',
                'target_donasi' => 30000000,
                'terkumpul' => 20000000
            ],
            (object) [
                'nama' => 'Kegiatan Sosial',
                'slug' => 'kegiatan-sosial',
                'deskripsi_singkat' => 'Mengajarkan kepedulian sosial melalui berbagai kegiatan.',
                'deskripsi_lengkap' => 'Program kegiatan sosial seperti bakti sosial, kunjungan ke panti lain, dan kegiatan kemasyarakatan.',
                'icon' => 'volunteer_activism',
                'target_donasi' => 25000000,
                'terkumpul' => 15000000
            ]
        ];
    }

    private function getProgramsAssoc()
    {
        $programs = $this->getPrograms();
        $result = [];
        foreach ($programs as $program) {
            $result[$program->slug] = $program;
        }
        return $result;
    }
}