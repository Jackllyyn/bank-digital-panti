@extends('layouts.app')
@section('title', 'Trash Donatur')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Trash Donatur (Soft Deleted)</h1>
            <div class="flex gap-3">
                <button type="button" data-modal-target="forceDeleteAllModal" data-modal-toggle="forceDeleteAllModal"
                        class="px-5 py-2.5 bg-red-100 hover:bg-red-200 text-red-800 text-sm font-medium rounded-lg shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus Permanen Semua
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kota</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($donaturs as $donatur)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $donatur->kode_donatur }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $donatur->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $donatur->kota ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <form action="{{ route('admin.donatur.restore', $donatur->kode_donatur) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-green-600 hover:text-green-800 mr-3">Restore</button>
                                </form>
                                <form action="{{ route('admin.donatur.forceDelete', $donatur->kode_donatur) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus PERMANEN?')" class="text-red-600 hover:text-red-800">
                                        Hapus Permanen
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-12 text-gray-500">Trash kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.donatur.index') }}" class="text-green-600 hover:underline font-medium">
                ← Kembali ke Daftar Donatur
            </a>
        </div>
    </div>

    <!-- Modal Hapus Permanen Semua -->
    <div id="forceDeleteAllModal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-xl shadow-lg">
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-red-800">Hapus Permanen Semua Donatur</h3>
                    <button type="button" data-modal-hide="forceDeleteAllModal"
                            class="text-gray-400 hover:bg-gray-200 rounded-lg w-8 h-8 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <p class="text-red-600 font-medium mb-4">PERINGATAN! Ini akan menghapus SEMUA data donatur di trash secara PERMANEN dan tidak bisa dikembalikan.</p>
                    <form action="{{ route('admin.donatur.force-delete-all') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Ketik <strong>YA</strong> untuk konfirmasi
                            </label>
                            <input type="text" name="confirmation" placeholder="YA" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500">
                            @error('confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex justify-end gap-4">
                            <button type="button" data-modal-hide="forceDeleteAllModal"
                                    class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                Hapus Permanen Semua
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 hidden" id="modal-backdrop"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
@endsection