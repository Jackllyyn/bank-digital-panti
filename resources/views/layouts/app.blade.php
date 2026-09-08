<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Keuangan Panti</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        [x-cloak] { display: none !important; }
        
        /* ===== SIDEBAR STYLING ===== */
        .menu-icon {
            width: 1.5rem;
            text-align: center;
            color: #9ca3af;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-content {
            overflow: hidden;
            white-space: nowrap;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 9999px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        .menu-group-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 1rem 0.4rem 1rem;
            margin-top: 0.25rem;
            font-size: 0.7rem;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .menu-group-header .group-icon {
            font-size: 0.7rem;
            color: #d1d5db;
            width: 1.5rem;
            text-align: center;
            flex-shrink: 0;
        }

        .menu-group-header .group-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, #e5e7eb, transparent);
            margin-left: 0.25rem;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 1rem;
            margin: 0.1rem 0.5rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            color: #4b5563;
            font-weight: 500;
            font-size: 0.9rem;
            position: relative;
            cursor: pointer;
            text-decoration: none;
        }

        .menu-item:hover {
            background-color: #ecfdf5;
            color: #065f46;
        }

        .menu-item.active {
            background-color: #ecfdf5;
            color: #065f46;
            font-weight: 600;
        }

        .menu-item.active .menu-icon {
            color: #065f46;
        }

        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 24px;
            background-color: #059669;
            border-radius: 0 4px 4px 0;
        }

        .menu-item .menu-icon {
            width: 1.5rem;
            text-align: center;
            font-size: 1.1rem;
            color: #9ca3af;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .menu-item:hover .menu-icon {
            color: #065f46;
        }

        .menu-item.active .menu-icon {
            color: #065f46;
        }

        .menu-item .menu-text {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .menu-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 1rem;
            margin: 0.1rem 0.5rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            color: #4b5563;
            font-weight: 500;
            font-size: 0.9rem;
            width: calc(100% - 1rem);
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
        }

        .menu-dropdown-toggle:hover {
            background-color: #ecfdf5;
            color: #065f46;
        }

        .menu-dropdown-toggle.active {
            background-color: #ecfdf5;
            color: #065f46;
            font-weight: 600;
        }

        .menu-dropdown-toggle .menu-icon {
            width: 1.5rem;
            text-align: center;
            font-size: 1.1rem;
            color: #9ca3af;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .menu-dropdown-toggle:hover .menu-icon {
            color: #065f46;
        }

        .menu-dropdown-toggle.active .menu-icon {
            color: #065f46;
        }

        .menu-dropdown-toggle .menu-text {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .menu-dropdown-children {
            margin-left: 0.5rem;
            padding-left: 0.75rem;
            border-left: 2px solid #e5e7eb;
        }

        .menu-dropdown-children .menu-item {
            padding: 0.45rem 1rem 0.45rem 0.5rem;
            margin: 0.05rem 0.25rem;
            font-size: 0.85rem;
        }

        .menu-dropdown-children .menu-item .menu-icon {
            font-size: 0.9rem;
            width: 1.5rem;
        }

        .menu-divider {
            border-top: 1px solid #e5e7eb;
            margin: 0.5rem 1rem;
        }

        .menu-logout {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 1rem;
            margin: 0.1rem 0.5rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            color: #dc2626;
            font-size: 0.9rem;
            font-weight: 500;
            background: none;
            border: none;
            cursor: pointer;
            width: calc(100% - 1rem);
        }

        .menu-logout:hover {
            background-color: #fef2f2;
            color: #b91c1c;
        }

        .menu-logout .menu-icon {
            width: 1.5rem;
            text-align: center;
            font-size: 1.1rem;
            color: #dc2626;
            flex-shrink: 0;
        }

        .menu-logout:hover .menu-icon {
            color: #b91c1c;
        }

        .menu-logout .menu-text {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dropdown-arrow {
            transition: transform 0.3s ease;
            font-size: 0.75rem;
            color: #9ca3af;
            flex-shrink: 0;
        }

        .dropdown-arrow.open {
            transform: rotate(180deg);
        }

        @media (max-width: 767px) {
            .menu-item, .menu-dropdown-toggle, .menu-logout {
                font-size: 0.95rem;
                padding: 0.75rem 1rem;
            }
            .menu-dropdown-children .menu-item {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body class="h-full bg-gray-50 font-sans antialiased text-gray-800">

    <div x-data="sidebarHandler()" 
         x-init="init()"
         @resize.window.debounce.150="handleResize()"
         class="flex min-h-screen relative">

        {{-- ==================== SIDEBAR ==================== --}}
        <aside
            :class="{
                'fixed inset-y-0 left-0 z-50 h-screen bg-white shadow-xl flex flex-col sidebar-transition': isMobile,
                'md:relative md:shadow-lg': !isMobile,
                'translate-x-0': sidebarOpen,
                '-translate-x-full': !sidebarOpen && isMobile,
                'md:w-80': sidebarOpen && !isMobile,
                'md:w-0 md:opacity-0 md:pointer-events-none': !sidebarOpen && !isMobile
            }"
            x-cloak
            aria-label="Sidebar Navigation">

            <div class="flex flex-col h-full overflow-hidden sidebar-content">
                {{-- Header Sidebar --}}
                <div class="flex items-center justify-between h-16 px-6 bg-gradient-to-r from-emerald-600 to-green-600 text-white flex-shrink-0">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-mosque text-2xl"></i>
                        <h1 class="text-lg font-bold tracking-wide" 
                            x-show="sidebarOpen" 
                            x-transition:enter.opacity.duration.300ms.delay.100ms 
                            x-transition:leave.opacity.duration.100ms>
                            Keuangan Panti
                        </h1>
                    </div>
                    <button @click="toggleSidebar()" 
                            class="md:hidden text-white hover:text-gray-200 focus:outline-none p-1 rounded-lg hover:bg-white/10 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                {{-- User Info --}}
                <div class="p-5 bg-gradient-to-b from-gray-50 to-white border-b border-gray-200 flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-lg flex-shrink-0 shadow-md">
                            {{ auth()->user() ? substr(auth()->user()->name, 0, 1) : '?' }}
                        </div>
                        <div class="overflow-hidden" 
                             x-show="sidebarOpen" 
                             x-transition:enter.opacity.duration.300ms.delay.100ms 
                             x-transition:leave.opacity.duration.100ms>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Selamat datang</p>
                            <p class="text-sm font-semibold text-gray-800 truncate" 
                               title="{{ auth()->user() ? auth()->user()->name : '' }}">
                                {{ auth()->user() ? auth()->user()->name : '' }}
                            </p>
                            <span class="inline-block mt-1 px-2.5 py-0.5 text-xs font-medium text-emerald-700 bg-emerald-100 rounded-full">
                                {{ auth()->user() ? ucfirst(auth()->user()->role) : '' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Navigasi Menu --}}
                <nav class="flex-1 px-2 py-3 overflow-y-auto sidebar-scroll" 
                     @click="if($event.target.closest('a') && isMobile) sidebarOpen = false">
                    
                    @if(auth()->user() && auth()->user()->role === 'admin')
                        {{-- ===== MENU ADMIN ===== --}}
                        
                        {{-- GROUP 1: Utama --}}
                        <div class="menu-group-header" x-show="sidebarOpen">
                            <i class="fas fa-th-large group-icon"></i>
                            <span>Utama</span>
                            <span class="group-line"></span>
                        </div>
                        
                        {{-- Dashboard --}}
                        <a href="{{ route('admin.dashboard') }}" 
                           class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-th-large menu-icon"></i> 
                            <span class="menu-text" 
                                  x-show="sidebarOpen" 
                                  x-transition:enter.opacity.duration.300ms.delay.100ms 
                                  x-transition:leave.opacity.duration.100ms>
                                Dashboard
                            </span>
                        </a>

                        {{-- ==================== PENGURUS ==================== --}}
                        @php
                            $isPengurusActive = request()->is('admin/pengurus*');
                        @endphp
                        <div x-data="{ open: {{ $isPengurusActive ? 'true' : 'false' }} }">
                            <button @click="open = !open" 
                                    class="menu-dropdown-toggle {{ $isPengurusActive ? 'active' : '' }}">
                                <i class="fas fa-users menu-icon"></i>
                                <span class="menu-text" 
                                      x-show="sidebarOpen"
                                      x-transition:enter.opacity.duration.300ms.delay.100ms 
                                      x-transition:leave.opacity.duration.100ms>
                                    Pengurus
                                </span>
                                <i class="fas fa-chevron-down dropdown-arrow" 
                                   :class="open ? 'open' : ''"
                                   x-show="sidebarOpen"></i>
                            </button>
                            <div x-show="open && sidebarOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="menu-dropdown-children">
                                <a href="{{ route('admin.pengurus.index') }}" class="menu-item {{ request()->routeIs('admin.pengurus.index') ? 'active' : '' }}">
                                    <i class="fas fa-list menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Daftar Pengurus</span>
                                </a>
                                <a href="{{ route('admin.pengurus.create') }}" class="menu-item {{ request()->routeIs('admin.pengurus.create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Tambah Pengurus</span>
                                </a>
                            </div>
                        </div>

                        {{-- ==================== GALERI ==================== --}}
                        @php
                            $isGaleriActive = request()->is('admin/galeri*');
                        @endphp
                        <div x-data="{ open: {{ $isGaleriActive ? 'true' : 'false' }} }">
                            <button @click="open = !open" 
                                    class="menu-dropdown-toggle {{ $isGaleriActive ? 'active' : '' }}">
                                <i class="fas fa-images menu-icon"></i>
                                <span class="menu-text" 
                                      x-show="sidebarOpen"
                                      x-transition:enter.opacity.duration.300ms.delay.100ms 
                                      x-transition:leave.opacity.duration.100ms>
                                    Galeri
                                </span>
                                <i class="fas fa-chevron-down dropdown-arrow" 
                                   :class="open ? 'open' : ''"
                                   x-show="sidebarOpen"></i>
                            </button>
                            <div x-show="open && sidebarOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="menu-dropdown-children">
                                <a href="{{ route('admin.galeri.index') }}" class="menu-item {{ request()->routeIs('admin.galeri.index') ? 'active' : '' }}">
                                    <i class="fas fa-list menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Daftar Galeri</span>
                                </a>
                                <a href="{{ route('admin.galeri.create') }}" class="menu-item {{ request()->routeIs('admin.galeri.create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Tambah Galeri</span>
                                </a>
                            </div>
                        </div>

                        {{-- ==================== BERITA ==================== --}}
                        @php
                            $isBeritaActive = request()->is('admin/berita*');
                        @endphp
                        <div x-data="{ open: {{ $isBeritaActive ? 'true' : 'false' }} }">
                            <button @click="open = !open" 
                                    class="menu-dropdown-toggle {{ $isBeritaActive ? 'active' : '' }}">
                                <i class="fas fa-newspaper menu-icon"></i>
                                <span class="menu-text" 
                                      x-show="sidebarOpen"
                                      x-transition:enter.opacity.duration.300ms.delay.100ms 
                                      x-transition:leave.opacity.duration.100ms>
                                    Berita
                                </span>
                                <i class="fas fa-chevron-down dropdown-arrow" 
                                   :class="open ? 'open' : ''"
                                   x-show="sidebarOpen"></i>
                            </button>
                            <div x-show="open && sidebarOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="menu-dropdown-children">
                                <a href="{{ route('admin.berita.index') }}" class="menu-item {{ request()->routeIs('admin.berita.index') ? 'active' : '' }}">
                                    <i class="fas fa-list menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Daftar Berita</span>
                                </a>
                                <a href="{{ route('admin.berita.create') }}" class="menu-item {{ request()->routeIs('admin.berita.create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Tambah Berita</span>
                                </a>
                            </div>
                        </div>

                        {{-- GROUP 2: Master Data --}}
                        <div class="menu-group-header" x-show="sidebarOpen">
                            <i class="fas fa-database group-icon"></i>
                            <span>Master Data</span>
                            <span class="group-line"></span>
                        </div>
                        
                        {{-- Dropdown Master Data --}}
                        @php
                            $isMasterDataActive = request()->is('admin/saldo-awal*', 'admin/donatur*', 'admin/karyawan*', 'admin/anak-panti*', 'admin/daftar-akun*', 'admin/identitas-panti*', 'admin/aset-tetap*', 'admin/inventaris*', 'admin/barang*');
                        @endphp
                        <div x-data="{ open: {{ $isMasterDataActive ? 'true' : 'false' }} }">
                            <button @click="open = !open" 
                                    class="menu-dropdown-toggle {{ $isMasterDataActive ? 'active' : '' }}">
                                <i class="fas fa-layer-group menu-icon"></i>
                                <span class="menu-text" 
                                      x-show="sidebarOpen"
                                      x-transition:enter.opacity.duration.300ms.delay.100ms 
                                      x-transition:leave.opacity.duration.100ms>
                                    Data Master
                                </span>
                                <i class="fas fa-chevron-down dropdown-arrow" 
                                   :class="open ? 'open' : ''"
                                   x-show="sidebarOpen"></i>
                            </button>
                            <div x-show="open && sidebarOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="menu-dropdown-children">
                                <a href="/admin/saldo-awal" class="menu-item {{ request()->is('admin/saldo-awal*') ? 'active' : '' }}">
                                    <i class="fas fa-balance-scale menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Saldo Awal</span>
                                </a>
                                <a href="/admin/donatur" class="menu-item {{ request()->is('admin/donatur*') ? 'active' : '' }}">
                                    <i class="fas fa-hand-holding-heart menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Donatur</span>
                                </a>
                                <a href="/admin/karyawan" class="menu-item {{ request()->is('admin/karyawan*') ? 'active' : '' }}">
                                    <i class="fas fa-users menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Karyawan</span>
                                </a>
                                <a href="/admin/anak-panti" class="menu-item {{ request()->is('admin/anak-panti*') ? 'active' : '' }}">
                                    <i class="fas fa-child menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Anak Panti</span>
                                </a>
                                <a href="/admin/daftar-akun" class="menu-item {{ request()->is('admin/daftar-akun*') ? 'active' : '' }}">
                                    <i class="fas fa-list-ul menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Daftar Akun</span>
                                </a>
                                <a href="/admin/identitas-panti/edit" class="menu-item {{ request()->is('admin/identitas-panti*') ? 'active' : '' }}">
                                    <i class="fas fa-building menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Identitas Panti</span>
                                </a>
                                <a href="/admin/aset-tetap" class="menu-item {{ request()->is('admin/aset-tetap*') ? 'active' : '' }}">
                                    <i class="fas fa-landmark menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Aset Tetap</span>
                                </a>
                                <a href="/admin/inventaris" class="menu-item {{ request()->is('admin/inventaris*') ? 'active' : '' }}">
                                    <i class="fas fa-boxes-stacked menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Inventaris</span>
                                </a>
                                <a href="/admin/barang" class="menu-item {{ request()->is('admin/barang*') ? 'active' : '' }}">
                                    <i class="fas fa-box menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Barang</span>
                                </a>
                            </div>
                        </div>

                        {{-- GROUP 3: Transaksi --}}
                        <div class="menu-group-header" x-show="sidebarOpen">
                            <i class="fas fa-exchange-alt group-icon"></i>
                            <span>Transaksi</span>
                            <span class="group-line"></span>
                        </div>
                        
                        {{-- Dropdown Transaksi --}}
                        @php
                            $isTransaksiActive = request()->is('admin/penerimaan-donasi*', 'admin/donasi-barang*', 'admin/kas-besar*', 'admin/kas-kecil*', 'admin/pengeluaran*', 'admin/jurnal-umum*', 'admin/penjualan-pemakaian-barang*');
                        @endphp
                        <div x-data="{ open: {{ $isTransaksiActive ? 'true' : 'false' }} }">
                            <button @click="open = !open" 
                                    class="menu-dropdown-toggle {{ $isTransaksiActive ? 'active' : '' }}">
                                <i class="fas fa-exchange-alt menu-icon"></i>
                                <span class="menu-text" 
                                      x-show="sidebarOpen"
                                      x-transition:enter.opacity.duration.300ms.delay.100ms 
                                      x-transition:leave.opacity.duration.100ms>
                                    Kelola Transaksi
                                </span>
                                <i class="fas fa-chevron-down dropdown-arrow" 
                                   :class="open ? 'open' : ''"
                                   x-show="sidebarOpen"></i>
                            </button>
                            <div x-show="open && sidebarOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="menu-dropdown-children">
                                <a href="/admin/penerimaan-donasi" class="menu-item {{ request()->is('admin/penerimaan-donasi*') ? 'active' : '' }}">
                                    <i class="fas fa-hand-holding-heart menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Penerimaan Donasi</span>
                                </a>
                                <a href="/admin/donasi-barang" class="menu-item {{ request()->is('admin/donasi-barang*') ? 'active' : '' }}">
                                    <i class="fas fa-gift menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Donasi Barang</span>
                                </a>
                                <a href="/admin/penjualan-pemakaian-barang" class="menu-item {{ request()->is('admin/penjualan-pemakaian-barang*') ? 'active' : '' }}">
                                    <i class="fas fa-shopping-cart menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Penjualan/Pemakaian Barang</span>
                                </a>
                                <a href="/admin/kas-besar" class="menu-item {{ request()->is('admin/kas-besar*') ? 'active' : '' }}">
                                    <i class="fas fa-wallet menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Kas Besar</span>
                                </a>
                                <a href="/admin/kas-kecil" class="menu-item {{ request()->is('admin/kas-kecil*') ? 'active' : '' }}">
                                    <i class="fas fa-coins menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Kas Kecil</span>
                                </a>
                                <a href="/admin/pengeluaran" class="menu-item {{ request()->is('admin/pengeluaran*') ? 'active' : '' }}">
                                    <i class="fas fa-arrow-right menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Pengeluaran</span>
                                </a>
                                <a href="/admin/jurnal-umum" class="menu-item {{ request()->is('admin/jurnal-umum*') ? 'active' : '' }}">
                                    <i class="fas fa-book-open menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Jurnal Umum</span>
                                </a>
                            </div>
                        </div>

                        {{-- GROUP 4: Laporan --}}
                        <div class="menu-group-header" x-show="sidebarOpen">
                            <i class="fas fa-chart-pie group-icon"></i>
                            <span>Laporan & Audit</span>
                            <span class="group-line"></span>
                        </div>
                        
                        {{-- Dropdown Laporan --}}
                        @php
                            $isLaporanActive = request()->is('admin/laporan*', 'admin/buku-besar*', 'admin/arus-kas*', 'admin/tutup-buku*', 'admin/audit-log*');
                        @endphp
                        <div x-data="{ open: {{ $isLaporanActive ? 'true' : 'false' }} }">
                            <button @click="open = !open" 
                                    class="menu-dropdown-toggle {{ $isLaporanActive ? 'active' : '' }}">
                                <i class="fas fa-chart-pie menu-icon"></i>
                                <span class="menu-text" 
                                      x-show="sidebarOpen"
                                      x-transition:enter.opacity.duration.300ms.delay.100ms 
                                      x-transition:leave.opacity.duration.100ms>
                                    Laporan & Log
                                </span>
                                <i class="fas fa-chevron-down dropdown-arrow" 
                                   :class="open ? 'open' : ''"
                                   x-show="sidebarOpen"></i>
                            </button>
                            <div x-show="open && sidebarOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="menu-dropdown-children">
                                <a href="/admin/laporan" class="menu-item {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                                    <i class="fas fa-file-invoice-dollar menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Laporan Keuangan</span>
                                </a>
                                <a href="/admin/buku-besar" class="menu-item {{ request()->is('admin/buku-besar*') ? 'active' : '' }}">
                                    <i class="fas fa-book menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Laporan Buku Besar</span>
                                </a>
                                <a href="/admin/arus-kas" class="menu-item {{ request()->is('admin/arus-kas*') ? 'active' : '' }}">
                                    <i class="fas fa-exchange-alt menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Laporan Arus Kas</span>
                                </a>
                                <a href="/admin/tutup-buku" class="menu-item {{ request()->is('admin/tutup-buku*') ? 'active' : '' }}">
                                    <i class="fas fa-lock menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Tutup Buku</span>
                                </a>
                                <a href="/admin/audit-log" class="menu-item {{ request()->is('admin/audit-log*') ? 'active' : '' }}">
                                    <i class="fas fa-history menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Audit Log</span>
                                </a>
                            </div>
                        </div>

                        {{-- GROUP 5: Pengaturan --}}
                        <div class="menu-divider" x-show="sidebarOpen"></div>
                        <div class="menu-group-header" x-show="sidebarOpen">
                            <i class="fas fa-cog group-icon"></i>
                            <span>Pengaturan</span>
                            <span class="group-line"></span>
                        </div>
                        
                        <a href="{{ route('admin.profile.edit') }}" 
                           class="menu-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                            <i class="fas fa-user-cog menu-icon"></i> 
                            <span class="menu-text" 
                                  x-show="sidebarOpen" 
                                  x-transition:enter.opacity.duration.300ms.delay.100ms 
                                  x-transition:leave.opacity.duration.100ms>
                                Profile Saya
                            </span>
                        </a>
                        <a href="{{ route('admin.staff.index') }}" 
                           class="menu-item {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                            <i class="fas fa-users-cog menu-icon"></i> 
                            <span class="menu-text" 
                                  x-show="sidebarOpen" 
                                  x-transition:enter.opacity.duration.300ms.delay.100ms 
                                  x-transition:leave.opacity.duration.100ms>
                                Kelola Staff
                            </span>
                        </a>

                    @else
                        {{-- ===== MENU STAFF ===== --}}
                        
                        {{-- GROUP 1: Utama --}}
                        <div class="menu-group-header" x-show="sidebarOpen">
                            <i class="fas fa-th-large group-icon"></i>
                            <span>Utama</span>
                            <span class="group-line"></span>
                        </div>
                        
                        <a href="{{ route('staff.dashboard') }}" 
                           class="menu-item {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-th-large menu-icon"></i> 
                            <span class="menu-text" 
                                  x-show="sidebarOpen" 
                                  x-transition:enter.opacity.duration.300ms.delay.100ms 
                                  x-transition:leave.opacity.duration.100ms>
                                Dashboard
                            </span>
                        </a>

                        {{-- GROUP 2: Transaksi --}}
                        <div class="menu-group-header" x-show="sidebarOpen">
                            <i class="fas fa-exchange-alt group-icon"></i>
                            <span>Transaksi</span>
                            <span class="group-line"></span>
                        </div>
                        
                        @php
                            $isStaffTransaksiActive = request()->is('staff/penerimaan-donasi*', 'staff/pengeluaran*', 'staff/jurnal-umum*');
                        @endphp
                        <div x-data="{ open: {{ $isStaffTransaksiActive ? 'true' : 'false' }} }">
                            <button @click="open = !open" 
                                    class="menu-dropdown-toggle {{ $isStaffTransaksiActive ? 'active' : '' }}">
                                <i class="fas fa-exchange-alt menu-icon"></i>
                                <span class="menu-text" 
                                      x-show="sidebarOpen"
                                      x-transition:enter.opacity.duration.300ms.delay.100ms 
                                      x-transition:leave.opacity.duration.100ms>
                                    Kelola Transaksi
                                </span>
                                <i class="fas fa-chevron-down dropdown-arrow" 
                                   :class="open ? 'open' : ''"
                                   x-show="sidebarOpen"></i>
                            </button>
                            <div x-show="open && sidebarOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="menu-dropdown-children">
                                <a href="{{ route('staff.penerimaan-donasi.create') }}" 
                                   class="menu-item {{ request()->routeIs('staff.penerimaan-donasi.*') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Input Donasi</span>
                                </a>
                                <a href="{{ route('staff.pengeluaran.create') }}" 
                                   class="menu-item {{ request()->routeIs('staff.pengeluaran.*') ? 'active' : '' }}">
                                    <i class="fas fa-minus-circle menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Input Pengeluaran</span>
                                </a>
                                <a href="/staff/jurnal-umum" 
                                   class="menu-item {{ request()->is('staff/jurnal-umum*') ? 'active' : '' }}">
                                    <i class="fas fa-book-open menu-icon"></i> 
                                    <span class="menu-text" x-show="sidebarOpen">Lihat Jurnal</span>
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Logout --}}
                    <div class="menu-divider" x-show="sidebarOpen"></div>
                    <div class="px-0 pt-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="menu-logout">
                                <i class="fas fa-sign-out-alt menu-icon"></i>
                                <span class="menu-text" 
                                      x-show="sidebarOpen" 
                                      x-transition:enter.opacity.duration.300ms.delay.100ms 
                                      x-transition:leave.opacity.duration.100ms>
                                    Keluar
                                </span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </aside>

        {{-- Overlay Mobile --}}
        <div x-show="sidebarOpen && isMobile" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="toggleSidebar()"
             class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
             x-cloak>
        </div>

        {{-- ==================== MAIN CONTENT ==================== --}}
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300">
            {{-- Header --}}
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4 flex items-center justify-between flex-shrink-0 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="toggleSidebar()" 
                            class="text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out p-2 hover:bg-gray-100 rounded-lg"
                            aria-label="Toggle sidebar">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800">Panti Muhammadiyah Pesantunan</h2>
                </div>
                
                <div class="flex items-center gap-5">
                    {{-- Notifikasi Dropdown --}}
                    @php
                        $notifications = \Spatie\Activitylog\Models\Activity::with('causer')
                            ->latest()
                            ->take(5)
                            ->get();
                        $latestId = $notifications->first()?->id ?? 0;
                    @endphp
                    <div x-data="{ 
                            open: false,
                            latestId: {{ $latestId }},
                            hasUnread: false,
                            init() {
                                const lastRead = localStorage.getItem('lastReadActivityId');
                                this.hasUnread = this.latestId > (lastRead || 0);
                                
                                this.$watch('open', value => {
                                    if (value && this.hasUnread) {
                                        this.hasUnread = false;
                                        localStorage.setItem('lastReadActivityId', this.latestId);
                                    }
                                });
                            }
                        }" class="relative">
                        <button @click="open = !open" 
                                class="text-gray-500 hover:text-gray-700 focus:outline-none relative p-2 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-bell text-xl"></i>
                            <span x-show="hasUnread" 
                                  x-cloak 
                                  class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white transform translate-x-1/4 -translate-y-1/4">
                            </span>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false"
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-100 z-50 overflow-hidden">
                            
                            <div class="px-4 py-3 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                                <h3 class="text-sm font-semibold text-gray-700">Notifikasi</h3>
                                <span class="text-xs text-gray-500">Terbaru</span>
                            </div>

                            <div class="max-h-64 overflow-y-auto">
                                @forelse($notifications as $notif)
                                    <div class="px-4 py-3 hover:bg-gray-50 transition border-b border-gray-100">
                                        <p class="text-sm text-gray-800 font-medium">{{ Str::limit($notif->description, 50) }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $notif->causer->name ?? 'Sistem' }} • {{ $notif->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                @empty
                                    <div class="px-4 py-3 text-center text-gray-500 text-xs">
                                        Belum ada aktivitas baru.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Tanggal --}}
                    <div class="text-sm text-gray-500 hidden sm:block border-l pl-5 border-gray-300">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>
            </header>

            {{-- Main Content --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8 bg-gray-50 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- ==================== JAVASCRIPT HANDLER ==================== --}}
    <script>
        function sidebarHandler() {
            return {
                sidebarOpen: false,
                isMobile: false,

                init() {
                    this.checkScreenSize();
                    this.sidebarOpen = !this.isMobile;
                },

                checkScreenSize() {
                    const width = window.innerWidth;
                    const wasMobile = this.isMobile;
                    this.isMobile = width < 768;

                    if (this.isMobile !== wasMobile) {
                        this.sidebarOpen = !this.isMobile;
                    }
                },

                handleResize() {
                    this.checkScreenSize();
                },

                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                }
            }
        }
    </script>

</body>
</html>