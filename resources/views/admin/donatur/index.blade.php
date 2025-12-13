@extends('layouts.app')
@section('title', 'Daftar Donatur')

@section('content')
<div class="max-w-full mx-auto px-4 py-8">

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
                Trash ({{ \App\Models\Donatur::onlyTrashed()->count() }})
            </a>

            <a href="{{ route('admin.import.template', 'donatur') }}"
               class="px-5 py-2.5 bg-green-100 hover:bg-green-200 text-green-800 text-sm font-medium rounded-lg shadow-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Template
            </a>

            <button type="button" data-bs-toggle="modal" data-bs-target="#importModal"
                    class="px-5 py-2.5 bg-green-100 hover:bg-green-200 text-green-800 text-sm font-medium rounded-lg shadow-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Import
            </button>

            <button type="button" data-bs-toggle="modal" data-bs-target="#truncateModal"
                    class="px-5 py-2.5 bg-red-100 hover:bg-red-200 text-red-800 text-sm font-medium rounded-lg shadow-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Hapus Semua
            </button>
        </div>
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
            <div class="flex items-end gap-3">
                <button type="submit" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'jenis_donatur', 'klasifikasi']))
                    <a href="{{ route('admin.donatur.index') }}" class="text-gray-600 text-sm underline">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel - Klik baris langsung buka struk -->
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
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Donasi</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($donaturs as $donatur)
                        <tr class="hover:bg-gray-50 cursor-pointer"
                            onclick="window.location.href = '{{ route('admin.donatur.struk', $donatur->kode_donatur) }}'">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $donatur->kode_donatur }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $donatur->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $donatur->jenis_donatur ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $donatur->kota ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $donatur->pekerjaan ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full
                                    {{ $donatur->klasifikasi == 'tetap' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $donatur->klasifikasi ? ucwords($donatur->klasifikasi) : '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $donatur->tanggal_daftar_formatted }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">
                                {{ $donatur->total_donasi_rp }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <a href="{{ route('admin.donatur.edit', $donatur->kode_donatur) }}"
                                   class="text-indigo-600 hover:text-indigo-800 mr-3">Edit</a>
                                <form action="{{ route('admin.donatur.destroy', $donatur->kode_donatur) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus donatur ini?')" class="text-red-600 hover:text-red-800">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-12 text-gray-500">Belum ada data donatur</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $donaturs->appends(request()->query())->links('vendor.pagination.tailwind') }}
        </div>
    </div>

</div>
@endsection