@extends('layouts.public')

@section('title', 'Tentang Kami - PAM Pesantunan')

@section('content')
<main class="pt-16 sm:pt-20 pb-10 sm:pb-14 md:pb-18 lg:pb-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">

    <section class="relative rounded-xl overflow-hidden mb-8 sm:mb-12 lg:mb-16 soft-shadow bg-surface-container-lowest h-[250px] sm:h-[300px] md:h-[400px] flex items-center justify-center">
        <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('{{ $identitas->logo ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuD5SCMLAjtu5lExzZXE2U5x9zT5XUV0nrgV046J2MatvF3XOpp0tVByOwS6JlEiCD2AZRfOkvBcwDYocgFpLshuCUw1zHbkoKQXsIIzqeyjz8vBJ8dwT6VBAqo9gBaxTns1fJYOFJ7t-otEaCdbX4TBQoCnkMTWmSa3W0kUyOcxOTWAFX_RGLkNm8JUt48dFzBMXRl-5gFmpUwdX6u3okGF07EbnEMrlwzbK8JVXYPt0g070Rc5A-nt' }}')"></div>
        <div class="relative z-10 text-center max-w-3xl px-4">
            <h1 class="font-display-lg text-3xl sm:text-4xl md:text-[48px] text-primary mb-2 sm:mb-3">Tentang Kami</h1>
            <p class="font-body-lg text-sm sm:text-base md:text-lg text-on-surface-variant px-2">{{ $identitas->nama_panti ?? 'Panti Asuhan Muhammadiyah Pesantunan' }} berkomitmen untuk memberikan pengasuhan yang amanah, pendidikan yang berkualitas, dan transparansi pengelolaan yang terpercaya.</p>
        </div>
    </section>

    <!-- Statistik Cepat -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 sm:mb-12 lg:mb-16 reveal">
        <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 text-center soft-shadow">
            <div class="font-playfair text-2xl sm:text-3xl text-primary">{{ number_format($totalDonasi ?? 0, 0, ',', '.') }}</div>
            <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant">Total Donasi</p>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 text-center soft-shadow reveal" style="transition-delay: 100ms;">
            <div class="font-playfair text-2xl sm:text-3xl text-primary">{{ $totalAnakAsuh ?? 0 }}</div>
            <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant">Anak Asuh</p>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 text-center soft-shadow reveal" style="transition-delay: 200ms;">
            <div class="font-playfair text-2xl sm:text-3xl text-primary">{{ $totalDonatur ?? 0 }}</div>
            <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant">Donatur</p>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 text-center soft-shadow reveal" style="transition-delay: 300ms;">
            <div class="font-playfair text-2xl sm:text-3xl text-primary">{{ date('Y') - 1985 }}</div>
            <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant">Tahun Berdiri</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 mb-8 sm:mb-12 lg:mb-16">
        <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow reveal">
            <div class="flex items-center gap-2 sm:gap-3 mb-3 text-primary">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">history_edu</span>
                <h2 class="font-headline-md text-xl sm:text-2xl">Sejarah Singkat</h2>
            </div>
            <p class="font-body-md text-sm sm:text-base text-on-surface-variant mb-3">Berdiri sejak tahun 1985, {{ $identitas->nama_panti ?? 'Panti Asuhan Muhammadiyah Pesantunan' }} lahir dari semangat kepedulian sosial umat. Dimulai dari sebuah bangunan sederhana, kini kami telah berkembang menjadi institusi pengasuhan modern yang menaungi lebih dari {{ $totalAnakAsuh ?? 0 }} anak asuh.</p>
            <p class="font-body-md text-sm sm:text-base text-on-surface-variant">Perjalanan kami tidak lepas dari dukungan para donatur dan masyarakat yang menaruh kepercayaan penuh pada prinsip "Amanah" yang kami pegang teguh.</p>
        </div>
        <div class="rounded-xl overflow-hidden soft-shadow h-[200px] sm:h-[250px] md:h-[300px]">
            <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAfduf8xYKusSqYYPhrmJkGYGEFcN14xxQFyEKcStcSYW3H7LeVV8Ftiyl7aAaUdeXebNnGCVU4pd10cO7-1eF7zN6VK0rI8Q7eId9SKQCDvnUNwLr7vDXH5QLVQksC7ZZcu4V6lkKk3G2Ms9IO5-u3pmixY2wm6YZsiEDCvs_SzxdkY_1h8sZx00N--PywTm5wXEdUFM_pFxEWvyOQqdsGFLeSMBMFWs2jDNw3e6xbx5K6l89FtKeE" alt="Sejarah PAM Pesantunan">
        </div>
    </div>

    <section class="mb-8 sm:mb-12 lg:mb-16">
        <h2 class="font-headline-lg text-2xl sm:text-3xl lg:text-[32px] text-center text-primary mb-6 sm:mb-8 lg:mb-10 reveal">Visi &amp; Misi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-surface-bright rounded-xl p-5 sm:p-6 lg:p-8 border border-outline-variant/30 relative overflow-hidden group reveal">
                <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-[80px] sm:text-[100px] text-primary">visibility</span>
                </div>
                <h3 class="font-title-lg text-lg sm:text-xl text-primary mb-2 relative z-10">Visi Kami</h3>
                <p class="font-body-md text-sm sm:text-base text-on-surface-variant relative z-10">{{ $visi ?? 'Menjadi panti asuhan yang unggul dalam pengasuhan, pendidikan, dan pemberdayaan anak-anak yatim dan dhuafa.' }}</p>
            </div>
            <div class="bg-surface-bright rounded-xl p-5 sm:p-6 lg:p-8 border border-outline-variant/30 relative overflow-hidden group reveal" style="transition-delay: 100ms;">
                <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-[80px] sm:text-[100px] text-secondary">explore</span>
                </div>
                <h3 class="font-title-lg text-lg sm:text-xl text-primary mb-2 relative z-10">Misi Kami</h3>
                <ul class="list-disc pl-4 sm:pl-5 font-body-md text-sm sm:text-base text-on-surface-variant space-y-1 sm:space-y-2 relative z-10">
                    @foreach($misi ?? [] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <!-- ==================== PENGURUS PANTI ==================== -->
    <section class="mb-8 sm:mb-12 lg:mb-16">
        <h2 class="font-headline-lg text-2xl sm:text-3xl lg:text-[32px] text-center text-primary mb-6 sm:mb-8 lg:mb-10 reveal">Pengurus Panti</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6">
            @forelse($pengurus ?? [] as $index => $item)
                <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 text-center soft-shadow hover-soft-shadow transition-all reveal" style="transition-delay: {{ $index * 100 }}ms;">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-full overflow-hidden mb-2 sm:mb-3 border-2 border-primary-fixed-dim">
                        @if(!empty($item->foto))
                            <img class="w-full h-full object-cover" src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}">
                        @else
                            <div class="w-full h-full bg-primary-fixed/20 flex items-center justify-center text-2xl sm:text-3xl text-primary font-bold">
                                {{ $item->nama[0] ?? '?' }}
                            </div>
                        @endif
                    </div>
                    <h3 class="font-title-lg text-sm sm:text-base md:text-lg text-on-surface">{{ $item->nama ?? '-' }}</h3>
                    <p class="font-label-md text-xs sm:text-sm text-primary mt-1">{{ $item->jabatan ?? '-' }}</p>
                    @if(!empty($item->deskripsi))
                        <p class="font-body-sm text-xs text-on-surface-variant mt-2 line-clamp-2">{{ $item->deskripsi }}</p>
                    @endif
                    @if(!empty($item->email) || !empty($item->telepon))
                        <div class="mt-2 flex justify-center gap-2 text-on-surface-variant/60">
                            @if(!empty($item->email))
                                <a href="mailto:{{ $item->email }}" class="hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-sm">mail</span>
                                </a>
                            @endif
                            @if(!empty($item->telepon))
                                <a href="tel:{{ $item->telepon }}" class="hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-sm">call</span>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full text-center text-on-surface-variant py-8">
                    <span class="material-symbols-outlined text-4xl mb-2">people</span>
                    <p>Belum ada data pengurus.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- ==================== TRANSPARANSI ==================== -->
    <section class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow mb-8 sm:mb-12 lg:mb-16 border-l-4 border-secondary-container reveal">
        <div class="flex flex-col md:flex-row gap-6 lg:gap-8 items-center">
            <div class="md:w-1/2">
                <div class="inline-flex items-center gap-1 sm:gap-2 px-3 py-1 bg-secondary-fixed text-on-secondary-fixed rounded-full font-label-sm text-label-sm mb-2 sm:mb-3">
                    <span class="material-symbols-outlined text-sm">verified_user</span>
                    Komitmen Amanah
                </div>
                <h2 class="font-headline-md text-xl sm:text-2xl text-on-surface mb-2 sm:mb-3">Transparansi Finansial Digital</h2>
                <p class="font-body-md text-sm sm:text-base text-on-surface-variant mb-3">Kami memahami bahwa kepercayaan donatur adalah amanah terbesar. Oleh karena itu, {{ $identitas->nama_panti ?? 'PAM Pesantunan' }} mengadopsi sistem pencatatan keuangan digital berbasis teknologi terkini.</p>
                <p class="font-body-md text-sm sm:text-base text-on-surface-variant">Setiap donasi, sekecil apapun, tercatat secara real-time. Kami menyediakan dashboard laporan keuangan yang dapat diakses publik, memastikan setiap rupiah tersalurkan tepat sasaran.</p>
                <a href="{{ route('transparansi') }}" class="inline-block mt-4 px-6 py-2 bg-primary text-on-primary rounded-lg font-jakarta text-sm hover:bg-primary-fixed transition-colors">
                    Lihat Laporan Keuangan
                </a>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <div class="w-full max-w-sm bg-white rounded-xl soft-shadow p-4 sm:p-5 border-t-4 border-secondary overflow-hidden relative">
                    <div class="absolute -right-10 -top-10 w-24 sm:w-32 h-24 sm:h-32 bg-secondary-fixed rounded-full opacity-20 blur-xl"></div>
                    <h4 class="font-label-md text-label-md text-on-surface-variant mb-2">Ringkasan Keuangan</h4>
                    <div class="text-xl sm:text-2xl font-bold text-on-surface mb-2">Rp {{ number_format($totalDonasi ?? 0, 0, ',', '.') }}</div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center py-1.5 sm:py-2 border-b border-surface-variant">
                            <span class="font-body-sm text-xs sm:text-sm text-on-surface-variant flex items-center gap-1 sm:gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">arrow_downward</span> Total Pemasukan
                            </span>
                            <span class="font-label-md text-sm sm:text-base text-primary">Rp {{ number_format($totalDonasi ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1.5 sm:py-2 border-b border-surface-variant">
                            <span class="font-body-sm text-xs sm:text-sm text-on-surface-variant flex items-center gap-1 sm:gap-2">
                                <span class="material-symbols-outlined text-outline text-sm">arrow_upward</span> Total Pengeluaran
                            </span>
                            <span class="font-label-md text-sm sm:text-base text-on-surface-variant">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-1.5 sm:py-2">
                            <span class="font-body-sm text-xs sm:text-sm text-on-surface-variant flex items-center gap-1 sm:gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">account_balance</span> Saldo Akhir
                            </span>
                            <span class="font-label-md text-sm sm:text-base font-bold text-primary">Rp {{ number_format(($totalDonasi ?? 0) - ($totalPengeluaran ?? 0), 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nilai-nilai -->
    <section>
        <h2 class="font-headline-lg text-2xl sm:text-3xl lg:text-[32px] text-center text-primary mb-6 sm:mb-8 lg:mb-10 reveal">Nilai-Nilai Kami</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-5 lg:gap-6">
            @foreach($values ?? [] as $index => $value)
                <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 text-center soft-shadow reveal" style="transition-delay: {{ $index * 100 }}ms;">
                    <span class="material-symbols-outlined text-3xl sm:text-4xl text-primary mb-2">{{ $value->icon ?? 'verified' }}</span>
                    <h3 class="font-title-lg text-sm sm:text-base text-on-surface">{{ $value->title ?? '' }}</h3>
                    <p class="font-body-sm text-xs sm:text-sm text-on-surface-variant mt-1">{{ $value->description ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </section>
</main>
@endsection