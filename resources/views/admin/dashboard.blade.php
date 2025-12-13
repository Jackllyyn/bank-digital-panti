@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="space-y-6">
        <!-- Header & Selamat Datang -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">
                        Selamat Datang, {{ auth()->user()->name }}
                    </h1>
                    <p class="text-gray-600 text-sm mt-1">
                        {{ $identitas->nama_panti ?? 'Panti Asuhan' }} • {{ $identitas->alamat ?? '' }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Tahun {{ date('Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Statistik Utama (4 Kartu Kecil) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 text-center">
                <p class="text-sm text-gray-600">Donasi Bulan Ini</p>
                <p class="text-xl font-bold text-green-700 mt-2">
                    Rp {{ number_format($donasiBulanIni, 0, ',', '.') }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 text-center">
                <p class="text-sm text-gray-600">Pengeluaran Bulan Ini</p>
                <p class="text-xl font-bold text-red-700 mt-2">
                    Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 text-center">
                <p class="text-sm text-gray-600">Surplus/Defisit</p>
                <p class="text-xl font-bold {{ $surplusBulanIni >= 0 ? 'text-green-700' : 'text-red-700' }} mt-2">
                    Rp {{ number_format(abs($surplusBulanIni), 0, ',', '.') }}
                    <span class="text-xs font-normal">{{ $surplusBulanIni >= 0 ? '(Surplus)' : '(Defisit)' }}</span>
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 text-center">
                <p class="text-sm text-gray-600">Anak Asuh Aktif</p>
                <p class="text-xl font-bold text-indigo-700 mt-2">
                    {{ $totalAnakAktif }}
                </p>
            </div>
        </div>

        <!-- Anak Asuh - Laki-laki & Perempuan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <i class="fas fa-male text-4xl text-blue-600 mb-3"></i>
                <p class="text-sm text-gray-600">Laki-laki</p>
                <p class="text-3xl font-bold text-blue-700 mt-2">
                    {{ AnakPanti::where('status', 'aktif')->where('jenis_kelamin', 'L')->count() }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <i class="fas fa-female text-4xl text-pink-600 mb-3"></i>
                <p class="text-sm text-gray-600">Perempuan</p>
                <p class="text-3xl font-bold text-pink-700 mt-2">
                    {{ AnakPanti::where('status', 'aktif')->where('jenis_kelamin', 'P')->count() }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <i class="fas fa-users text-4xl text-indigo-600 mb-3"></i>
                <p class="text-sm text-gray-600">Total Anak Asuh</p>
                <p class="text-3xl font-bold text-indigo-700 mt-2">
                    {{ $totalAnakAktif }}
                </p>
            </div>
        </div>

        <!-- Grafik Donasi vs Pengeluaran (kecil & rapi) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Donasi vs Pengeluaran (6 Bulan Terakhir)</h2>
            <canvas id="donasiPengeluaranChart" height="140"></canvas>
        </div>

        <!-- Aktivitas Terakhir (compact) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terakhir</h2>
            <div class="space-y-3">
                @forelse($aktivitasTerakhir as $log)
                    <div class="flex items-start gap-4 text-sm">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 text-sm">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium">{{ $log->causer?->name ?? 'System' }}</p>
                            <p class="text-gray-600">{{ $log->description }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $log->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-6">Belum ada aktivitas</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('donasiPengeluaranChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($grafik->pluck('bulan')),
            datasets: [
                {
                    label: 'Donasi',
                    data: @json($grafik->pluck('donasi')),
                    backgroundColor: '#10b981',
                    borderColor: '#059669',
                    borderWidth: 1
                },
                {
                    label: 'Pengeluaran',
                    data: @json($grafik->pluck('pengeluaran')),
                    backgroundColor: '#ef4444',
                    borderColor: '#dc2626',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endsection