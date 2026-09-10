{{-- resources/views/public/gallery.blade.php --}}
@extends('layouts.public')

@section('title', 'Galeri - PAM Pesantunan')

@section('content')
<main class="pt-16 sm:pt-20 pb-10 sm:pb-14 md:pb-18 lg:pb-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">

    <section class="text-center mb-8 sm:mb-12 lg:mb-16 reveal">
        <h1 class="font-display-lg text-3xl sm:text-4xl md:text-[48px] text-primary mb-2 sm:mb-3">Galeri Kegiatan</h1>
        <p class="font-body-lg text-sm sm:text-base md:text-lg text-on-surface-variant max-w-2xl mx-auto">
            Melihat lebih dekat aktivitas, keceriaan, dan perkembangan anak-anak asuh di {{ $identitas->nama_panti ?? 'Panti Asuhan Muhammadiyah Pesantunan' }}.
        </p>
    </section>

    <!-- Filter Kategori -->
    @if(isset($categories) && $categories->count() > 0)
    <section class="mb-6 sm:mb-8 lg:mb-10 flex flex-wrap justify-center gap-2 sm:gap-3 reveal">
        <a href="{{ route('gallery') }}" class="px-4 py-2 rounded-full font-label-md text-label-md {{ !request('kategori') ? 'bg-primary-container text-on-primary-container shadow-sm' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container' }} transition-all">
            Semua
        </a>
        @foreach($categories as $kategori)
            <a href="{{ route('gallery', ['kategori' => $kategori]) }}" class="px-4 py-2 rounded-full font-label-md text-label-md {{ request('kategori') == $kategori ? 'bg-primary-container text-on-primary-container shadow-sm' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container' }} transition-all">
                {{ $kategori }}
            </a>
        @endforeach
    </section>
    @endif

    <!-- Grid Galeri -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-5 md:gap-6 mb-8 sm:mb-10">
        @forelse($galleries ?? [] as $index => $item)
            <div class="gallery-item relative rounded-xl overflow-hidden soft-shadow hover:shadow-lg transition-shadow group bg-white cursor-pointer {{ $index % 3 == 0 ? 'md:col-span-2 md:row-span-2 h-[250px] sm:h-[350px] md:h-[450px] lg:h-[600px]' : 'h-[180px] sm:h-[200px] md:h-[250px] lg:h-[280px]' }} reveal" style="transition-delay: {{ ($index % 6) * 100 }}ms;">
                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
                     src="{{ !empty($item->gambar) ? asset('storage/' . $item->gambar) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuDPaeNs2fUfgQTn4u6BLo4XBPHswwWVRbVcAmdxYCJUWHLu92VAkQHHDCv0YVpGboUqFAm7szif0alAolllbKSzZ1AzgtIM_-CYuBeYZC8hyDtKvNHrLWe7WMfT5C6lY09qc1gljMgZnGzOkiBjI6U3xfr9IAxJjeL0xtUWJV82cu38K6d4EGqUmgQ4bvesRs3MvD_-qMzVW0tLCer6iXJqEL3ToglAa_B1JljX0r3YM0BKoRu3oSeO' }}" 
                     alt="{{ $item->judul }}">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-3 sm:p-4">
                    <span class="text-white font-label-sm text-label-sm mb-1">
                        @if(isset($item->tanggal))
                            @if($item->tanggal instanceof \Carbon\Carbon)
                                {{ $item->tanggal->format('d M Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
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
                    <h3 class="text-white font-title-lg text-sm sm:text-base">{{ $item->judul ?? '-' }}</h3>
                    @if(!empty($item->kategori))
                        <span class="text-white/80 font-label-sm text-xs mt-1">{{ $item->kategori }}</span>
                    @endif
                    @if(!empty($item->lokasi))
                        <span class="text-white/70 font-label-sm text-xs mt-0.5 flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">location_on</span>
                            {{ $item->lokasi }}
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-on-surface-variant">
                <span class="material-symbols-outlined text-6xl mb-4">photo_library</span>
                <p>Belum ada foto galeri.</p>
            </div>
        @endforelse
    </div>

    <!-- ==================== PAGINATION ==================== -->
    @if(isset($galleries) && method_exists($galleries, 'hasPages') && $galleries->hasPages())
        <div class="flex justify-center mt-8">
            {{ $galleries->links() }}
        </div>
    @endif
</main>

<style>
    .gallery-item:hover img {
        transform: scale(1.05);
    }
</style>
@endsection