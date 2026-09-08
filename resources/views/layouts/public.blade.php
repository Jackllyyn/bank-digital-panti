<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PAM Pesantunan - Panti Asuhan Muhammadiyah')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Google Fonts - Variasi Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600;1,700&family=Inter:wght@300;400;500;600;700;800&family=Dancing+Script:wght@400;500;600;700&family=DM+Serif+Display:ital@0;1&family=Great+Vibes&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; }

        /* Font Classes */
        .font-playfair { font-family: 'Playfair Display', serif; }
        .font-dancing { font-family: 'Dancing Script', cursive; }
        .font-dm-serif { font-family: 'DM Serif Display', serif; }
        .font-great-vibes { font-family: 'Great Vibes', cursive; }
        .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-instrument { font-family: 'Instrument Serif', serif; }

        .bg-background { background-color: #f8f9fa; }
        .bg-surface { background-color: #f8f9fa; }
        .bg-surface-container-lowest { background-color: #ffffff; }
        .bg-surface-container-low { background-color: #f3f4f5; }
        .bg-surface-container { background-color: #edeeef; }
        .bg-primary { background-color: #00522c; }
        .bg-primary-container { background-color: #006d3c; }
        .bg-primary-fixed { background-color: #9bf6b7; }
        .bg-secondary { background-color: #0058bc; }
        .bg-secondary-fixed { background-color: #d8e2ff; }
        .bg-tertiary-container { background-color: #cca72f; }
        .bg-surface-variant { background-color: #e1e3e4; }
        .bg-gold-gradient { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
        .bg-soft-green { background: linear-gradient(135deg, #a8e6cf 0%, #dcedc1 100%); }

        .text-on-background { color: #191c1d; }
        .text-on-surface { color: #191c1d; }
        .text-on-surface-variant { color: #3f4941; }
        .text-on-primary { color: #ffffff; }
        .text-on-primary-container { color: #92ecae; }
        .text-primary { color: #00522c; }
        .text-secondary { color: #0058bc; }
        .text-tertiary { color: #735c00; }
        .text-outline { color: #6f7a70; }
        .text-gold { color: #b8860b; }
        .text-gold-light { color: #d4a017; }

        .border-primary { border-color: #00522c; }
        .border-secondary { border-color: #0058bc; }
        .border-outline-variant { border-color: #bec9be; }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .soft-shadow {
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.04);
        }
        .hover-soft-shadow:hover {
            box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
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

        .font-display-lg { font-size: 48px; line-height: 56px; letter-spacing: -0.02em; font-weight: 700; }
        .font-headline-lg { font-size: 32px; line-height: 40px; letter-spacing: -0.01em; font-weight: 600; }
        .font-headline-md { font-size: 24px; line-height: 32px; font-weight: 600; }
        .font-title-lg { font-size: 20px; line-height: 28px; font-weight: 500; }
        .font-body-lg { font-size: 18px; line-height: 28px; font-weight: 400; }
        .font-body-md { font-size: 16px; line-height: 24px; font-weight: 400; }
        .font-label-md { font-size: 14px; line-height: 20px; letter-spacing: 0.01em; font-weight: 600; }
        .font-label-sm { font-size: 12px; line-height: 16px; font-weight: 500; }

        @media (max-width: 768px) {
            .font-display-lg { font-size: 32px; line-height: 40px; }
            .font-headline-lg { font-size: 24px; line-height: 32px; }
        }

        /* Text shadow for hero */
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .text-shadow-light {
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        /* Gradient text */
        .text-gradient-gold {
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .text-gradient-green {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Decorative elements */
        .decorative-line {
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #006d3c, #80d99d);
            border-radius: 2px;
            margin: 0 auto;
        }
        .decorative-line-gold {
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #d4a017, #f6d365);
            border-radius: 2px;
            margin: 0 auto;
        }

        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(0,109,60,0.2); }
            50% { box-shadow: 0 0 40px rgba(0,109,60,0.4); }
        }
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-background text-on-background font-body-md antialiased overflow-x-hidden">

    <!-- ==================== NAVBAR ==================== -->
    <nav class="fixed top-0 left-0 right-0 w-full z-50 shadow-sm bg-surface/90 backdrop-blur-md transition-all duration-300" id="navbar">
        <div class="flex justify-between items-center h-16 sm:h-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <span class="material-symbols-outlined text-primary text-2xl sm:text-3xl group-hover:scale-110 transition-transform" style="font-variation-settings: 'FILL' 1;">mosque</span>
                <span class="font-playfair text-lg sm:text-xl font-bold text-primary group-hover:text-gold transition-colors">PAM Pesantunan</span>
            </a>

            <div class="hidden md:flex items-center gap-4 lg:gap-6">
                {{-- PERBAIKAN DI SINI (request()->routeIs) --}}
                <a class="text-on-surface-variant hover:text-primary transition-colors font-jakarta font-medium text-sm @if(request()->routeIs('home')) text-primary font-bold border-b-2 border-primary @endif" href="{{ route('home') }}">Beranda</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-jakarta font-medium text-sm @if(request()->routeIs('about')) text-primary font-bold border-b-2 border-primary @endif" href="{{ route('about') }}">Tentang</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-jakarta font-medium text-sm @if(request()->routeIs('gallery')) text-primary font-bold border-b-2 border-primary @endif" href="{{ route('gallery') }}">Galeri</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-jakarta font-medium text-sm @if(request()->routeIs('news')) text-primary font-bold border-b-2 border-primary @endif" href="{{ route('news') }}">Berita</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-jakarta font-medium text-sm @if(request()->routeIs('contact')) text-primary font-bold border-b-2 border-primary @endif" href="{{ route('contact') }}">Kontak</a>
            </div>

            <div class="hidden md:flex items-center gap-2 lg:gap-3">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-surface text-secondary border border-secondary rounded-full font-jakarta text-sm font-medium hover:bg-surface-container-low transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-surface text-secondary border border-secondary rounded-full font-jakarta text-sm font-medium hover:bg-surface-container-low transition-colors">Login</a>
                @endauth
                
            </div>

            <button class="md:hidden text-on-surface" id="mobileMenuBtn" aria-label="Toggle menu">
                <span class="material-symbols-outlined text-2xl">menu</span>
            </button>
        </div>

        <div id="mobileMenu" class="hidden md:hidden bg-surface/95 backdrop-blur-md shadow-lg px-4 py-4 border-t border-outline-variant">
            <div class="flex flex-col space-y-3">
                {{-- PERBAIKAN DI SINI (request()->routeIs) --}}
                <a class="text-on-surface-variant hover:text-primary transition-colors font-jakarta font-medium text-sm @if(request()->routeIs('home')) text-primary font-bold @endif" href="{{ route('home') }}">Beranda</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-jakarta font-medium text-sm @if(request()->routeIs('about')) text-primary font-bold @endif" href="{{ route('about') }}">Tentang</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-jakarta font-medium text-sm @if(request()->routeIs('gallery')) text-primary font-bold @endif" href="{{ route('gallery') }}">Galeri</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-jakarta font-medium text-sm @if(request()->routeIs('news')) text-primary font-bold @endif" href="{{ route('news') }}">Berita</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors font-jakarta font-medium text-sm @if(request()->routeIs('contact')) text-primary font-bold @endif" href="{{ route('contact') }}">Kontak</a>
                
                <div class="flex flex-col gap-2 pt-3 border-t border-outline-variant">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="w-full text-center px-4 py-2 bg-surface text-secondary border border-secondary rounded-full font-jakarta text-sm font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center px-4 py-2 bg-surface text-secondary border border-secondary rounded-full font-jakarta text-sm font-medium">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ==================== CONTENT ==================== -->
    <main class="pt-16 sm:pt-20">
        @yield('content')
    </main>

    <!-- ==================== FOOTER ==================== -->
    <footer class="w-full mt-12 sm:mt-16 lg:mt-20 border-t border-outline-variant bg-surface-container-lowest">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 py-8 sm:py-10 lg:py-12 max-w-[1440px] mx-auto">
            <div class="sm:col-span-2 lg:col-span-2">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-primary text-2xl" style="font-variation-settings: 'FILL' 1;">mosque</span>
                    <span class="font-playfair text-lg font-bold text-primary">PAM Pesantunan</span>
                </div>
                <p class="font-body-md text-base text-on-surface-variant max-w-md mb-3">
                    Lembaga kesejahteraan sosial anak yang berdedikasi untuk memberikan masa depan yang cerah melalui pendidikan, pengasuhan islami, dan transparansi donasi berbasis digital.
                </p>
                <p class="font-body-md text-base text-primary">© 2024 Panti Asuhan Muhammadiyah Pesantunan. Amanah &amp; Transparan.</p>
            </div>
            <div>
                <h4 class="font-playfair text-lg text-on-surface mb-3">Tautan Cepat</h4>
                <ul class="space-y-2">
                    <li><a class="font-body-md text-base text-on-surface-variant hover:text-primary transition-colors" href="#">Kebijakan Privasi</a></li>
                    <li><a class="font-body-md text-base text-on-surface-variant hover:text-primary transition-colors" href="#">Syarat &amp; Ketentuan</a></li>
                    <li><a class="font-body-md text-base text-on-surface-variant hover:text-primary transition-colors" href="#">Laporan Keuangan</a></li>
                    <li><a class="font-body-md text-base text-on-surface-variant hover:text-primary transition-colors" href="{{ route('contact') }}">Hubungi Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-playfair text-lg text-on-surface mb-3">Hubungi Kami</h4>
                <ul class="space-y-2">
                    <li class="flex items-start gap-2 text-on-surface-variant font-body-md text-base">
                        <span class="material-symbols-outlined text-primary mt-0.5 text-sm">location_on</span>
                        <span>Jl. Pesantunan Raya No. 123, Tegal, Jawa Tengah</span>
                    </li>
                    <li class="flex items-center gap-2 text-on-surface-variant font-body-md text-base">
                        <span class="material-symbols-outlined text-primary text-sm">phone</span>
                        <span>(0283) 1234567</span>
                    </li>
                    <li class="flex items-center gap-2 text-on-surface-variant font-body-md text-base">
                        <span class="material-symbols-outlined text-primary text-sm">mail</span>
                        <span>info@pampesantunan.or.id</span>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
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