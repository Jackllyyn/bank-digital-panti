@extends('layouts.app')
@section('title', 'Audit Log Aktivitas')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-5 bg-green-600 text-white">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-xl font-semibold">Audit Log Aktivitas Sistem</h1>
                    <p class="text-green-100 text-sm mt-1">Semua aktivitas user tercatat otomatis & aman</p>
                </div>
                <p class="text-sm">Total: <span class="font-bold">{{ $logs->total() }}</span> aktivitas</p>
            </div>
        </div>

        <div class="p-6">
            <!-- Filter -->
            <div class="bg-gray-50 rounded-lg p-5 mb-6 border border-gray-200">
                <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari user / aktivitas..." 
                           class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 text-sm">

                    <input type="date" name="dari" value="{{ request('dari') }}"
                           class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 text-sm">

                    <input type="date" name="sampai" value="{{ request('sampai') }}"
                           class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 text-sm">

                    <button type="submit"
                            class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                        Filter
                    </button>
                </form>
            </div>

            <!-- Tabel Log (lebih compact) -->
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">Waktu</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">User</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">Aktivitas</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-3 text-xs text-gray-700">
                                    {{ $log->created_at->translatedFormat('d M Y H:i') }}
                                </td>
                                <td class="px-5 py-3 text-sm font-medium">
                                    {{ $log->causer?->name ?? 'System' }}
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $log->description == 'created' ? 'bg-blue-100 text-blue-800' :
                                           ($log->description == 'updated' ? 'bg-yellow-100 text-yellow-800' :
                                           'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($log->description) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-xs text-gray-600">
                                    {{ class_basename($log->subject_type ?? '') }}
                                    @if($log->subject_id)
                                        <span class="font-mono text-gray-700">#{{ $log->subject_id }}</span>
                                    @endif
                                    @if($log->properties && $log->properties->count() > 0)
                                        <br><span class="text-gray-500 italic">{{ Str::limit(json_encode($log->properties), 80) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-12 text-gray-500 text-sm">
                                    <i class="fas fa-history text-4xl mb-3"></i>
                                    <p>Belum ada aktivitas tercatat</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                {{ $logs->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection