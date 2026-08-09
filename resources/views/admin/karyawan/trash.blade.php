@extends('layouts.app')
@section('title', 'Trash Karyawan')

@section('content')
<div x-data="{ showForceDeleteAllConfirm: false }" class="max-w-full mx-auto px-4 py-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">Trash Karyawan</h1>
        <div class="mt-4 sm:mt-0 flex flex-wrap gap-3">
            <a href="{{ route('admin.karyawan.index') }}"
               class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-lg shadow-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <button type="button" @click="showForceDeleteAllConfirm = true"
                    class="px-5 py-2.5 bg-red-100 hover:bg-red-200 text-red-800 text-sm font-medium rounded-lg shadow-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Hapus Permanen Semua
            </button>
        </div>
    </div>

    <!-- Konfirmasi Hapus Permanen Semua -->
    <div x-show="showForceDeleteAllConfirm" x-transition class="bg-red-50 border border-red-300 rounded-xl p-6 mb-8">
        <h3 class="text-lg font-bold text-red-800 mb-4">Konfirmasi Hapus PERMANEN SEMUA Data di Trash</h3>
        <p class="text-gray-700 mb-6">
            Tindakan ini <strong>tidak dapat dibatalkan</strong> dan akan menghapus <strong>semua data karyawan</strong> yang ada di dalam trash secara permanen.
        </p>

        <form action="{{ route('admin.karyawan.force-delete-all') }}" method="POST" class="flex flex-wrap items-center gap-4">
            @csrf
            @method('DELETE')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ketik <strong>YA</strong> untuk konfirmasi</label>
                <input type="text" name="confirmation" class="px-3 py-2 border border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500" required placeholder="YA">
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition">
                    Hapus Permanen
                </button>
                <button type="button"
                        @click="showForceDeleteAllConfirm = false"
                        class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition">
                    Batal
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($karyawans as $karyawan)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $karyawan->nip }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $karyawan->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $karyawan->jabatan ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                            <div class="flex items-center justify-center gap-4">
                                <form action="{{ route('admin.karyawan.restore', $karyawan->nip) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-green-600 hover:text-green-800 font-medium">Pulihkan</button>
                                </form>
                                <form action="{{ route('admin.karyawan.forceDelete', $karyawan->nip) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menghapus data ini secara PERMANEN? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                        Hapus Permanen
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-16 text-gray-500">
                            <div class="text-5xl mb-4 opacity-30">🗑️</div>
                            <p class="text-lg font-medium">Trash kosong</p>
                            <p class="mt-2">Tidak ada data karyawan yang dihapus.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($karyawans->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $karyawans->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection