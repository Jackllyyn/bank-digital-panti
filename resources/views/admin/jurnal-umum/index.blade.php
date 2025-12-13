@extends('layouts.app')
@section('title', 'Jurnal Umum')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <!-- Header + Tombol Export -->
        <div class="px-8 py-5 bg-green-50 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Jurnal Umum</h1>
                <p class="text-sm text-gray-600 mt-1">Semua transaksi tercatat otomatis</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.jurnal.excel') }}" 
                   class="px-5 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                    Export Excel
                </a>
                <a href="{{ route('admin.jurnal.pdf') }}" 
                   class="px-5 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">
                    Export PDF
                </a>
            </div>
        </div>

        <!-- Filter & Tabel (tetap sama seperti yang sudah jalan) -->
        <div class="p-8" x-data="jurnalFilter()">
            <!-- Filter tetap -->
            <div class="bg-gray-50 rounded-lg p-5 mb-8 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" x-model="dari" @change="applyFilter()" class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" x-model="sampai" @change="applyFilter()" class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Akun</label>
                        <select x-model="akun" @change="applyFilter()" class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-green-400">
                            <option value="">Semua Akun</option>
                            @foreach($akuns as $a)
                                <option value="{{ $a->kode_akun }}">{{ $a->kode_akun }} - {{ $a->nama_akun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tabel & Pagination tetap -->
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium text-gray-700">Tanggal</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-700">No. Transaksi</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-700">Uraian</th>
                            <th class="px-6 py-3 text-center font-medium text-gray-700">Debet</th>
                            <th class="px-6 py-3 text-center font-medium text-gray-700">Kredit</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-700">User</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($jurnals as $j)
                        <tr class="hover:bg-green-50 transition">
                            <td class="px-6 py-4 text-gray-800">{{ $j->tanggal->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 font-mono text-sm text-green-700">{{ $j->no_transaksi }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $j->uraian }}</td>
                            <td class="px-6 py-4 text-right font-medium text-green-600">
                                {{ $j->akunDebet ? 'Rp ' . number_format($j->jumlah, 0, ',', '.') : '—' }}
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-red-600">
                                {{ $j->akunKredit ? 'Rp ' . number_format($j->jumlah, 0, ',', '.') : '—' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500">{{ $j->user->name }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-16 text-gray-400">Belum ada jurnal</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $jurnals->withQueryString()->links() }}</div>
        </div>
    </div>
</div>

<script>
function jurnalFilter() {
    return {
        dari: '{{ request('dari') }}',
        sampai: '{{ request('sampai') }}',
        akun: '{{ request('akun') }}',
        applyFilter() {
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