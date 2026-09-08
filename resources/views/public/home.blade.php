@extends('layouts.public')

@section('title', 'Beranda - PAM Pesantunan')

@section('content')
<!-- ==================== HERO SECTION ==================== -->
<section class="relative min-h-screen flex items-center parallax-bg" style="background-image: url('{{ $identitas->logo ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuCnakXJDCpyj_j3jSikzZ6qxZy8K-I2f5-mqv-gVcOgwEr9lxSq1eUolZ6PpKUVKO2JBo50UR1jEDWwsTBFC91f9pO14EoGQuSbwtUNklRi6mroEyqifX7sfhS8PWwfas9KQ5rTKaC2auOf5lZ4vinzPDxI4gc2FtXhcjF1clmxYKFRTo4rhE0cr5mLG4Q8w6FY69hNn103ENZmu_t21qG8Cjyj4FaWKlENZ4JI01MrieJAVWp5yHL6' }}')">
    <div class="absolute inset-0 bg-gradient-to-r from-[#00522c]/80 to-transparent"></div>
    <div class="relative z-10 w-full px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto py-20 sm:py-24">
        <div class="max-w-3xl reveal">
            <span class="inline-block px-4 sm:px-5 py-1.5 bg-primary-fixed/90 text-[#00522c] rounded-full font-dancing text-base sm:text-lg shadow-sm float-animation">
                ✦ Lembaga Terpercaya ✦
            </span>
            
            <h1 class="font-playfair text-3xl sm:text-4xl md:text-5xl lg:text-[56px] leading-tight mb-3 sm:mb-4 text-shadow text-on-primary mt-3">
                Membangun Masa Depan Bersama 
                <span class="text-gradient-gold font-playfair italic">Panti Asuhan</span>
                <br>
                <span class="font-dancing text-4xl sm:text-5xl md:text-6xl lg:text-[64px] text-on-primary" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                    {{ $identitas->nama_panti ?? 'Muhammadiyah Pesantunan' }}
                </span>
            </h1>
            
            <p class="font-dm-serif text-base sm:text-lg md:text-xl text-surface-container-low mb-4 sm:mb-6 text-shadow-light leading-relaxed">
                "{{ $identitas->tagline ?? 'Amanah, Transparan, dan Mandiri dengan Integrasi Kas Digital untuk memastikan setiap donasi Anda tepat sasaran.' }}"
            </p>
            
            <div class="decorative-line-gold mb-5 sm:mb-6"></div>
            
            <div class="flex flex-wrap gap-3 sm:gap-4">
                <a href="{{ route('donation') }}" class="px-6 sm:px-8 md:px-10 py-3 sm:py-4 bg-gradient-to-r from-[#006d3c] to-[#00a859] text-on-primary rounded-full font-jakarta font-semibold text-sm sm:text-base hover:shadow-lg transition-all flex items-center gap-2 pulse-glow">
                    <span class="material-symbols-outlined text-sm">volunteer_activism</span>
                    Mulai Donasi
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
                <a href="{{ route('about') }}" class="px-6 sm:px-8 md:px-10 py-3 sm:py-4 bg-surface/20 backdrop-blur-sm text-on-primary border border-on-primary/30 rounded-full font-jakarta font-medium text-sm sm:text-base hover:bg-surface/30 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">info</span>
                    Lihat Program Kami
                </a>
            </div>
            
            <p class="font-great-vibes text-2xl sm:text-3xl text-on-primary/70 mt-6 sm:mt-8">
                "{{ $identitas->quote ?? 'Berbagi untuk masa depan yang lebih cerah' }}"
            </p>
        </div>
    </div>
</section>

