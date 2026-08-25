@extends('layouts.public')

@section('title', 'Beranda - PAM Pesantunan')

@section('content')
<!-- ==================== HERO SECTION ==================== -->
<section class="relative min-h-screen flex items-center parallax-bg" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCnakXJDCpyj_j3jSikzZ6qxZy8K-I2f5-mqv-gVcOgwEr9lxSq1eUolZ6PpKUVKO2JBo50UR1jEDWwsTBFC91f9pO14EoGQuSbwtUNklRi6mroEyqifX7sfhS8PWwfas9KQ5rTKaC2auOf5lZ4vinzPDxI4gc2FtXhcjF1clmxYKFRTo4rhE0cr5mLG4Q8w6FY69hNn103ENZmu_t21qG8Cjyj4FaWKlENZ4JI01MrieJAVWp5yHL6')">
    <div class="absolute inset-0 bg-gradient-to-r from-[#00522c]/80 to-transparent"></div>
    <div class="relative z-10 w-full px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto py-20 sm:py-24">
        <div class="max-w-3xl reveal">
            <!-- Badge dengan font elegant -->
            <span class="inline-block px-4 sm:px-5 py-1.5 bg-primary-fixed/90 text-[#00522c] rounded-full font-dancing text-base sm:text-lg shadow-sm float-animation">
                ✦ Lembaga Terpercaya ✦
            </span>
            
            <!-- Heading dengan Playfair Display -->
            <h1 class="font-playfair text-3xl sm:text-4xl md:text-5xl lg:text-[56px] leading-tight mb-3 sm:mb-4 text-shadow text-on-primary mt-3">
                Membangun Masa Depan Bersama 
                <span class="text-gradient-gold font-playfair italic">Panti Asuhan</span>
                <br>
                <span class="font-dancing text-4xl sm:text-5xl md:text-6xl lg:text-[64px] text-on-primary" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                    Muhammadiyah Pesantunan
                </span>
            </h1>
            
            <!-- Subtitle dengan DM Serif Display -->
            <p class="font-dm-serif text-base sm:text-lg md:text-xl text-surface-container-low mb-4 sm:mb-6 text-shadow-light leading-relaxed">
                "Amanah, Transparan, dan Mandiri dengan Integrasi Kas Digital untuk memastikan setiap donasi Anda tepat sasaran."
            </p>
            
            <!-- Decorative line -->
            <div class="decorative-line-gold mb-5 sm:mb-6"></div>
            
            <!-- Buttons -->
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
            
            <!-- Quote dengan Great Vibes -->
            <p class="font-great-vibes text-2xl sm:text-3xl text-on-primary/70 mt-6 sm:mt-8">
                "Berbagi untuk masa depan yang lebih cerah"
            </p>
        </div>
    </div>
</section>

