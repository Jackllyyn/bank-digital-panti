@extends('layouts.app')
@section('title', 'Inventaris Barang Panti')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-5 bg-green-600 text-white">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-xl font-semibold">Inventaris Barang Panti</h1>
                    <p class="text-green-100 text-sm mt-1">
                        Total barang: <span class="font-bold">{{ $inventaris->total() }}</span> item
                    </p>
                </div>
                <a href="{{ route('admin.inventaris.create') }}"
                   class="inline-flex items-center px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i> Tambah Barang
                </a>
            </div>
        </div>

        <div class="p-6">
            <!-- Search -->
            <form method="GET" class="mb-6">
                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari kode atau nama barang..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                    <button type="submit"
                            class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                        <i class="fas fa-search mr-2"></i> Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.inventaris.index') }}"
                           class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Kode</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Nama Barang</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Satuan</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-600 uppercase">Stok</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase">Harga Rata-rata</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase">Nilai Total</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-600 uppercase">Foto</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($inventaris as $i => $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-center text-gray-600">{{ $inventaris->firstItem() + $i }}</td>
                                <td class="px-4 py-3 text-sm font-mono font-bold text-green-700">{{ $item->kode_barang }}</td>
                                <td class="px-4 py-3 text-sm font-medium">{{ $item->nama_barang }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $item->satuan ?? '-' }}</td>
                                <td class="px-4 py-3 text-center text-sm font-bold {{ $item->stok <= 5 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ number_format($item->stok, 0) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-right">Rp {{ number_format($item->harga_rata2, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm text-right font-semibold text-indigo-600">
                                    Rp {{ number_format($item->stok * $item->harga_rata2, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/'.$item->foto) }}" class="h-12 w-12 object-cover rounded-lg mx-auto">
                                    @else
                                        <div class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto">
                                            <i class="fas fa-box text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right space-x-3">
                                    <a href="{{ route('admin.inventaris.edit', $item->kode_barang) }}"
                                       class="text-green-600 hover:text-green-800 text-sm font-medium">Edit</a>
                                    <form action="{{ route('admin.inventaris.destroy', $item->kode_barang) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin hapus {{ $item->nama_barang }}?')"
                                                class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-12 text-gray-500 text-sm">
                                    @if(request('search'))
                                        Tidak ditemukan barang dengan kata kunci "{{ request('search') }}"
                                    @else
                                        Belum ada data inventaris
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                {{ $inventaris->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection