@extends('layouts.app')

@section('title', 'Daftar Donatur')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Donatur</h1>
            <div class="flex gap-3">
                <a href="{{ route('admin.donatur.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-lg shadow">
                    + Tambah Donatur
                </a>
                <a href="{{ route('admin.donatur.trash') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-medium px-5 py-2.5 rounded-lg shadow">
                    Lihat Trash ({{ \App\Models\Donatur::onlyTrashed()->count() }})
                </a>
            </div>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.donatur.index') }}" class="mb-6">
            <div class="flex gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode / nama / kota..."
                    class="border border-gray-300 rounded-lg px-4 py-2.5 w-96 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg font-medium">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.donatur.index') }}" class="text-gray-600 hover:text-gray-900 underline">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Tabel Donatur -->
        <div class="bg-white shadow overflow-hidden rounded-lg border">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis
                            Donatur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat
                            Lengkap</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kota</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">J.
                            Kelamin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pekerjaan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Klasifikasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl
                            Daftar</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($donaturs as $donatur)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $donatur->kode_donatur }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $donatur->jenis_donatur ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $donatur->nama }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">
                                {{ $donatur->alamat_lengkap ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $donatur->kota ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $donatur->jenis_kelamin == 'L' ? 'Laki-laki' : ($donatur->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $donatur->pekerjaan ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $donatur->klasifikasi == 'tetap' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($donatur->klasifikasi ?? '-') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $donatur->tanggal_daftar }} 
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <a href="{{ route('admin.donatur.edit', $donatur->kode_donatur) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>

                                <form action="{{ route('admin.donatur.destroy', $donatur->kode_donatur) }}" method="POST"
                                    class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin hapus donatur ini?')"
                                        class="text-red-600 hover:text-red-900">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                                @if(request('search'))
                                    Tidak ditemukan donatur dengan kata kunci "<strong>{{ request('search') }}</strong>"
                                @else
                                    Belum ada data donatur.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $donaturs->appends(request()->query())->links() }}
        </div>
    </div>
@endsection