<!-- ==================== KAS DIGITAL PREVIEW ==================== -->
<section class="py-10 sm:py-14 md:py-18 lg:py-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 bg-surface-container-lowest relative z-20 -mt-6 sm:-mt-10 md:-mt-16 lg:-mt-20 rounded-t-2xl sm:rounded-t-3xl shadow-[0_-10px_40px_rgba(0,0,0,0.05)]">
    <div class="max-w-[1440px] mx-auto">
        <div class="text-center mb-8 sm:mb-12 lg:mb-16 reveal">
            <!-- Subtitle dengan Dancing Script -->
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
            <!-- Card 1 -->
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-7 soft-shadow hover-soft-shadow reveal border-t-4 border-secondary border border-outline-variant/30 group hover:bg-gradient-to-b hover:from-white hover:to-green-50 transition-all">
                <div class="flex items-center justify-between mb-3">
                    <span class="font-jakarta text-sm font-medium text-on-surface-variant">Total Donasi Bulan Ini</span>
                    <div class="w-10 h-10 rounded-full bg-secondary-fixed flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
                    </div>
                </div>
                <div class="font-playfair text-2xl sm:text-3xl text-on-surface mb-1">Rp 45.500.000</div>
                <div class="flex items-center gap-1 text-primary font-jakarta text-sm font-medium">
                    <span class="material-symbols-outlined text-sm">trending_up</span>
                    <span>+12% dari bulan lalu</span>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-7 soft-shadow hover-soft-shadow reveal border-t-4 border-primary-container border border-outline-variant/30 group hover:bg-gradient-to-b hover:from-white hover:to-green-50 transition-all" style="transition-delay: 100ms;">
                <div class="flex items-center justify-between mb-3">
                    <span class="font-jakarta text-sm font-medium text-on-surface-variant">Anak Asuh Tersantuni</span>
                    <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-primary-container" style="font-variation-settings: 'FILL' 1;">group</span>
                    </div>
                </div>
                <div class="font-playfair text-2xl sm:text-3xl text-on-surface mb-1">124 Anak</div>
                <div class="flex items-center gap-1 text-primary font-jakarta text-sm font-medium">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    <span>Target 100% tercapai</span>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-7 soft-shadow hover-soft-shadow reveal border border-outline-variant/30 sm:col-span-2 lg:col-span-1 group hover:bg-gradient-to-b hover:from-white hover:to-green-50 transition-all" style="transition-delay: 200ms;">
                <h3 class="font-jakarta font-semibold text-lg text-on-surface mb-3 flex justify-between items-center">
                    <span class="font-playfair">Aktivitas Terbaru</span>
                    <span class="text-secondary font-jakarta text-sm font-medium cursor-pointer hover:underline">Lihat Semua</span>
                </h3>
                <div class="space-y-2">
                    <div class="flex justify-between items-center py-2 border-b border-outline-variant/20">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary-fixed/30 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary text-sm">arrow_downward</span>
                            </div>
                            <div>
                                <p class="font-jakarta text-sm font-medium text-on-surface">Hamba Allah</p>
                                <p class="font-body-md text-xs text-on-surface-variant">Donasi Pendidikan</p>
                            </div>
                        </div>
                        <span class="font-jakarta text-sm font-semibold text-primary">+Rp 500.000</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-outline-variant/20">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="w-8 h-8 rounded-full bg-surface-variant flex items-center justify-center">
                                <span class="material-symbols-outlined text-on-surface-variant text-sm">arrow_upward</span>
                            </div>
                            <div>
                                <p class="font-jakarta text-sm font-medium text-on-surface">Operasional</p>
                                <p class="font-body-md text-xs text-on-surface-variant">Pembelian Sembako</p>
                            </div>
                        </div>
                        <span class="font-jakarta text-sm font-medium text-on-surface-variant">-Rp 1.200.000</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary-fixed/30 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary text-sm">arrow_downward</span>
                            </div>
                            <div>
                                <p class="font-jakarta text-sm font-medium text-on-surface">PT. Maju Bersama</p>
                                <p class="font-body-md text-xs text-on-surface-variant">Zakat Perusahaan</p>
                            </div>
                        </div>
                        <span class="font-jakarta text-sm font-semibold text-primary">+Rp 5.000.000</span>
                    </div>
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
        <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow hover-soft-shadow reveal text-center group hover:bg-gradient-to-b hover:from-white hover:to-green-50 transition-all">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-primary-fixed/30 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-primary text-3xl sm:text-4xl">menu_book</span>
            </div>
            <h3 class="font-playfair text-lg sm:text-xl text-on-surface mb-2">Pendidikan Berkualitas</h3>
            <p class="font-jakarta text-sm sm:text-base text-on-surface-variant">Menyediakan akses pendidikan formal dan non-formal untuk anak asuh.</p>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow hover-soft-shadow reveal text-center group hover:bg-gradient-to-b hover:from-white hover:to-green-50 transition-all" style="transition-delay: 100ms;">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-secondary-fixed/30 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-secondary text-3xl sm:text-4xl">favorite</span>
            </div>
            <h3 class="font-playfair text-lg sm:text-xl text-on-surface mb-2">Pengasuhan Holistik</h3>
            <p class="font-jakarta text-sm sm:text-base text-on-surface-variant">Pengasuhan yang memperhatikan aspek fisik, mental, dan spiritual anak.</p>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow hover-soft-shadow reveal text-center group hover:bg-gradient-to-b hover:from-white hover:to-green-50 transition-all" style="transition-delay: 200ms;">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-tertiary-container/30 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-tertiary text-3xl sm:text-4xl">handshake</span>
            </div>
            <h3 class="font-playfair text-lg sm:text-xl text-on-surface mb-2">Kemandirian Ekonomi</h3>
            <p class="font-jakarta text-sm sm:text-base text-on-surface-variant">Melatih keterampilan untuk bekal hidup mandiri di masa depan.</p>
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
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow reveal hover:shadow-xl transition-shadow">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary-fixed/40 flex items-center justify-center text-primary font-playfair text-lg sm:text-xl font-bold">B</div>
                    <div>
                        <p class="font-jakarta font-semibold text-sm sm:text-base text-on-surface">Bapak Ahmad</p>
                        <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant">Donatur Tetap</p>
                    </div>
                </div>
                <p class="font-instrument text-base sm:text-lg text-on-surface-variant italic leading-relaxed">
                    "Saya sangat percaya dengan transparansi yang diterapkan PAM Pesantunan. Setiap donasi terlihat jelas penyalurannya."
                </p>
                <div class="mt-2 text-gold-light">
                    <span class="material-symbols-outlined text-sm">star</span>
                    <span class="material-symbols-outlined text-sm">star</span>
                    <span class="material-symbols-outlined text-sm">star</span>
                    <span class="material-symbols-outlined text-sm">star</span>
                    <span class="material-symbols-outlined text-sm">star</span>
                </div>
            </div>
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow reveal hover:shadow-xl transition-shadow" style="transition-delay: 100ms;">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-secondary-fixed/40 flex items-center justify-center text-secondary font-playfair text-lg sm:text-xl font-bold">S</div>
                    <div>
                        <p class="font-jakarta font-semibold text-sm sm:text-base text-on-surface">Ibu Siti</p>
                        <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant">Relawan</p>
                    </div>
                </div>
                <p class="font-instrument text-base sm:text-lg text-on-surface-variant italic leading-relaxed">
                    "Melihat senyum anak-anak asuh adalah kebahagiaan tersendiri. Semoga PAM Pesantunan terus berkembang."
                </p>
                <div class="mt-2 text-gold-light">
                    <span class="material-symbols-outlined text-sm">star</span>
                    <span class="material-symbols-outlined text-sm">star</span>
                    <span class="material-symbols-outlined text-sm">star</span>
                    <span class="material-symbols-outlined text-sm">star</span>
                    <span class="material-symbols-outlined text-sm">star</span>
                </div>
            </div>
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow reveal hover:shadow-xl transition-shadow" style="transition-delay: 200ms;">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-tertiary-container/40 flex items-center justify-center text-tertiary font-playfair text-lg sm:text-xl font-bold">M</div>
                    <div>
                        <p class="font-jakarta font-semibold text-sm sm:text-base text-on-surface">PT. Maju Jaya</p>
                        <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant">Mitra Perusahaan</p>
                    </div>
                </div>
                <p class="font-instrument text-base sm:text-lg text-on-surface-variant italic leading-relaxed">
                    "Program CSR kami bersama PAM Pesantunan berjalan dengan sangat baik dan terukur."
                </p>
                <div class="mt-2 text-gold-light">
                    <span class="material-symbols-outlined text-sm">star</span>
                    <span class="material-symbols-outlined text-sm">star</span>
                    <span class="material-symbols-outlined text-sm">star</span>
                    <span class="material-symbols-outlined text-sm">star</span>
                    <span class="material-symbols-outlined text-sm">star</span>
                </div>
            </div>
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