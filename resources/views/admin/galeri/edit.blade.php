{{-- resources/views/admin/galeri/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Galeri')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Edit Galeri</h1>
        <a href="{{ route('admin.galeri.index') }}"
           class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
            ← Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-xl shadow p-6 space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-medium">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul', $galeri->judul) }}"
                       class="w-full border rounded-lg px-3 py-2" required>
                @error('judul') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori', $galeri->kategori) }}"
                       class="w-full border rounded-lg px-3 py-2">
                @error('kategori') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Tanggal</label>
                <input type="date" name="tanggal"
                       value="{{ old('tanggal', $galeri->tanggal ? \Carbon\Carbon::parse($galeri->tanggal)->format('Y-m-d') : date('Y-m-d')) }}"
                       class="w-full border rounded-lg px-3 py-2">
                @error('tanggal') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Lokasi</label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $galeri->lokasi) }}"
                       class="w-full border rounded-lg px-3 py-2">
                @error('lokasi') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Status</label>
                <select name="is_published" class="w-full border rounded-lg px-3 py-2">
                    <option value="1" {{ old('is_published', $galeri->is_published) ? 'selected' : '' }}>Published</option>
                    <option value="0" {{ old('is_published', $galeri->is_published) === 0 || old('is_published') === '0' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block mb-1 font-medium">Deskripsi</label>
            <textarea name="deskripsi" rows="3"
                      class="w-full border rounded-lg px-3 py-2">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
            @error('deskripsi') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Gambar</label>
            @if($galeri->gambar)
                <img src="{{ asset('storage/' . $galeri->gambar) }}"
                     class="w-32 h-32 rounded-lg object-cover mb-2" alt="Gambar saat ini">
            @endif
            <input type="file" name="gambar" accept="image/*"
                   class="w-full border rounded-lg px-3 py-2">
            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti gambar. Maks 5MB.</p>
            @error('gambar') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-2 pt-4">
            <button type="submit"
                    class="bg-emerald-600 text-white px-5 py-2 rounded-lg hover:bg-emerald-700 transition">
                Update
            </button>
            <a href="{{ route('admin.galeri.index') }}"
               class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection