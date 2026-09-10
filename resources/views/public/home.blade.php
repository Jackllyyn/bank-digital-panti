@extends('layouts.public')

@section('title', 'Beranda - PAM Pesantunan')

@section('content')

{{-- ==================== HERO ==================== --}}
<section class="relative min-h-[560px] md:min-h-[640px] flex items-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ $identitas->logo ?? 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1600' }}"
             alt="{{ $identitas->nama_panti ?? 'Panti Asuhan' }}"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-hero-overlay"></div>
    </div>

    <div class="relative z-10 w-full max-w-6xl mx-auto px-4 sm:px-6 md:px-8 py-20 md:py-28">
        <div class="max-w-2xl">
            <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm border border-white/20 text-white text-xs font-medium rounded-md mb-5 slide-in-left">
                <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span>
                Lembaga Sosial Terpercaya
            </span>

            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-[52px] font-extrabold leading-[1.1] text-white mb-4 slide-in-left" style="animation-delay: 0.1s;">
                Membangun Masa Depan
                <span class="text-green-400">Anak Yatim &amp; Dhuafa</span>
            </h1>

            <p class="text-base sm:text-lg text-gray-200 mb-8 leading-relaxed max-w-xl slide-in-left" style="animation-delay: 0.2s;">
                {{ $identitas->tagline ?? 'Amanah, transparan, dan mandiri. Setiap donasi Anda tercatat dan tersalurkan dengan tepat sasaran.' }}
            </p>

            <div class="flex flex-wrap gap-3 slide-in-left" style="animation-delay: 0.3s;">
                <a href="{{ route('donation') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-green-700 hover:bg-green-800 text-white rounded-lg font-semibold text-sm transition-all hover:shadow-lg hover:-translate-y-0.5">
                    <span class="material-symbols-outlined text-lg">volunteer_activism</span>
                    Donasi Sekarang
                </a>
                <a href="{{ route('about') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white border border-white/30 rounded-lg font-medium text-sm transition-colors">
                    <span class="material-symbols-outlined text-lg">info</span>
                    Tentang Kami
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ==================== STATISTIK ==================== --}}
<section class="relative z-20 -mt-12 md:-mt-16 px-4 sm:px-6 md:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-100">

            <div class="p-6 md:p-7 reveal">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-green-800">account_balance_wallet</span>
                    </div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Donasi Bulan Ini</p>
                </div>
                <p class="text-2xl md:text-3xl font-bold text-gray-900 tabular-nums">
                    Rp {{ number_format($donasiBulanIni ?? 0, 0, ',', '.') }}
                </p>
            </div>

            <div class="p-6 md:p-7 reveal" style="transition-delay: 0.1s;">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-green-800">group</span>
                    </div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Anak Asuh</p>
                </div>
                <p class="text-2xl md:text-3xl font-bold text-gray-900">
                    {{ $totalAnakAktif ?? 0 }} Anak
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    {{ $totalAnakLaki ?? 0 }}L · {{ $totalAnakPerempuan ?? 0 }}P
                </p>
            </div>

            <div class="p-6 md:p-7 reveal" style="transition-delay: 0.2s;">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                        <span class="material-symbols-outlined text-green-800">favorite</span>
                    </div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Donatur</p>
                </div>
                <p class="text-2xl md:text-3xl font-bold text-gray-900 tabular-nums">
                    {{ number_format($totalDonatur ?? 0, 0, ',', '.') }}
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ==================== TRANSPARANSI ==================== --}}
<section class="py-16 md:py-24 px-4 sm:px-6 md:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12 reveal">
            <p class="text-sm font-medium text-green-800 mb-2 uppercase tracking-wide">Transparansi</p>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                Laporan Keuangan Real-time
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Pantau aliran dana secara langsung. Setiap rupiah tercatat dengan penuh amanah.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-gray-200 rounded-xl p-6 md:p-7 hover-soft-shadow transition-all reveal">
                <p class="text-sm text-gray-500 mb-3">Penerimaan Bulan Ini</p>
                <p class="text-2xl md:text-3xl font-bold text-green-700 tabular-nums mb-2">
                    Rp {{ number_format($donasiBulanIni ?? 0, 0, ',', '.') }}
                </p>
                <div class="flex items-center gap-1 text-xs text-gray-500">
                    <span class="material-symbols-outlined text-sm">trending_up</span>
                    <span>Update real-time</span>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 md:p-7 hover-soft-shadow transition-all reveal" style="transition-delay: 0.1s;">
                <p class="text-sm text-gray-500 mb-3">Pengeluaran Bulan Ini</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-900 tabular-nums mb-2">
                    Rp {{ number_format($pengeluaranBulanIni ?? 0, 0, ',', '.') }}
                </p>
                <div class="flex items-center gap-1 text-xs text-gray-500">
                    <span class="material-symbols-outlined text-sm">receipt_long</span>
                    <span>Operasional panti</span>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-6 md:p-7 hover-soft-shadow transition-all reveal" style="transition-delay: 0.2s;">
                <p class="text-sm text-gray-500 mb-3">Saldo Bulan Ini</p>
                <p class="text-2xl md:text-3xl font-bold {{ ($surplusBulanIni ?? 0) >= 0 ? 'text-green-700' : 'text-red-700' }} tabular-nums mb-2">
                    Rp {{ number_format($surplusBulanIni ?? 0, 0, ',', '.') }}
                </p>
                <div class="flex items-center gap-1 text-xs text-gray-500">
                    <span class="material-symbols-outlined text-sm">{{ ($surplusBulanIni ?? 0) >= 0 ? 'check_circle' : 'warning' }}</span>
                    <span>{{ ($surplusBulanIni ?? 0) >= 0 ? 'Surplus' : 'Defisit' }}</span>
                </div>
            </div>
        </div>

        <div class="text-center mt-8 reveal">
            <a href="{{ route('transparansi') }}"
               class="inline-flex items-center gap-2 text-green-800 font-medium hover:gap-3 transition-all">
                Lihat Laporan Lengkap
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>
    </div>
</section>

{{-- ==================== PROGRAM ==================== --}}
<section class="py-16 md:py-24 px-4 sm:px-6 md:px-8 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12 reveal">
            <p class="text-sm font-medium text-green-800 mb-2 uppercase tracking-wide">Program</p>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                Program Unggulan Kami
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Berbagai program untuk memberikan manfaat terbaik bagi anak-anak asuh.
            </p>
        </div>

        @php
            $programs = [
                ['icon' => 'menu_book', 'title' => 'Pendidikan Berkualitas', 'desc' => 'Menyediakan akses pendidikan formal dan non-formal untuk anak asuh.'],
                ['icon' => 'favorite',  'title' => 'Pengasuhan Holistik',    'desc' => 'Pengasuhan yang memperhatikan aspek fisik, mental, dan spiritual anak.'],
                ['icon' => 'handshake', 'title' => 'Kemandirian Ekonomi',    'desc' => 'Melatih keterampilan untuk bekal hidup mandiri di masa depan.'],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($programs as $i => $program)
                <div class="bg-white border border-gray-200 rounded-xl p-7 hover-soft-shadow hover:border-green-700 transition-all reveal-scale"
                     style="transition-delay: {{ $i * 0.1 }}s;">
                    <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center mb-5">
                        <span class="material-symbols-outlined text-green-800 text-2xl">{{ $program['icon'] }}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $program['title'] }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $program['desc'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-10 reveal">
            <a href="{{ route('programs') }}"
               class="inline-flex items-center gap-2 text-green-800 font-medium hover:gap-3 transition-all">
                Lihat Semua Program
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>
    </div>
</section>

{{-- ==================== PENGURUS ==================== --}}
@if(isset($pengurusPreview) && $pengurusPreview->count() > 0)
<section class="py-16 md:py-24 px-4 sm:px-6 md:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12 reveal">
            <p class="text-sm font-medium text-green-800 mb-2 uppercase tracking-wide">Pengurus</p>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                Struktur Pengurus
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Diperankan oleh para profesional yang berdedikasi untuk pelayanan terbaik.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($pengurusPreview as $i => $item)
                <div class="bg-white border border-gray-200 rounded-xl p-7 text-center hover-soft-shadow transition-all reveal-scale"
                     style="transition-delay: {{ $i * 0.1 }}s;">
                    <div class="w-20 h-20 mx-auto rounded-full overflow-hidden mb-4 bg-gray-100 ring-4 ring-green-50">
                        @if(!empty($item->foto))
                            <img class="w-full h-full object-cover" src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xl text-gray-500 font-medium">
                                {{ $item->nama[0] ?? '?' }}
                            </div>
                        @endif
                    </div>
                    <h3 class="font-semibold text-gray-900">{{ $item->nama }}</h3>
                    <p class="text-sm text-green-800 font-medium mt-1">{{ $item->jabatan }}</p>
                    @if(!empty($item->deskripsi))
                        <p class="text-xs text-gray-500 mt-3 line-clamp-2 leading-relaxed">{{ $item->deskripsi }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="text-center mt-10 reveal">
            <a href="{{ route('about') }}"
               class="inline-flex items-center gap-2 text-green-800 font-medium hover:gap-3 transition-all">
                Lihat Semua Pengurus
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ==================== CTA DONASI ==================== --}}
<section class="px-4 sm:px-6 md:px-8 pb-16 md:pb-24">
    <div class="max-w-6xl mx-auto">
        <div class="relative bg-green-800 rounded-2xl overflow-hidden reveal-scale">
            <div class="absolute inset-0 opacity-[0.08]">
                <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-white"></div>
                <div class="absolute -bottom-20 -left-10 w-72 h-72 rounded-full bg-white"></div>
            </div>

            <div class="relative px-6 py-14 md:px-16 md:py-20 text-center">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-4">
                    Bantu Masa Depan Anak-Anak Kami
                </h2>
                <p class="text-green-100 mb-8 max-w-xl mx-auto text-base leading-relaxed">
                    Setiap donasi Anda tercatat dan tersalurkan dengan transparan. Satu kebaikan, ribuan harapan.
                </p>
                <a href="{{ route('donation') }}"
                   class="inline-flex items-center gap-2 px-8 py-4 bg-white text-green-800 rounded-lg font-semibold hover:bg-gray-100 transition-all hover:shadow-xl hover:-translate-y-0.5 pulse-soft">
                    <span class="material-symbols-outlined">favorite</span>
                    Donasi Sekarang
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection