@extends('layouts.app')
@section('title', 'Penerimaan Donasi')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-6 py-5 bg-green-600 text-white">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-xl font-semibold">Penerimaan Donasi</h1>
                    <p class="text-green-100 text-sm mt-1">Catat & pantau semua donasi masuk</p>
                </div>
                <p class="text-sm">Total hari ini: <span class="font-bold">{{ $donasis->where('tanggal', date('Y-m-d'))->count() }}</span> donasi</p>
            </div>
        </div>

        <div class="p-6">
            <!-- Form Input Donasi -->
            <form action="{{ route('admin.penerimaan-donasi.store') }}" method="POST" class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-200">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Donasi</label>
                        <select name="jenis" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                            <option value="zakat">Zakat Fitrah / Mal</option>
                            <option value="infak">Infak / Sedekah</option>
                            <option value="wakaf">Wakaf</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Cara Bayar</label>
                        <select name="cara_bayar" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                            <option value="tunai">Tunai</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="barang">Barang</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Donatur (opsional)</label>
                        <select name="kode_donatur"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                            <option value="">- Umum / Tidak diketahui -</option>
                            @foreach(\App\Models\Donatur::orderBy('nama')->get() as $d)
                                <option value="{{ $d->kode_donatur }}">{{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" required min="1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm font-medium">
                    </div>

                    <div class="md:col-span-2 lg:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                        <textarea name="keterangan" rows="2" required placeholder="Donasi dari Bapak Ahmad untuk operasional"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-4">
                    <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan & Buat Jurnal
                    </button>
                </div>
            </form>

            <!-- Filter & Riwayat -->
            <div x-data="{ 
                filterJenis: '{{ request('jenis') }}', 
                filterCara: '{{ request('cara') }}', 
                filterTglDari: '{{ request('dari') }}', 
                filterTglSampai: '{{ request('sampai') }}'
            }" class="space-y-6">

                <!-- Filter -->
                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                    <h3 class="text-base font-medium text-gray-800 mb-4">Filter Riwayat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="text-xs text-gray-600">Jenis</label>
                            <select x-model="filterJenis" @change="$dispatch('filter-changed')"
                                    class="w-full mt-1 px-3 py-1.5 border border-gray-300 rounded-lg text-sm">
                                <option value="">Semua Jenis</option>
                                <option value="zakat">Zakat</option>
                                <option value="infak">Infak/Sedekah</option>
                                <option value="wakaf">Wakaf</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-gray-600">Cara Bayar</label>
                            <select x-model="filterCara" @change="$dispatch('filter-changed')"
                                    class="w-full mt-1 px-3 py-1.5 border border-gray-300 rounded-lg text-sm">
                                <option value="">Semua Cara</option>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer</option>
                                <option value="barang">Barang</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-gray-600">Dari Tanggal</label>
                            <input type="date" x-model="filterTglDari" @change="$dispatch('filter-changed')"
                                   class="w-full mt-1 px-3 py-1.5 border border-gray-300 rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="text-xs text-gray-600">Sampai Tanggal</label>
                            <input type="date" x-model="filterTglSampai" @change="$dispatch('filter-changed')"
                                   class="w-full mt-1 px-3 py-1.5 border border-gray-300 rounded-lg text-sm">
                        </div>
                    </div>
                </div>

                <!-- Tabel Riwayat -->
                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">Tanggal</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">Jenis</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">Donatur</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-600 uppercase">Jumlah</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">Cara</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-600 uppercase">User</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($donasis as $d)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-5 py-3 text-sm">{{ $d->tanggal->translatedFormat('d M Y') }}</td>
                                    <td class="px-5 py-3">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                            {{ $d->jenis == 'zakat' ? 'bg-yellow-100 text-yellow-800' :
                                               ($d->jenis == 'wakaf' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($d->jenis) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-sm">{{ $d->donatur?->nama ?? 'Umum' }}</td>
                                    <td class="px-5 py-3 text-right text-sm font-bold text-green-700">
                                        Rp {{ number_format($d->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-3 text-sm">
                                        <span class="text-xs font-medium {{ $d->cara_bayar == 'tunai' ? 'text-green-600' : 'text-blue-600' }}">
                                            {{ ucfirst($d->cara_bayar) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-xs text-gray-600">{{ $d->user->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-10 text-sm text-gray-500">
                                        Belum ada data donasi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4 flex justify-center">
                    {{ $donasis->appends(request()->query())->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    document.addEventListener('filter-changed', () => {
        const params = new URLSearchParams();
        if (Alpine.store('filterJenis')) params.append('jenis', Alpine.store('filterJenis'));
        if (Alpine.store('filterCara')) params.append('cara', Alpine.store('filterCara'));
        if (Alpine.store('filterTglDari')) params.append('dari', Alpine.store('filterTglDari'));
        if (Alpine.store('filterTglSampai')) params.append('sampai', Alpine.store('filterTglSampai'));

        window.location = `?${params.toString()}`;
    });
});
</script>
@endsection