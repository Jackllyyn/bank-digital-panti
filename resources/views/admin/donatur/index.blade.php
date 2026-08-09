@extends('layouts.app')
@section('title', 'Daftar Donatur')

@section('content')
    <div class="max-w-full mx-auto px-4 py-8" x-data="{ showTruncateConfirm: false, showImportModal: false }">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <h1 class="text-2xl font-semibold text-gray-800">Daftar Donatur</h1>
            <div class="mt-4 sm:mt-0 flex flex-wrap gap-3">
                <a href="{{ route('admin.donatur.create') }}"
                   class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                    + Tambah Donatur
                </a>

                <a href="{{ route('admin.donatur.trash') }}"
                   class="px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                    Trash ({{ $trashCount }})
                </a>

                <a href="{{ route('admin.import.template', ['type' => 'donatur']) }}"
                   class="px-5 py-2.5 bg-green-100 hover:bg-green-200 text-green-800 text-sm font-medium rounded-lg shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Template
                </a>

                <button type="button" @click="showImportModal = true"
                        class="px-5 py-2.5 bg-green-100 hover:bg-green-200 text-green-800 text-sm font-medium rounded-lg shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Import
                </button>

                <a href="{{ route('admin.donatur.export.excel', request()->query()) }}"
                   class="px-5 py-2.5 bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium rounded-lg shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Excel
                </a>

                <a href="{{ route('admin.donatur.export.pdf', request()->query()) }}" 
                   target="_blank" 
                   class="px-5 py-2.5 bg-red-100 hover:bg-red-200 text-red-800 text-sm font-medium rounded-lg shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Export PDF
                </a>
            </div>
        </div>
        
        <!-- Konfirmasi Hapus Semua (inline, bukan modal) -->
        <div x-show="showTruncateConfirm" x-transition class="bg-red-50 border border-red-300 rounded-xl p-6 mb-8">
            <h3 class="text-lg font-bold text-red-800 mb-4">Konfirmasi Hapus SEMUA Data Donatur</h3>
            <p class="text-gray-700 mb-6">
                Tindakan ini <strong>tidak dapat dibatalkan</strong> dan akan menghapus <strong>semua data donatur</strong> secara permanen.
            </p>

            <form action="{{ route('admin.donatur.truncate') }}" method="POST" class="flex flex-wrap items-center gap-4">
                @csrf
                <label class="flex items-center text-red-700 font-medium">
                    <input type="checkbox" name="confirmation" value="YA" class="mr-2 h-4 w-4 text-red-600 rounded" required>
                    Saya mengerti dan ingin menghapus SEMUA data
                </label>

                <div class="flex gap-3">
                    <button type="submit"
                            class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition">
                        Hapus Permanen
                    </button>
                    <button type="button"
                            @click="showTruncateConfirm = false"
                            class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cari Nama / Kode / Kota</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Donatur</label>
                    <input type="text" name="jenis_donatur" value="{{ request('jenis_donatur') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Klasifikasi</label>
                    <select name="klasifikasi"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Semua</option>
                        <option value="tetap" {{ request('klasifikasi') == 'tetap' ? 'selected' : '' }}>Tetap</option>
                        <option value="tidak tetap" {{ request('klasifikasi') == 'tidak tetap' ? 'selected' : '' }}>Tidak Tetap</option>
                    </select>
                </div>
        {{-- Filter --}}
                <div class="flex items-end gap-3">
                    <button type="submit"
                            class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'jenis_donatur', 'klasifikasi']))
                        <a href="{{ route('admin.donatur.index') }}" class="text-gray-600 text-sm underline">Reset</a>
                    @endif
                </div>
            </form>
            
            <div class="mt-4 pt-4 border-t border-gray-100">
                <form action="{{ route('admin.donatur.recalculate') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghitung ulang total donasi seluruh donatur? Proses ini mungkin memakan waktu.');">
                    @csrf
                    <button type="submit" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium flex items-center gap-2 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                        Sinkronisasi Total Donasi
                    </button>
                </form>
            </div>
        </div>

        <!-- Tabel -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kota</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pekerjaan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klasifikasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Daftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terakhir Donasi</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Donasi Uang</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Donasi Barang</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Keseluruhan</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($donaturs as $donatur)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 cursor-pointer" onclick="window.location.href = '{{ route('admin.donatur.struk', $donatur->kode_donatur) }}'">{{ $donatur->kode_donatur }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 cursor-pointer" onclick="window.location.href = '{{ route('admin.donatur.struk', $donatur->kode_donatur) }}'">{{ $donatur->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap cursor-pointer" onclick="window.location.href = '{{ route('admin.donatur.struk', $donatur->kode_donatur) }}'">
                                    @if($donatur->jenis_donatur)
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $donatur->jenis_donatur === 'individu' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                            {{ $donatur->jenis_donatur_display ?? ucfirst($donatur->jenis_donatur) }}
                                        </span>
                                    @else
                                        <span class="text-gray-500 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 cursor-pointer" onclick="window.location.href = '{{ route('admin.donatur.struk', $donatur->kode_donatur) }}'">{{ $donatur->kota ?: '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 cursor-pointer" onclick="window.location.href = '{{ route('admin.donatur.struk', $donatur->kode_donatur) }}'">{{ $donatur->pekerjaan ?: '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap cursor-pointer" onclick="window.location.href = '{{ route('admin.donatur.struk', $donatur->kode_donatur) }}'">
                                    @if($donatur->klasifikasi)
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $donatur->klasifikasi === 'tetap' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ ucwords($donatur->klasifikasi) }}
                                        </span>
                                    @else
                                        <span class="text-gray-500 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 cursor-pointer" onclick="window.location.href = '{{ route('admin.donatur.struk', $donatur->kode_donatur) }}'">{{ $donatur->tanggal_daftar_formatted ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 cursor-pointer" onclick="window.location.href = '{{ route('admin.donatur.struk', $donatur->kode_donatur) }}'">{{ $donatur->terakhir_donasi_formatted ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-green-700 cursor-pointer" onclick="window.location.href = '{{ route('admin.donatur.struk', $donatur->kode_donatur) }}'">{{ $donatur->total_donasi_rp ?? 'Rp 0' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-purple-700 cursor-pointer" onclick="window.location.href = '{{ route('admin.donatur.struk', $donatur->kode_donatur) }}'">{{ $donatur->total_nilai_donasi_barang_formatted ?? 'Rp 0' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900 cursor-pointer" onclick="window.location.href = '{{ route('admin.donatur.struk', $donatur->kode_donatur) }}'">{{ $donatur->total_keseluruhan_rp ?? 'Rp 0' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <div class="flex items-center justify-center gap-4 opacity-100 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.donatur.edit', $donatur->kode_donatur) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Edit</a>
                                        <form action="{{ route('admin.donatur.destroy', $donatur->kode_donatur) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus donatur ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-16 text-gray-500">
                                    <div class="text-5xl mb-4 opacity-30">📭</div>
                                    <p class="text-lg font-medium">Belum ada data donatur</p>
                                    <p class="mt-2">Mulai dengan menambahkan atau mengimport data</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $donaturs->appends(request()->query())->links('vendor.pagination.tailwind') }}
            </div>
        </div>

        <!-- Modal Import -->
        <div x-show="showImportModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showImportModal = false">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full" x-transition>
                    <form action="{{ route('admin.donatur.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Import Data Donatur</h3>
                            <div class="mt-4">
                                <p class="text-sm text-gray-500 mb-4">Silakan upload file Excel (.xlsx) sesuai template yang telah disediakan.</p>
                                <input type="file" name="file" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Import</button>
                            <button type="button" @click="showImportModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection