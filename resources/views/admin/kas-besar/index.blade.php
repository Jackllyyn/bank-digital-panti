@extends('layouts.app')
@section('title', 'Transaksi Kas Besar')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-5 bg-green-600 text-white">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-xl font-semibold">Kas Besar</h1>
                    <p class="text-green-100 text-sm mt-1">Catat Kas Besar panti</p>
                </div>
                <a href="{{ route('admin.kas-besar.create') }}"
                   class="inline-flex items-center px-5 py-2 bg-white text-green-700 rounded-lg hover:bg-green-100 transition text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i> Transaksi Baru
                </a>
            </div>
        </div>

        <div class="p-6">
            <!-- Filter -->
            <div x-data="filterData()" class="bg-gray-50 rounded-xl p-5 mb-6 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Dari Tanggal</label>
                        <input type="date" x-model="dari" @change="filter()"
                               class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Sampai Tanggal</label>
                        <input type="date" x-model="sampai" @change="filter()"
                               class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Pilih Akun</label>
                        <select x-model="akun" @change="filter()"
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm">
                            <option value="">Semua Akun</option>
                            @foreach($akuns as $akun)
                                <option value="{{ $akun->kode_akun }}" {{ request('akun') == $akun->kode_akun ? 'selected' : '' }}>
                                    {{ $akun->kode_akun }} - {{ $akun->nama_akun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-2 flex flex-wrap gap-3">
                <a href="{{ route('admin.kas-besar.export.excel') . '?' . http_build_query(request()->query()) }}"
                   class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium flex items-center gap-2 shadow-sm">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">Tanggal</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">No Transaksi</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">Akun</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">Uraian</th>
                            <th class="px-5 py-3 text-right text-xs font-medium text-gray-600 uppercase">Jumlah</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">Dibuat Oleh</th>
                            <th class="px-5 py-3 text-center text-xs font-medium text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($kas_besars as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-3 text-sm">{{ $p->tanggal->translatedFormat('d M Y') }}</td>
                                <td class="px-5 py-3 text-sm">{{ $p->no_transaksi }}</td>
                                <td class="px-5 py-3 text-sm font-medium">{{ $p->akunDebet->nama_akun ?? '-'}} / {{ $p->akunKredit->nama_akun ?? '-' }}</td>
                                <td class="px-5 py-3 text-sm text-gray-700 max-w-xs truncate">{{ Str::limit($p->keterangan, 60) }}</td>
                                <td class="px-5 py-3 text-right text-sm font-bold text-green-700">
                                    Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3 text-xs text-gray-600">{{ $p->user->name }}</td>
                                <td class="px-5 py-3 text-center text-sm space-x-2">
                                    <a href="{{ route('admin.kas-besar.edit', $p->id) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.kas-besar.destroy', $p->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form> 
                                </td>
                                <td class="px-5 py-3 text-center text-sm space-x-2">
                                    <a href="{{ route('admin.kas-besar.print', $p->id) }}" 
                                       target="_blank" 
                                       class="text-green-600 hover:text-green-900" 
                                       title="Cetak Bukti">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-sm text-gray-500">
                                    Belum ada data transaksi kas besar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                {{ $kas_besars->withQueryString()->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>

<script>
function filterData() {
    return {
        dari: '{{ request('dari') }}',
        sampai: '{{ request('sampai') }}',
        akun: '{{ request('akun') }}',
        filter() {
            const params = new URLSearchParams();
            if (this.dari) params.append('dari', this.dari);
            if (this.sampai) params.append('sampai', this.sampai);
            if (this.akun) params.append('akun', this.akun);
            window.location.search = params.toString();
        }
    }
}
</script>
@endsection