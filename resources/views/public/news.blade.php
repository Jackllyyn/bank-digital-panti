@extends('layouts.public')

@section('title', 'Berita - PAM Pesantunan')

@section('content')
<main class="pt-16 sm:pt-20 pb-10 sm:pb-14 md:pb-18 lg:pb-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">

    <div class="text-center mb-8 sm:mb-12 lg:mb-16 reveal">
        <h1 class="font-display-lg text-3xl sm:text-4xl md:text-[48px] text-primary mb-2 sm:mb-3">Berita & Informasi</h1>
        <p class="font-body-lg text-sm sm:text-base md:text-lg text-on-surface-variant">Kabar terbaru dari {{ $identitas->nama_panti ?? 'Panti Asuhan Muhammadiyah Pesantunan' }}.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 sm:gap-8">
        <!-- Main Content -->
        <div class="md:col-span-8 flex flex-col gap-6 sm:gap-8">
            @forelse($berita ?? [] as $index => $item)
                <article class="bg-surface-container-lowest rounded-xl overflow-hidden soft-shadow hover:shadow-lg transition-shadow group relative reveal" style="transition-delay: {{ ($index % 4) * 100 }}ms;">
                    @if(!empty($item->gambar))
                        <div class="aspect-video relative">
                            <img class="w-full h-full object-cover" src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul ?? 'Berita' }}">
                            @if($index == 0)
                                <div class="absolute top-3 left-3 sm:top-4 sm:left-4 bg-primary text-on-primary font-label-sm text-label-sm px-3 py-1 rounded-full shadow-sm">Sorotan Utama</div>
                            @endif
                        </div>
                    @else
                        <div class="aspect-video relative bg-surface-variant flex items-center justify-center">
                            <span class="material-symbols-outlined text-6xl text-on-surface-variant/30">newspaper</span>
                            @if($index == 0)
                                <div class="absolute top-3 left-3 sm:top-4 sm:left-4 bg-primary text-on-primary font-label-sm text-label-sm px-3 py-1 rounded-full shadow-sm">Sorotan Utama</div>
                            @endif
                        </div>
                    @endif
                    <div class="p-4 sm:p-5 md:p-6">
                        <div class="flex items-center gap-1 sm:gap-2 text-on-surface-variant mb-2 font-label-sm text-label-sm">
                            <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                            <span>
                                @if(isset($item->published_at))
                                    @if($item->published_at instanceof \Carbon\Carbon)
                                        {{ $item->published_at->format('d M Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}
                                    @endif
                                @elseif(isset($item->created_at))
                                    @if($item->created_at instanceof \Carbon\Carbon)
                                        {{ $item->created_at->format('d M Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                    @endif
                                @else
                                    -
                                @endif
                            </span>
                            <span class="mx-1 sm:mx-2">•</span>
                            <span class="text-secondary font-medium">{{ $item->kategori ?? 'Umum' }}</span>
                            @if(isset($item->views))
                                <span class="mx-1 sm:mx-2">•</span>
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">visibility</span>
                                    {{ $item->views }}
                                </span>
                            @endif
                        </div>
                        <h2 class="font-headline-md text-xl sm:text-2xl text-on-surface group-hover:text-primary transition-colors mb-2">
                            <a href="{{ route('news.detail', $item->slug ?? '#') }}">{{ $item->judul ?? 'Tanpa Judul' }}</a>
                        </h2>
                        {{-- PERBAIKAN DI SINI: Menggunakan \Illuminate\Support\Str::limit dan isset --}}
                        <p class="font-body-md text-sm sm:text-base text-on-surface-variant mb-3 sm:mb-4 line-clamp-3">{{ \Illuminate\Support\Str::limit(strip_tags($item->konten ?? ''), 150) }}</p>
                        <a href="{{ route('news.detail', $item->slug ?? '#') }}" class="inline-flex items-center gap-1 font-label-md text-label-md text-primary hover:text-primary-fixed-variant transition-colors">
                            Baca Selengkapnya <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="text-center py-12 text-on-surface-variant">
                    <span class="material-symbols-outlined text-6xl mb-4">article</span>
                    <p>Belum ada berita.</p>
                </div>
            @endforelse

            <!-- ==================== PAGINATION ==================== -->
            @if(isset($berita) && method_exists($berita, 'hasPages') && $berita->hasPages())
                <div class="flex justify-center mt-4 sm:mt-6">
                    {{ $berita->links() }}
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <aside class="md:col-span-4 flex flex-col gap-6">
            <!-- Search -->
            <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 md:p-6 soft-shadow reveal">
                <h3 class="font-title-lg text-lg text-on-surface mb-3">Cari Berita</h3>
                <form method="GET" action="{{ route('news') }}" class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input class="w-full bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg pl-9 sm:pl-10 pr-3 py-2 font-body-md text-sm sm:text-base text-on-surface transition-colors placeholder:text-outline" 
                           placeholder="Masukkan kata kunci..." 
                           type="text" 
                           name="search" 
                           value="{{ request('search') }}">
                </form>
            </div>

            <!-- Categories -->
            @if(isset($categories) && $categories->count() > 0)
            <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 md:p-6 soft-shadow reveal" style="transition-delay: 100ms;">
                <h3 class="font-title-lg text-lg text-on-surface mb-3 border-b border-outline-variant pb-2">Kategori</h3>
                <ul class="flex flex-col gap-2 font-body-md text-sm sm:text-base">
                    @foreach($categories as $kategori)
                        <li>
                            <a class="flex justify-between items-center text-on-surface-variant hover:text-primary transition-colors py-1" 
                               href="{{ route('news', ['kategori' => $kategori]) }}">
                                <span>{{ $kategori }}</span>
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a class="flex justify-between items-center text-on-surface-variant hover:text-primary transition-colors py-1" 
                           href="{{ route('news') }}">
                            <span class="text-primary">Semua Kategori</span>
                        </a>
                    </li>
                </ul>
            </div>
            @endif

            <!-- Popular News -->
            @if(isset($beritaPopuler) && $beritaPopuler->count() > 0)
                <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 md:p-6 soft-shadow reveal" style="transition-delay: 200ms;">
                    <h3 class="font-title-lg text-lg text-on-surface mb-3 border-b border-outline-variant pb-2">Berita Populer</h3>
                    <div class="flex flex-col gap-3 sm:gap-4">
                        @foreach($beritaPopuler as $item)
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
                                    <h4 class="font-label-md text-sm sm:text-base text-on-surface group-hover:text-primary transition-colors line-clamp-2 mb-1">{{ $item->judul ?? 'Tanpa Judul' }}</h4>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant">
                                        @if(isset($item->published_at))
                                            @if($item->published_at instanceof \Carbon\Carbon)
                                                {{ $item->published_at->format('d M Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}
                                            @endif
                                        @elseif(isset($item->created_at))
                                            @if($item->created_at instanceof \Carbon\Carbon)
                                                {{ $item->created_at->format('d M Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- CTA Donasi -->
            <div class="bg-primary-container text-on-primary-container rounded-xl p-4 sm:p-5 md:p-6 soft-shadow flex flex-col items-center text-center reveal" style="transition-delay: 300ms;">
                <span class="material-symbols-outlined text-[36px] sm:text-[40px] mb-2 opacity-80">volunteer_activism</span>
                <h3 class="font-title-lg text-lg mb-2">Dukung Kegiatan Kami</h3>
                <p class="font-body-sm text-sm mb-3 sm:mb-4 opacity-90">Setiap donasi Anda membantu memastikan kegiatan panti berjalan lancar dan transparan.</p>
                <a href="{{ route('donation') }}" class="w-full bg-on-primary-container text-primary-container font-label-md text-label-md py-2 rounded-lg hover:bg-white transition-colors">Donasi Sekarang</a>
            </div>
        </aside>
    </div>
</main>
@endsection