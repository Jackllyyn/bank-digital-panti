{{-- resources/views/admin/berita/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Berita')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Kelola Berita</h1>
        <a href="{{ route('admin.berita.create') }}"
           class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition">
            + Tambah Berita
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penulis</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Views</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($berita as $index => $item)
                    <tr>
                        <td class="px-4 py-4">{{ $berita->firstItem() + $index }}</td>
                        <td class="px-4 py-4">
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}"
                                     class="w-16 h-16 rounded-lg object-cover" alt="{{ $item->judul }}">
                            @else
                                <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center text-gray-400">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-4 font-medium max-w-xs">
                            {{ \Illuminate\Support\Str::limit($item->judul, 50) }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-600">{{ $item->kategori ?? '-' }}</td>
                        <td class="px-4 py-4 text-sm text-gray-600">{{ $item->penulis ?? '-' }}</td>
                        <td class="px-4 py-4 text-sm text-gray-600">
                            @if($item->published_at)
                                {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}
                            @elseif($item->created_at)
                                {{ $item->created_at->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-600">{{ $item->views ?? 0 }}</td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $item->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $item->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <a href="{{ route('admin.berita.edit', $item->id) }}"
                               class="text-blue-600 hover:text-blue-900 mr-2">Edit</a>
                            <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" class="inline">
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
                        <td colspan="9" class="px-4 py-4 text-center text-gray-500">Belum ada data berita.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($berita, 'hasPages') && $berita->hasPages())
        <div class="mt-6">
            {{ $berita->links() }}
        </div>
    @endif
</div>
@endsection