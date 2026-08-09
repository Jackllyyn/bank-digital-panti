<!-- resources/views/admin/penerimaan-donasi/index.blade.php -->
@extends('layouts.app')
@section('title', 'Penerimaan Donasi')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <!-- Header -->
        <div class="px-6 py-5 bg-green-600 text-white rounded-t-xl">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-xl font-semibold">Penerimaan Donasi</h1>
                    <p class="text-green-100 text-sm mt-1">Catat & pantau semua donasi masuk ke panti asuhan</p>
                </div>
                <div class="text-right">
                    <p class="text-sm">Total donasi hari ini:</p>
                    <p class="text-2xl md:text-3xl font-bold">
                        Rp {{ number_format($totalHariIni, 0, ',', '.') }}
                    </p>
                    @if($totalHariIni == 0)
                        <p class="text-xs text-green-100 mt-1">Belum ada donasi hari ini</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-6">

            <!-- 1. Form Tambah Donasi Baru -->
            <div class="mb-12">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Catat Donasi Baru</h2>

                <form action="{{ route('admin.penerimaan-donasi.store') }}" method="POST"
                      class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                            @error('tanggal')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Akun Pendapatan</label>
                            <select name="kode_pendapatan" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                                <option value="">-- Pilih Akun Pendapatan --</option>
                                @foreach($akunPendapatan as $akun)
                                    <option value="{{ $akun->kode_akun }}" {{ old('kode_pendapatan') == $akun->kode_akun ? 'selected' : '' }}>
                                        {{ $akun->kode_akun }} — {{ $akun->nama_akun }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kode_pendapatan')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Cara Bayar</label>
                            <select name="cara_bayar" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer Bank</option>
                            </select>
                            @error('cara_bayar')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Donatur (opsional)</label>
                            <select name="kode_donatur"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                                <option value="">- Umum / Tidak diketahui -</option>
                                @foreach($donaturList as $d)
                                    <option value="{{ $d->kode_donatur }}" {{ old('kode_donatur') == $d->kode_donatur ? 'selected' : '' }}>
                                        {{ $d->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah (Rp)</label>
                            <input type="number" name="jumlah" required min="1" step="1"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm font-medium"
                                   value="{{ old('jumlah') }}">
                            @error('jumlah')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2 lg:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                            <textarea name="keterangan" rows="3" required placeholder="Contoh: Donasi operasional dari Bapak Ahmad"
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                                class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium flex items-center gap-2 shadow-sm">
                            <i class="fas fa-save"></i> Simpan & Buat Jurnal
                        </button>
                    </div>
                </form>
            </div>

            <!-- 2. Filter Riwayat Donasi - Versi Rapi -->
            <div class="mb-10">
                <h2 class="text-lg font-semibold text-gray-800 mb-5">Filter Riwayat Donasi</h2>

                <form method="GET" action="{{ route('admin.penerimaan-donasi.index') }}"
                      class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 lg:gap-6">

                        <div class="flex flex-col">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Dari</label>
                            <input type="date" name="dari" value="{{ request('dari') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                        </div>

                        <div class="flex flex-col">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Sampai</label>
                            <input type="date" name="sampai" value="{{ request('sampai') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                        </div>

                        <div class="flex flex-col">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Akun Pendapatan</label>
                            <select name="kode_pendapatan" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                                <option value="">Semua Akun</option>
                                @foreach($akunPendapatan as $akun)
                                    <option value="{{ $akun->kode_akun }}" {{ request('kode_pendapatan') == $akun->kode_akun ? 'selected' : '' }}>
                                        {{ $akun->kode_akun }} — {{ Str::limit($akun->nama_akun, 35) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Donatur</label>
                            <select name="kode_donatur" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                                <option value="">Semua Donatur</option>
                                <option value="umum" {{ request('kode_donatur') == 'umum' ? 'selected' : '' }}>Umum / Tidak diketahui</option>
                                @foreach($donaturList as $d)
                                    <option value="{{ $d->kode_donatur }}" {{ request('kode_donatur') == $d->kode_donatur ? 'selected' : '' }}>
                                        {{ Str::limit($d->nama, 30) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Cara Bayar</label>
                            <select name="cara_bayar" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                                <option value="">Semua Cara</option>
                                <option value="tunai" {{ request('cara_bayar') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                <option value="transfer" {{ request('cara_bayar') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col sm:flex-row sm:justify-end gap-3">
                        <button type="submit"
                                class="px-8 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium shadow-sm">
                            Filter
                        </button>
                        <a href="{{ route('admin.penerimaan-donasi.index') }}"
                           class="px-8 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm font-medium text-center shadow-sm">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Tombol Export -->
            <div class="mb-8 flex flex-wrap gap-3">
                <a href="{{ route('admin.penerimaan-donasi.export.pdf') . '?' . http_build_query(request()->query()) }}"
                   class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium flex items-center gap-2 shadow-sm">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('admin.penerimaan-donasi.export.excel') . '?' . http_build_query(request()->query()) }}"
                   class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium flex items-center gap-2 shadow-sm">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>

            <!-- Tabel Riwayat -->
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akun Pendapatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donatur</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cara</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($donasis as $d)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $d->tanggal->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($d->akunPendapatan)
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $d->akunPendapatan->kode_akun }} — {{ $d->akunPendapatan->nama_akun }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $d->donatur?->nama ?? 'Umum' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-700">
                                    Rp {{ number_format($d->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $d->cara_bayar == 'tunai' ? 'bg-green-100 text-green-800' :
                                           ($d->cara_bayar == 'transfer' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                                        {{ ucfirst($d->cara_bayar) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $d->user->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <div class="flex items-center justify-center gap-4">
                                        <a href="{{ route('admin.penerimaan-donasi.struk', $d->id) }}" target="_blank"
                                           class="text-gray-500 hover:text-indigo-600" title="Cetak Struk">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <a href="{{ route('admin.penerimaan-donasi.edit', $d->id) }}"
                                           class="text-gray-500 hover:text-blue-600" title="Edit Donasi">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.penerimaan-donasi.destroy', $d->id) }}" method="POST"
                                              onsubmit="return confirm('Anda yakin ingin menghapus donasi ini? Tindakan ini juga akan menghapus jurnal terkait.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-500 hover:text-red-600" title="Hapus Donasi">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center text-gray-500">
                                    Belum ada data penerimaan donasi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $donasis->appends(request()->query())->links('vendor.pagination.tailwind') }}
            </div>

        </div>
    </div>
</div>
@endsection