<!-- ==================== KAS DIGITAL PREVIEW ==================== -->
<section class="py-10 sm:py-14 md:py-18 lg:py-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 bg-surface-container-lowest relative z-20 -mt-6 sm:-mt-10 md:-mt-16 lg:-mt-20 rounded-t-2xl sm:rounded-t-3xl shadow-[0_-10px_40px_rgba(0,0,0,0.05)]">
    <div class="max-w-[1440px] mx-auto">
        <div class="text-center mb-8 sm:mb-12 lg:mb-16 reveal">
            <span class="font-dancing text-2xl sm:text-3xl text-gold-light inline-block mb-2">✦ Transparansi ✦</span>
            <h2 class="font-playfair text-2xl sm:text-3xl lg:text-[36px] text-on-surface mb-2 sm:mb-3">
                Finansial <span class="text-primary">Real-time</span>
            </h2>
            <div class="decorative-line mx-auto mb-3 sm:mb-4"></div>
            <p class="font-dm-serif text-base sm:text-lg text-on-surface-variant max-w-2xl mx-auto">
                Pantau aliran dana secara langsung melalui sistem kas digital terintegrasi kami, menjamin setiap rupiah dikelola dengan penuh amanah.
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6">
            <!-- Card 1: Total Donasi -->
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-7 soft-shadow hover-soft-shadow reveal border-t-4 border-secondary border border-outline-variant/30 group hover:bg-gradient-to-b hover:from-white hover:to-green-50 transition-all">
                <div class="flex items-center justify-between mb-3">
                    <span class="font-jakarta text-sm font-medium text-on-surface-variant">Total Donasi Bulan Ini</span>
                    <div class="w-10 h-10 rounded-full bg-secondary-fixed flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
                    </div>
                </div>
                <div class="font-playfair text-2xl sm:text-3xl text-on-surface mb-1">
                    Rp {{ number_format($donasiBulanIni ?? 0, 0, ',', '.') }}
                </div>
                <div class="flex items-center gap-1 text-primary font-jakarta text-sm font-medium">
                    <span class="material-symbols-outlined text-sm">trending_up</span>
                    <span>Update real-time</span>
                </div>
            </div>

            <!-- Card 2: Anak Asuh -->
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-7 soft-shadow hover-soft-shadow reveal border-t-4 border-primary-container border border-outline-variant/30 group hover:bg-gradient-to-b hover:from-white hover:to-green-50 transition-all" style="transition-delay: 100ms;">
                <div class="flex items-center justify-between mb-3">
                    <span class="font-jakarta text-sm font-medium text-on-surface-variant">Anak Asuh Tersantuni</span>
                    <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-primary-container" style="font-variation-settings: 'FILL' 1;">group</span>
                    </div>
                </div>
                <div class="font-playfair text-2xl sm:text-3xl text-on-surface mb-1">
                    {{ $totalAnakAktif ?? 0 }} Anak
                </div>
                <div class="flex items-center gap-1 text-primary font-jakarta text-sm font-medium">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    <span>{{ $totalAnakLaki ?? 0 }} Laki-laki, {{ $totalAnakPerempuan ?? 0 }} Perempuan</span>
                </div>
            </div>

            <!-- Card 3: Aktivitas Terbaru -->
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-7 soft-shadow hover-soft-shadow reveal border border-outline-variant/30 sm:col-span-2 lg:col-span-1 group hover:bg-gradient-to-b hover:from-white hover:to-green-50 transition-all" style="transition-delay: 200ms;">
                <h3 class="font-jakarta font-semibold text-lg text-on-surface mb-3 flex justify-between items-center">
                    <span class="font-playfair">Aktivitas Terbaru</span>
                    <a href="{{ route('activities') }}" class="text-secondary font-jakarta text-sm font-medium cursor-pointer hover:underline">Lihat Semua</a>
                </h3>
                <div class="space-y-2">
                    @forelse($aktivitasTerbaru ?? [] as $log)
                        <div class="flex justify-between items-center py-2 border-b border-outline-variant/20">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-fixed/30 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-sm">
                                        {{ str_contains($log->description ?? '', 'donasi') ? 'arrow_downward' : 'arrow_upward' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-jakarta text-sm font-medium text-on-surface">{{ $log->causer?->name ?? 'System' }}</p>
                                    {{-- PERBAIKAN DI SINI: Menggunakan \Illuminate\Support\Str::limit --}}
                                    <p class="font-body-md text-xs text-on-surface-variant">{{ \Illuminate\Support\Str::limit($log->description ?? 'Aktivitas', 50) }}</p>
                                </div>
                            </div>
                            @if(isset($log->properties['attributes']['jumlah']))
                                <span class="font-jakarta text-sm font-semibold text-primary">
                                    +Rp {{ number_format($log->properties['attributes']['jumlah'], 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Belum ada aktivitas</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== PROGRAM KAMI ==================== -->
<section class="py-10 sm:py-14 md:py-18 lg:py-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">
    <div class="text-center mb-8 sm:mb-12 lg:mb-16 reveal">
        <span class="font-dancing text-2xl sm:text-3xl text-gold-light inline-block mb-2">✦ Program ✦</span>
        <h2 class="font-playfair text-2xl sm:text-3xl lg:text-[36px] text-on-surface mb-2 sm:mb-3">
            Unggulan <span class="text-primary">Kami</span>
        </h2>
        <div class="decorative-line mx-auto mb-3 sm:mb-4"></div>
        <p class="font-dm-serif text-base sm:text-lg text-on-surface-variant max-w-2xl mx-auto">
            Berbagai program yang kami jalankan untuk memberikan manfaat terbaik bagi anak-anak asuh.
        </p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6">
        @php
            $programs = [
                ['icon' => 'menu_book', 'title' => 'Pendidikan Berkualitas', 'desc' => 'Menyediakan akses pendidikan formal dan non-formal untuk anak asuh.'],
                ['icon' => 'favorite', 'title' => 'Pengasuhan Holistik', 'desc' => 'Pengasuhan yang memperhatikan aspek fisik, mental, dan spiritual anak.'],
                ['icon' => 'handshake', 'title' => 'Kemandirian Ekonomi', 'desc' => 'Melatih keterampilan untuk bekal hidup mandiri di masa depan.']
            ];
        @endphp
        @foreach($programs as $index => $program)
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow hover-soft-shadow reveal text-center group hover:bg-gradient-to-b hover:from-white hover:to-green-50 transition-all" style="transition-delay: {{ $index * 100 }}ms;">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-primary-fixed/30 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-primary text-3xl sm:text-4xl">{{ $program['icon'] }}</span>
                </div>
                <h3 class="font-playfair text-lg sm:text-xl text-on-surface mb-2">{{ $program['title'] }}</h3>
                <p class="font-jakarta text-sm sm:text-base text-on-surface-variant">{{ $program['desc'] }}</p>
            </div>
        @endforeach
    </div>
</section>

<!-- ==================== PENGURUS PANTI (Preview) ==================== -->
<section class="py-10 sm:py-14 md:py-18 lg:py-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto bg-surface-container-low">
    <div class="max-w-[1440px] mx-auto">
        <div class="text-center mb-8 sm:mb-12 lg:mb-16 reveal">
            <span class="font-dancing text-2xl sm:text-3xl text-gold-light inline-block mb-2">✦ Pengurus ✦</span>
            <h2 class="font-playfair text-2xl sm:text-3xl lg:text-[36px] text-on-surface mb-2 sm:mb-3">
                Struktur <span class="text-primary">Pengurus</span>
            </h2>
            <div class="decorative-line mx-auto mb-3 sm:mb-4"></div>
            <p class="font-dm-serif text-base sm:text-lg text-on-surface-variant max-w-2xl mx-auto">
                Diperankan oleh para profesional yang berdedikasi untuk memberikan pelayanan terbaik bagi anak-anak asuh.
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-5 lg:gap-6">
            @forelse($pengurusPreview ?? [] as $item)
                <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-7 soft-shadow hover-soft-shadow reveal text-center group hover:bg-gradient-to-b hover:from-white hover:to-green-50 transition-all">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-full overflow-hidden mb-3 border-2 border-primary-fixed-dim group-hover:border-primary transition-colors">
                        @if(!empty($item->foto))
                            <img class="w-full h-full object-cover" src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}">
                        @else
                            <div class="w-full h-full bg-primary-fixed/20 flex items-center justify-center text-2xl sm:text-3xl text-primary font-bold">
                                {{ $item->nama[0] ?? '?' }}
                            </div>
                        @endif
                    </div>
                    <h3 class="font-playfair text-lg sm:text-xl text-on-surface">{{ $item->nama ?? '-' }}</h3>
                    <p class="font-jakarta text-sm text-primary font-medium">{{ $item->jabatan ?? '-' }}</p>
                    <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant mt-2 line-clamp-2">{{ $item->deskripsi ?? '' }}</p>
                </div>
            @empty
                <div class="col-span-full text-center text-on-surface-variant py-8">
                    <p>Belum ada data pengurus.</p>
                </div>
            @endforelse
        </div>
        
        <div class="text-center mt-6 sm:mt-8 reveal">
            <a href="{{ route('about') }}" class="inline-flex items-center gap-2 px-6 py-2.5 border border-primary text-primary rounded-full font-jakarta text-sm hover:bg-primary hover:text-white transition-all">
                Lihat Semua Pengurus
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>
    </div>
</section>

<!-- ==================== TESTIMONI ==================== -->
<section class="py-10 sm:py-14 md:py-18 lg:py-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 bg-gradient-to-b from-surface-container-low to-white">
    <div class="max-w-[1440px] mx-auto">
        <div class="text-center mb-8 sm:mb-12 lg:mb-16 reveal">
            <span class="font-dancing text-2xl sm:text-3xl text-gold-light inline-block mb-2">✦ Testimoni ✦</span>
            <h2 class="font-playfair text-2xl sm:text-3xl lg:text-[36px] text-on-surface mb-2 sm:mb-3">
                Apa Kata <span class="text-primary">Mereka</span>
            </h2>
            <div class="decorative-line mx-auto mb-3 sm:mb-4"></div>
            <p class="font-dm-serif text-base sm:text-lg text-on-surface-variant max-w-2xl mx-auto">
                Testimoni dari para donatur dan mitra yang telah mendukung perjalanan kami.
            </p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6">
            @php
                $testimonis = [
                    ['name' => 'Bapak Ahmad', 'role' => 'Donatur Tetap', 'text' => 'Saya sangat percaya dengan transparansi yang diterapkan PAM Pesantunan. Setiap donasi terlihat jelas penyalurannya.', 'initial' => 'B'],
                    ['name' => 'Ibu Siti', 'role' => 'Relawan', 'text' => 'Melihat senyum anak-anak asuh adalah kebahagiaan tersendiri. Semoga PAM Pesantunan terus berkembang.', 'initial' => 'S'],
                    ['name' => 'PT. Maju Jaya', 'role' => 'Mitra Perusahaan', 'text' => 'Program CSR kami bersama PAM Pesantunan berjalan dengan sangat baik dan terukur.', 'initial' => 'M']
                ];
            @endphp
            @foreach($testimonis as $index => $item)
                <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow reveal hover:shadow-xl transition-shadow" style="transition-delay: {{ $index * 100 }}ms;">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary-fixed/40 flex items-center justify-center text-primary font-playfair text-lg sm:text-xl font-bold">{{ $item['initial'] }}</div>
                        <div>
                            <p class="font-jakarta font-semibold text-sm sm:text-base text-on-surface">{{ $item['name'] }}</p>
                            <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant">{{ $item['role'] }}</p>
                        </div>
                    </div>
                    <p class="font-instrument text-base sm:text-lg text-on-surface-variant italic leading-relaxed">
                        "{{ $item['text'] }}"
                    </p>
                    <div class="mt-2 text-gold-light">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="material-symbols-outlined text-sm">star</span>
                        @endfor
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ==================== CTA DONASI ==================== -->
<section class="py-10 sm:py-14 md:py-18 lg:py-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">
    <div class="bg-gradient-to-r from-[#006d3c] to-[#00a859] rounded-2xl p-6 sm:p-8 md:p-10 lg:p-14 xl:p-16 text-center text-on-primary relative overflow-hidden">
        <div class="absolute top-0 right-0 opacity-10">
            <span class="material-symbols-outlined text-[120px] sm:text-[150px] md:text-[200px]">volunteer_activism</span>
        </div>
        <div class="absolute bottom-0 left-0 opacity-5">
            <span class="material-symbols-outlined text-[100px] sm:text-[150px]">mosque</span>
        </div>
        <div class="relative z-10 max-w-2xl mx-auto reveal">
            <span class="font-dancing text-2xl sm:text-3xl inline-block mb-2">✦ Berbagi Kasih ✦</span>
            <h2 class="font-playfair text-2xl sm:text-3xl lg:text-[36px] mb-2 sm:mb-3">
                Siap Membantu Masa Depan Mereka?
            </h2>
            <p class="font-dm-serif text-base sm:text-lg mb-4 sm:mb-6 opacity-90 leading-relaxed">
                "Setiap donasi Anda adalah investasi untuk masa depan anak-anak asuh yang lebih cerah."
            </p>
            <div class="decorative-line mx-auto mb-4 sm:mb-6" style="background: linear-gradient(90deg, #f6d365, #fda085);"></div>
            <a href="{{ route('donation') }}" class="inline-block px-8 sm:px-10 md:px-12 py-3 sm:py-4 bg-gradient-to-r from-[#f6d365] to-[#fda085] text-[#00522c] rounded-full font-jakarta font-bold text-sm sm:text-base hover:shadow-2xl transition-all transform hover:scale-105 shadow-lg">
                <span class="material-symbols-outlined align-middle text-sm">favorite</span>
                Donasi Sekarang
                <span class="material-symbols-outlined align-middle text-sm">arrow_forward</span>
            </a>
            <p class="font-great-vibes text-xl sm:text-2xl mt-4 sm:mt-6 text-on-primary/60">
                "Satu kebaikan, ribuan harapan"
            </p>
        </div>
    </div>
</section>
@endsection