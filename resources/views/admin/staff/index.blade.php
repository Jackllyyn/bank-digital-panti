@extends('layouts.app')
@section('title', 'Kelola Staff')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Kelola Staff</h1>
            <a href="{{ route('admin.staff.create') }}" class="px-6 py-3 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition">
                Tambah Staff
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Terdaftar</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($staffs as $i => $staff)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $i + $staffs->firstItem() }}</td>
                        <td class="px-6 py-4 font-medium">{{ $staff->name }}</td>
                        <td class="px-6 py-4">{{ $staff->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $staff->created_at->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 space-x-3">
                            <a href="{{ route('admin.staff.edit', $staff) }}" class="text-emerald-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.staff.destroy', $staff) }}" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus staff ini?')"
                                        class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-12 text-gray-400">Belum ada staff</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $staffs->links() }}</div>
    </div>
</div>
@endsection