<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PAM Pesantunan - Panti Asuhan Muhammadiyah')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Google Fonts - Font Modern & Elegan -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Fraunces:ital,opsz,wght@0,9..144,300..900;1,9..144,300..900&family=Instrument+Serif:ital@0;1&family=Caveat:wght@400..700&family=JetBrains+Mono:wght@300..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        /* ===== FONT STACK ===== */
        body { 
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            font-feature-settings: 'ss01', 'cv11';
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Font Classes */
        .font-display   { font-family: 'Fraunces', serif; font-optical-sizing: auto; }
        .font-fraunces  { font-family: 'Fraunces', serif; font-optical-sizing: auto; }
        .font-playfair  { font-family: 'Playfair Display', serif; }
        .font-instrument{ font-family: 'Instrument Serif', serif; }
        .font-caveat    { font-family: 'Caveat', cursive; }
        .font-jakarta   { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono      { font-family: 'JetBrains Mono', monospace; }

        /* ===== WARNA ===== */
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

        /* ===== EFEK ===== */
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

        /* ===== TIPOGRAFI ===== */
        .font-display-lg   { font-family: 'Fraunces', serif; font-size: 48px; line-height: 56px; letter-spacing: -0.02em; font-weight: 700; }
        .font-headline-lg  { font-family: 'Fraunces', serif; font-size: 32px; line-height: 40px; letter-spacing: -0.01em; font-weight: 600; }
        .font-headline-md  { font-family: 'Fraunces', serif; font-size: 24px; line-height: 32px; font-weight: 600; }
        .font-title-lg     { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; line-height: 28px; font-weight: 600; letter-spacing: -0.01em; }
        .font-body-lg      { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 18px; line-height: 28px; font-weight: 400; }
        .font-body-md      { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; line-height: 24px; font-weight: 400; }
        .font-label-md     { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; line-height: 20px; letter-spacing: 0.01em; font-weight: 600; }
        .font-label-sm     { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; line-height: 16px; font-weight: 500; }

        /* Quote / aksen dekoratif */
        .font-quote {
            font-family: 'Instrument Serif', serif;
            font-style: italic;
            font-size: 22px;
            line-height: 32px;
        }

        @media (max-width: 768px) {
            .font-display-lg   { font-size: 32px; line-height: 40px; }
            .font-headline-lg  { font-size: 24px; line-height: 32px; }
        }

        /* Text shadow */
        .text-shadow { text-shadow: 2px 2px 4px rgba(0,0,0,0.3); }
        .text-shadow-light { text-shadow: 1px 1px 2px rgba(0,0,0,0.2); }

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

        /* Animasi */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .float-animation { animation: float 3s ease-in-out infinite; }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(0,109,60,0.2); }
            50% { box-shadow: 0 0 40px rgba(0,109,60,0.4); }
        }
        .pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
    </style>
    @stack('styles')
</head>
<body class="bg-background text-on-background font-body-md antialiased overflow-x-hidden">
    {{-- Konten sama seperti sebelumnya --}}
    @include('layouts.partials.public-navbar')
    @yield('content')
    @include('layouts.partials.public-footer')
    @include('layouts.partials.public-scripts')
    @stack('scripts')
</body>
</html>