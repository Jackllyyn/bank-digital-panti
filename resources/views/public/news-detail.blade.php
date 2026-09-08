@extends('layouts.public')

@section('title', ($berita->judul ?? 'Detail Berita') . ' - PAM Pesantunan')

@section('content')
<main class="pt-16 sm:pt-20 pb-10 sm:pb-14 md:pb-18 lg:pb-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">

    <!-- ==================== BREADCRUMB ==================== -->
    <div class="mb-6 sm:mb-8 reveal">
        <nav class="flex items-center gap-2 font-jakarta text-sm text-on-surface-variant">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <a href="{{ route('news') }}" class="hover:text-primary transition-colors">Berita</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-primary font-medium">{{ \Illuminate\Support\Str::limit($berita->judul ?? 'Detail', 30) }}</span>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
        <!-- ==================== KONTEN UTAMA ==================== -->
        <div class="lg:col-span-8">
            <article class="bg-surface-container-lowest rounded-xl overflow-hidden soft-shadow reveal">
                
                <!-- Gambar Utama -->
                @if(!empty($berita->gambar))
                    <div class="aspect-video relative">
                        <img class="w-full h-full object-cover" src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul ?? 'Berita' }}">
                    </div>
                @else
                    <div class="aspect-video relative bg-surface-variant flex items-center justify-center">
                        <span class="material-symbols-outlined text-7xl text-on-surface-variant/30">newspaper</span>
                    </div>
                @endif

                <div class="p-5 sm:p-6 md:p-8">
                    <!-- Meta Info -->
                    <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-on-surface-variant mb-3 font-jakarta text-xs sm:text-sm">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                            @if(isset($berita->published_at))
                                {{ \Carbon\Carbon::parse($berita->published_at)->format('d M Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y') }}
                            @endif
                        </span>
                        <span class="mx-1">•</span>
                        <span class="text-secondary font-medium">{{ $berita->kategori ?? 'Umum' }}</span>
                        @if(isset($berita->views))
                            <span class="mx-1">•</span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">visibility</span>
                                {{ $berita->views }} views
                            </span>
                        @endif
                    </div>

                    <!-- Judul -->
                    <h1 class="font-playfair text-2xl sm:text-3xl md:text-4xl text-on-surface mb-4">
                        {{ $berita->judul ?? 'Tanpa Judul' }}
                    </h1>

                    <!-- Konten Berita -->
                    <div class="prose prose-sm sm:prose-base max-w-none font-body-md text-on-surface-variant leading-relaxed">
                        {!! $berita->konten ?? '' !!}
                    </div>

                    <!-- Share & Tags -->
                    <div class="mt-8 pt-6 border-t border-outline-variant flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="flex items-center gap-2">
                            <span class="font-jakarta text-sm text-on-surface-variant">Bagikan:</span>
                            <a href="#" class="w-8 h-8 rounded-full bg-secondary-fixed flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors">
                                <i class="fab fa-facebook-f text-sm"></i>
                            </a>
                            <a href="#" class="w-8 h-8 rounded-full bg-secondary-fixed flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors">
                                <i class="fab fa-twitter text-sm"></i>
                            </a>
                            <a href="#" class="w-8 h-8 rounded-full bg-secondary-fixed flex items-center justify-center text-secondary hover:bg-secondary hover:text-white transition-colors">
                                <i class="fab fa-whatsapp text-sm"></i>
                            </a>
                        </div>
                        <a href="{{ route('news') }}" class="inline-flex items-center gap-1 font-jakarta text-sm text-primary hover:underline">
                            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                            Kembali ke Daftar Berita
                        </a>
                    </div>
                </div>
            </article>
        </div>

        <!-- ==================== SIDEBAR ==================== -->
        <aside class="lg:col-span-4 flex flex-col gap-6">
            <!-- Berita Terkait -->
            @if(isset($beritaTerkait) && $beritaTerkait->count() > 0)
            <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 md:p-6 soft-shadow reveal">
                <h3 class="font-playfair text-lg text-on-surface mb-3 border-b border-outline-variant pb-2">Berita Terkait</h3>
                <div class="flex flex-col gap-4">
                    @foreach($beritaTerkait as $item)
                        <a href="{{ route('news.detail', $item->slug ?? '#') }}" class="flex gap-3 group">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded bg-surface-variant flex-shrink-0 overflow-hidden">
                                @if(!empty($item->gambar))
                                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul ?? 'Berita' }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant/30">
                                        <span class="material-symbols-outlined">image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-col justify-center">
                                <h4 class="font-jakarta text-sm font-medium text-on-surface group-hover:text-primary transition-colors line-clamp-2 mb-1">{{ $item->judul ?? 'Tanpa Judul' }}</h4>
                                <span class="font-jakarta text-xs text-on-surface-variant">
                                    {{ \Carbon\Carbon::parse($item->published_at ?? $item->created_at)->format('d M Y') }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- CTA Donasi -->
            <div class="bg-primary-container text-on-primary-container rounded-xl p-4 sm:p-5 md:p-6 soft-shadow flex flex-col items-center text-center reveal" style="transition-delay: 100ms;">
                <span class="material-symbols-outlined text-[36px] mb-2 opacity-80">volunteer_activism</span>
                <h3 class="font-playfair text-lg mb-2">Dukung Kegiatan Kami</h3>
                <p class="font-body-md text-sm mb-3 opacity-90">Setiap donasi Anda membantu memastikan kegiatan panti berjalan lancar dan transparan.</p>
                <a href="{{ route('donation') }}" class="w-full bg-on-primary-container text-primary-container font-jakarta text-sm font-medium py-2 rounded-lg hover:bg-white transition-colors">Donasi Sekarang</a>
            </div>
        </aside>
    </div>
</main>
@endsection