<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PAM Pesantunan - Panti Asuhan Muhammadiyah')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font: Inter (netral, standar, mudah dibaca) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Material Symbols --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        /* ===== FONT ===== */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-feature-settings: 'cv11', 'ss01';
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            color: #111827;
            background-color: #f9fafb;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Inter', sans-serif;
            letter-spacing: -0.02em;
        }

        .tabular-nums {
            font-variant-numeric: tabular-nums;
        }

        /* Fallback: semua class font lama jadi Inter */
        .font-jakarta,
        .font-playfair,
        .font-fraunces,
        .font-display,
        .font-instrument,
        .font-caveat,
        .font-dancing,
        .font-great-vibes,
        .font-dm-serif,
        .font-inter,
        .font-sans {
            font-family: 'Inter', sans-serif;
        }

        /* ===== WARNA DASAR (netral) ===== */
        .bg-background { background-color: #f9fafb; }
        .bg-surface { background-color: #ffffff; }
        .bg-surface-container-lowest { background-color: #ffffff; }
        .bg-surface-container-low { background-color: #f3f4f6; }
        .bg-surface-container { background-color: #e5e7eb; }
        .bg-surface-variant { background-color: #f3f4f6; }

        .bg-primary { background-color: #166534; }
        .bg-primary-container { background-color: #15803d; }
        .bg-primary-fixed { background-color: #dcfce7; }

        .bg-secondary { background-color: #1e40af; }
        .bg-secondary-fixed { background-color: #dbeafe; }

        .text-on-background { color: #111827; }
        .text-on-surface { color: #111827; }
        .text-on-surface-variant { color: #4b5563; }
        .text-on-primary { color: #ffffff; }
        .text-on-primary-container { color: #ffffff; }
        .text-primary { color: #166534; }
        .text-secondary { color: #1e40af; }
        .text-outline { color: #6b7280; }

        .border-primary { border-color: #166534; }
        .border-secondary { border-color: #1e40af; }
        .border-outline-variant { border-color: #e5e7eb; }

        /* ===== EFEK SEDERHANA ===== */
        .soft-shadow {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
        }
        .hover-soft-shadow:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: box-shadow 0.2s ease;
        }

        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ===== TIPOGRAFI ===== */
        .font-display-lg  { font-size: 36px; line-height: 44px; font-weight: 700; letter-spacing: -0.02em; }
        .font-headline-lg { font-size: 28px; line-height: 36px; font-weight: 700; letter-spacing: -0.01em; }
        .font-headline-md { font-size: 22px; line-height: 30px; font-weight: 600; }
        .font-title-lg    { font-size: 18px; line-height: 26px; font-weight: 600; }
        .font-body-lg     { font-size: 17px; line-height: 26px; font-weight: 400; }
        .font-body-md     { font-size: 15px; line-height: 23px; font-weight: 400; }
        .font-label-md    { font-size: 14px; line-height: 20px; font-weight: 600; }
        .font-label-sm    { font-size: 12px; line-height: 16px; font-weight: 500; }

        @media (max-width: 768px) {
            .font-display-lg  { font-size: 28px; line-height: 36px; }
            .font-headline-lg { font-size: 22px; line-height: 30px; }
        }

        /* Parallax */
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        /* ===== ANIMASI ===== */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .float-animation { animation: float 3s ease-in-out infinite; }
    </style>
    @stack('styles')
</head>
<body class="bg-background text-on-background font-body-md antialiased overflow-x-hidden">

    <!-- ==================== NAVBAR ==================== -->
    <nav class="fixed top-0 left-0 right-0 w-full z-50 shadow-sm bg-white border-b border-gray-200 transition-all duration-300" id="navbar">
        <div class="flex justify-between items-center h-16 sm:h-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">

            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-2xl sm:text-3xl" style="font-variation-settings: 'FILL' 1;">mosque</span>
                <span class="text-lg sm:text-xl font-bold text-primary">PAM Pesantunan</span>
            </a>

            <div class="hidden md:flex items-center gap-4 lg:gap-6">
                <a class="text-gray-600 hover:text-primary transition-colors font-medium text-sm @if(request()->routeIs('home')) text-primary font-bold border-b-2 border-primary @endif" href="{{ route('home') }}">Beranda</a>
                <a class="text-gray-600 hover:text-primary transition-colors font-medium text-sm @if(request()->routeIs('about')) text-primary font-bold border-b-2 border-primary @endif" href="{{ route('about') }}">Tentang</a>
                <a class="text-gray-600 hover:text-primary transition-colors font-medium text-sm @if(request()->routeIs('gallery')) text-primary font-bold border-b-2 border-primary @endif" href="{{ route('gallery') }}">Galeri</a>
                <a class="text-gray-600 hover:text-primary transition-colors font-medium text-sm @if(request()->routeIs('news')) text-primary font-bold border-b-2 border-primary @endif" href="{{ route('news') }}">Berita</a>
                <a class="text-gray-600 hover:text-primary transition-colors font-medium text-sm @if(request()->routeIs('contact')) text-primary font-bold border-b-2 border-primary @endif" href="{{ route('contact') }}">Kontak</a>
            </div>

            <div class="hidden md:flex items-center gap-2 lg:gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white text-primary border border-primary rounded-md font-medium text-sm hover:bg-green-50 transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-white text-primary border border-primary rounded-md font-medium text-sm hover:bg-green-50 transition-colors">Login</a>
                @endauth

                <a href="{{ route('donation') }}" class="px-4 py-2 bg-primary text-white rounded-md font-medium text-sm hover:bg-green-900 transition-colors">Donasi</a>
            </div>

            <button class="md:hidden text-gray-700" id="mobileMenuBtn" aria-label="Toggle menu">
                <span class="material-symbols-outlined text-2xl">menu</span>
            </button>
        </div>

        <div id="mobileMenu" class="hidden md:hidden bg-white shadow-lg px-4 py-4 border-t border-gray-200">
            <div class="flex flex-col space-y-3">
                <a class="text-gray-600 hover:text-primary transition-colors font-medium text-sm @if(request()->routeIs('home')) text-primary font-bold @endif" href="{{ route('home') }}">Beranda</a>
                <a class="text-gray-600 hover:text-primary transition-colors font-medium text-sm @if(request()->routeIs('about')) text-primary font-bold @endif" href="{{ route('about') }}">Tentang</a>
                <a class="text-gray-600 hover:text-primary transition-colors font-medium text-sm @if(request()->routeIs('gallery')) text-primary font-bold @endif" href="{{ route('gallery') }}">Galeri</a>
                <a class="text-gray-600 hover:text-primary transition-colors font-medium text-sm @if(request()->routeIs('news')) text-primary font-bold @endif" href="{{ route('news') }}">Berita</a>
                <a class="text-gray-600 hover:text-primary transition-colors font-medium text-sm @if(request()->routeIs('contact')) text-primary font-bold @endif" href="{{ route('contact') }}">Kontak</a>

                <div class="flex flex-col gap-2 pt-3 border-t border-gray-200">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full text-center px-4 py-2 bg-white text-primary border border-primary rounded-md font-medium text-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center px-4 py-2 bg-white text-primary border border-primary rounded-md font-medium text-sm">Login</a>
                    @endauth

                    <a href="{{ route('donation') }}" class="w-full text-center px-4 py-2 bg-primary text-white rounded-md font-medium text-sm">Donasi</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ==================== CONTENT ==================== -->
    <main class="pt-16 sm:pt-20">
        @yield('content')
    </main>

    <!-- ==================== FOOTER ==================== -->
    <footer class="w-full mt-12 sm:mt-16 lg:mt-20 border-t border-gray-200 bg-white">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 py-8 sm:py-10 lg:py-12 max-w-[1440px] mx-auto">

            <div class="sm:col-span-2 lg:col-span-2">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-primary text-2xl" style="font-variation-settings: 'FILL' 1;">mosque</span>
                    <span class="text-lg font-bold text-primary">PAM Pesantunan</span>
                </div>
                <p class="text-gray-600 max-w-md mb-3">
                    Lembaga kesejahteraan sosial anak yang berdedikasi untuk memberikan masa depan yang cerah melalui pendidikan, pengasuhan islami, dan transparansi donasi berbasis digital.
                </p>
                <p class="text-primary">© {{ date('Y') }} Panti Asuhan Muhammadiyah Pesantunan. Amanah &amp; Transparan.</p>
            </div>

            <div>
                <h4 class="text-gray-900 font-semibold mb-3">Tautan Cepat</h4>
                <ul class="space-y-2">
                    <li><a class="text-gray-600 hover:text-primary transition-colors" href="#">Kebijakan Privasi</a></li>
                    <li><a class="text-gray-600 hover:text-primary transition-colors" href="#">Syarat &amp; Ketentuan</a></li>
                    <li><a class="text-gray-600 hover:text-primary transition-colors" href="{{ route('transparansi') }}">Laporan Keuangan</a></li>
                    <li><a class="text-gray-600 hover:text-primary transition-colors" href="{{ route('contact') }}">Hubungi Kami</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-gray-900 font-semibold mb-3">Hubungi Kami</h4>
                <ul class="space-y-2">
                    <li class="flex items-start gap-2 text-gray-600">
                        <span class="material-symbols-outlined text-primary mt-0.5 text-sm">location_on</span>
                        <span>Jl. Pesantunan Raya No. 123, Brebes, Jawa Tengah</span>
                    </li>
                    <li class="flex items-center gap-2 text-gray-600">
                        <span class="material-symbols-outlined text-primary text-sm">phone</span>
                        <span>081542054789</span>
                    </li>
                    <li class="flex items-center gap-2 text-gray-600">
                        <span class="material-symbols-outlined text-primary text-sm">mail</span>
                        <span>info@muhammadiyah-pesantunan.or.id</span>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    {{-- ==================== SCRIPT ==================== --}}
    <script>
        // Reveal on scroll
        function reveal() {
            var reveals = document.querySelectorAll(".reveal");
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 100;
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add("active");
                }
            }
        }
        window.addEventListener("scroll", reveal);
        reveal();

        // Navbar shadow on scroll
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-md');
                nav.classList.remove('shadow-sm');
            } else {
                nav.classList.remove('shadow-md');
                nav.classList.add('shadow-sm');
            }
        });

        // Mobile menu toggle
        const mobileBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                const icon = this.querySelector('.material-symbols-outlined');
                if (icon.textContent === 'menu') {
                    icon.textContent = 'close';
                } else {
                    icon.textContent = 'menu';
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>