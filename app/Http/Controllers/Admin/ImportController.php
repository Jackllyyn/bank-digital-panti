<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use App\Models\AnakPanti;
use App\Models\Inventaris;
use App\Models\AsetTetap;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DonaturImport;
use App\Imports\AnakPantiImport;
use App\Imports\InventarisImport;
use App\Imports\AsetTetapImport;

class ImportController extends Controller
{
    public function index()
    {
        return view('admin.import.index');
    }

    public function donatur(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);

        try {
            Excel::import(new DonaturImport, $request->file('file'));
            return redirect()->route('admin.import.index')
                ->with('success', 'Data Donatur berhasil diimport!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function anakPanti(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);

        try {
            Excel::import(new AnakPantiImport, $request->file('file'));
            return redirect()->route('admin.import.index')
                ->with('success', 'Data Anak Panti berhasil diimport!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function inventaris(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);

        try {
            Excel::import(new InventarisImport, $request->file('file'));
            return redirect()->route('admin.import.index')
                ->with('success', 'Data Inventaris berhasil diimport!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function asetTetap(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);

        try {
            Excel::import(new AsetTetapImport, $request->file('file'));
            return redirect()->route('admin.import.index')
                ->with('success', 'Data Aset Tetap berhasil diimport!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }


    public function downloadTemplate($type)
{
    $fileName = '';
    $headings = [];
    $exampleData = [];

    switch ($type) {
        case 'donatur':
            $fileName = 'Template_Donatur.xlsx';
            $headings = [
                'kode_donatur', 'jenis_donatur', 'nama', 'alamat_lengkap', 'kota',
                'telepon', 'jenis_kelamin', 'pekerjaan', 'klasifikasi', 'tanggal_daftar'
            ];
            $exampleData = [
                ['D001', 'Perorangan', 'Budi Santoso', 'Jl. Sudirman No.10', 'Jakarta', '08123456789', 'L', 'PNS', 'tetap', '2025-01-01']
            ];
            break;

        case 'anak-panti':
            $fileName = 'Template_Anak_Panti.xlsx';
            $headings = [
                'niap', 'nama', 'jenis_kelamin', 'kota', 'tempat_lahir',
                'tanggal_lahir', 'tanggal_masuk', 'status', 'nama_ayah',
                'nama_ibu', 'tingkat_pendidikan', 'nama_sekolah'
            ];
            $exampleData = [
                ['A001', 'Ahmad Zaki', 'L', 'Bandung', 'Bandung', '2015-05-20', '2024-06-01', 'aktif', 'Budi', 'Siti', 'SD', 'SD Negeri 1']
            ];
            break;

        case 'inventaris':
            $fileName = 'Template_Inventaris.xlsx';
            $headings = ['kode_barang', 'nama_barang', 'satuan', 'stok', 'harga_rata2', 'keterangan'];
            $exampleData = [
                ['INV-001', 'Buku Tulis', 'Pcs', '100', '5000', 'Stok awal 2025']
            ];
            break;

        case 'aset-tetap':
            $fileName = 'Template_Aset_Tetap.xlsx';
            $headings = [
                'kode_aset', 'nama_aset', 'tanggal_perolehan', 'harga_perolehan',
                'masa_manfaat_tahun', 'nilai_residu', 'keterangan'
            ];
            $exampleData = [
                ['AT001', 'Laptop Lenovo', '2025-01-01', '15000000', '4', '2000000', 'Baru']
            ];
            break;

        default:
            abort(404);
    }

    return Excel::download(new class($headings, $exampleData) implements \Maatwebsite\Excel\Concerns\FromArray {
        private $headings;
        private $data;

        public function __construct($headings, $data)
        {
            $this->headings = $headings;
            $this->data = $data;
        }

        public function array(): array
        {
            return array_merge([$this->headings], $this->data);
        }
    }, $fileName);
}
}