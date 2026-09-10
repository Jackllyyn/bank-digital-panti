{{-- resources/views/admin/pengurus/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Pengurus')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Tambah Pengurus</h1>
        <a href="{{ route('admin.pengurus.index') }}"
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

    <form action="{{ route('admin.pengurus.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-xl shadow p-6 space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-medium">Nama <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none" required>
                @error('nama') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Jabatan <span class="text-red-500">*</span></label>
                <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none" required>
                @error('jabatan') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border rounded-lg px-3 py-2">
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon') }}"
                       class="w-full border rounded-lg px-3 py-2">
                @error('telepon') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block mb-1 font-medium">Deskripsi</label>
            <textarea name="deskripsi" rows="3"
                      class="w-full border rounded-lg px-3 py-2">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-medium">Foto</label>
                <input type="file" name="foto" accept="image/*" class="w-full border rounded-lg px-3 py-2">
                @error('foto') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Urutan</label>
                <input type="number" name="urutan" value="{{ old('urutan', 0) }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>

        <div>
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', true) ? 'checked' : '' }}
                       class="mr-2 rounded">
                <span>Aktif</span>
            </label>
        </div>

        <div class="flex gap-2 pt-4">
            <button type="submit"
                    class="bg-emerald-600 text-white px-5 py-2 rounded-lg hover:bg-emerald-700 transition">
                Simpan
            </button>
            <a href="{{ route('admin.pengurus.index') }}"
               class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection