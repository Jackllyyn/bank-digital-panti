{{-- resources/views/admin/pengurus/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Pengurus')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Kelola Pengurus</h1>
        <a href="{{ route('admin.pengurus.create') }}"
           class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition">
            + Tambah Pengurus
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telepon</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urutan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($pengurus as $index => $item)
                    <tr>
                        <td class="px-4 py-4">{{ $index + 1 }}</td>
                        <td class="px-4 py-4">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}"
                                     class="w-12 h-12 rounded-full object-cover" alt="{{ $item->nama }}">
                            @else
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xl font-bold">
                                    {{ $item->nama[0] ?? '?' }}
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-4 font-medium">{{ $item->nama }}</td>
                        <td class="px-4 py-4">{{ $item->jabatan }}</td>
                        <td class="px-4 py-4 text-sm text-gray-600">{{ $item->email ?? '-' }}</td>
                        <td class="px-4 py-4 text-sm text-gray-600">{{ $item->telepon ?? '-' }}</td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-4">{{ $item->urutan }}</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <a href="{{ route('admin.pengurus.edit', $item->id) }}"
                               class="text-blue-600 hover:text-blue-900 mr-2">Edit</a>
                            <form action="{{ route('admin.pengurus.destroy', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-4 text-center text-gray-500">Belum ada data pengurus.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection