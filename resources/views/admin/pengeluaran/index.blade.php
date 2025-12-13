@extends('layouts.app')
@section('title', 'Pengeluaran')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-5 bg-green-600 text-white">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-xl font-semibold">Pengeluaran Operasional</h1>
                    <p class="text-green-100 text-sm mt-1">Catat semua pengeluaran harian panti</p>
                </div>
                <a href="{{ route('admin.pengeluaran.create') }}"
                   class="inline-flex items-center px-5 py-2 bg-white text-green-700 rounded-lg hover:bg-green-100 transition text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i> Input Baru
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
                        <label class="block text-xs text-gray-600 mb-1">Akun Beban</label>
                        <select x-model="akun" @change="filter()"
                                class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm">
                            <option value="">Semua Akun</option>
                            @foreach(\App\Models\DaftarAkun::where('kelompok', 'BEBAN')->orderBy('kode_akun')->get() as $a)
                                <option value="{{ $a->kode_akun }}">{{ $a->nama_akun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">Tanggal</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">Akun</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">Keterangan</th>
                            <th class="px-5 py-3 text-right text-xs font-medium text-gray-600 uppercase">Jumlah</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">User</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($pengeluarans as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-3 text-sm">{{ $p->tanggal->translatedFormat('d M Y') }}</td>
                                <td class="px-5 py-3 text-sm font-medium">{{ $p->akun->nama_akun }}</td>
                                <td class="px-5 py-3 text-sm text-gray-700 max-w-xs truncate">{{ Str::limit($p->keterangan, 60) }}</td>
                                <td class="px-5 py-3 text-right text-sm font-bold text-green-700">
                                    Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3 text-xs text-gray-600">{{ $p->user->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-sm text-gray-500">
                                    Belum ada data pengeluaran
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                {{ $pengeluarans->withQueryString()->links('vendor.pagination.tailwind') }}
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