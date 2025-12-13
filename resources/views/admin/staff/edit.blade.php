@extends('layouts.app')
@section('title', 'Edit Staff')

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Edit Staff</h1>
            <a href="{{ route('admin.staff.index') }}" class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
        </div>

        <form action="{{ route('admin.staff.update', $staff) }}" method="POST">
            @csrf @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $staff->name) }}" required
                           class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-400">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $staff->email) }}" required
                           class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-400">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Password Baru <span class="text-gray-500 text-xs">(kosongkan jika tidak diganti)</span>
                    </label>
                    <input type="password" name="password"
                           class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-400">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                           class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-400">
                </div>
            </div>

            <div class="mt-10 flex justify-end space-x-4">
                <a href="{{ route('admin.staff.index') }}"
                   class="px-8 py-3 bg-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-10 py-3 bg-emerald-600 text-white font-medium rounded-xl hover:bg-emerald-700 transition shadow-md">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection