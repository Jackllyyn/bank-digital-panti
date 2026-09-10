{{-- resources/views/admin/galeri/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Galeri')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Detail Galeri</h1>
        <a href="{{ route('admin.galeri.index') }}"
           class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
            ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-6 space-y-4">
        @if($galeri->gambar)
            <img src="{{ asset('storage/' . $galeri->gambar) }}"
                 class="w-full max-w-lg rounded-lg object-cover" alt="{{ $galeri->judul }}">
        @endif

        <div>
            <p class="text-sm text-gray-500">Judul</p>
            <p class="font-medium">{{ $galeri->judul }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Kategori</p>
            <p>{{ $galeri->kategori ?? '-' }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Tanggal</p>
            <p>{{ $galeri->tanggal ? \Carbon\Carbon::parse($galeri->tanggal)->format('d M Y') : '-' }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Deskripsi</p>
            <p class="whitespace-pre-line">{{ $galeri->deskripsi ?? '-' }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Status</p>
            <span class="px-2 py-1 text-xs rounded-full {{ $galeri->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                {{ $galeri->is_published ? 'Published' : 'Draft' }}
            </span>
        </div>

        <div>
            <p class="text-sm text-gray-500">Views</p>
            <p>{{ $galeri->views ?? 0 }}</p>
        </div>
    </div>
</div>
@endsection