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
        .menu-icon {
            @apply w-6 text-center text-gray-600;
        }
    </style>
</head>

<body class="h-full bg-gray-50 font-sans antialiased text-gray-800">

    <div x-data="{
        sidebarOpen: false,
        sidebarMinimized: false,
        isMobile: false,

        init() {
            this.checkScreenSize();

            
            if (localStorage.getItem('sidebarMinimized') === 'true') {
                this.sidebarMinimized = true;
            }
        },

        checkScreenSize() {
            const width = window.innerWidth;
            const wasMobile = this.isMobile;

            this.isMobile = width < 768;

            
            if (this.isMobile !== wasMobile) {
                this.sidebarOpen = !this.isMobile; 
            }

            
            if (!this.isMobile) {
                this.sidebarOpen = true;
            }
        },

        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        },

        toggleMinimize() {
            this.sidebarMinimized = !this.sidebarMinimized;
            localStorage.setItem('sidebarMinimized', this.sidebarMinimized);
        }
    }"
         @resize.window.debounce.150="checkScreenSize()"
         class="flex min-h-screen relative">

        {{-- ==================== SIDEBAR ==================== --}}
        <aside
            :class="{
                'fixed inset-y-0 left-0 z-50 h-screen bg-white shadow-xl flex flex-col transition-all duration-300 ease-in-out': isMobile,
                'md:relative md:shadow-lg': !isMobile,
                'translate-x-0': sidebarOpen,
                '-translate-x-full': !sidebarOpen && isMobile,
                'md:w-72': sidebarOpen && !sidebarMinimized && !isMobile,
                'md:w-20': sidebarOpen && sidebarMinimized && !isMobile,
                'md:w-0 md:opacity-0 md:pointer-events-none': !sidebarOpen && !isMobile
            }"
            x-cloak
            aria-label="Sidebar">

            <div class="flex flex-col h-full overflow-hidden whitespace-nowrap">
            {{-- Header Sidebar --}}
            <div class="flex items-center justify-between h-16 px-6 bg-gradient-to-r from-emerald-500 to-green-600 text-white flex-shrink-0" :class="sidebarMinimized ? 'justify-center px-0' : ''">
                <div class="flex items-center space-x-3" :class="sidebarMinimized ? 'justify-center' : ''">
                    <i class="fas fa-mosque text-xl"></i>
                    <h1 class="text-lg font-bold tracking-wide" x-show="!sidebarMinimized" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Keuangan Panti</h1>
                </div>
            </div>

            {{-- User Info --}}
            <div class="p-5 bg-gray-50 border-b border-gray-200 flex-shrink-0">
                <div class="flex items-center gap-3" :class="sidebarMinimized ? 'justify-center' : ''">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-lg">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden" x-show="!sidebarMinimized" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Selamat datang</p>
                        <p class="text-sm font-medium text-gray-800 truncate" title="{{ auth()->user()->name }}">{{ auth()->user()->name }}</p>
                    </div>
                </div>
                <div class="mt-2" x-show="!sidebarMinimized" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>
                    <span class="inline-block px-3 py-1 text-xs font-medium text-emerald-700 bg-emerald-100 rounded-full">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
            </div>

            {{-- Navigasi Menu --}}
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto" @click="if($event.target.closest('a')) sidebarOpen = false">
                @if(auth()->user()->role === 'admin')
                    <x-sidebar-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                        <i class="fas fa-home menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Dashboard</span>
                    </x-sidebar-link>

                    <x-sidebar-dropdown title="Master Data" icon='<i class="fas fa-database menu-icon"></i>' :active="request()->is('admin/saldo-awal*', 'admin/donatur*', 'admin/karyawan*', 'admin/anak-panti*', 'admin/daftar-akun*', 'admin/identitas-panti*', 'admin/aset-tetap*', 'admin/inventaris*', 'admin/barang*')">
                        <x-sidebar-link href="/admin/saldo-awal" :active="request()->is('admin/saldo-awal*')"><i class="fas fa-balance-scale menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Saldo Awal</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/donatur" :active="request()->is('admin/donatur*')"><i class="fas fa-heart menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Donatur</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/karyawan" :active="request()->is('admin/karyawan*')"><i class="fas fa-user menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Karyawan</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/anak-panti" :active="request()->is('admin/anak-panti*')"><i class="fas fa-child menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Anak Panti</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/daftar-akun" :active="request()->is('admin/daftar-akun*')"><i class="fas fa-list-ul menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Daftar Akun</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/identitas-panti/edit" :active="request()->is('admin/identitas-panti*')"><i class="fas fa-building menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Identitas Panti</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/aset-tetap" :active="request()->is('admin/aset-tetap*')"><i class="fas fa-landmark menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Aset Tetap</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/inventaris" :active="request()->is('admin/inventaris*')"><i class="fas fa-boxes-stacked menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Inventaris</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/barang" :active="request()->is('admin/barang*')"><i class="fas fa-box menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Barang</span></x-sidebar-link>
                    </x-sidebar-dropdown>

                    <x-sidebar-dropdown title="Transaksi" icon='<i class="fas fa-exchange-alt menu-icon"></i>' :active="request()->is('admin/penerimaan-donasi*', 'admin/donasi-barang*', 'admin/kas-besar*', 'admin/kas-kecil*', 'admin/pengeluaran*', 'admin/jurnal-umum*')">
                        <x-sidebar-link href="/admin/penerimaan-donasi" :active="request()->is('admin/penerimaan-donasi*')"><i class="fas fa-hand-holding-heart menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Penerimaan Donasi</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/donasi-barang" :active="request()->is('admin/donasi-barang*')"><i class="fas fa-gift menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Donasi Barang</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/penjualan-pemakaian-barang" :active="request()->is('admin/penjualan-pemakaian-barang*')"><i class="fas fa-shopping-cart menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Penjualan/Pemakaian Barang</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/kas-besar" :active="request()->is('admin/kas-besar*')"><i class="fas fa-wallet menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Kas Besar</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/kas-kecil" :active="request()->is('admin/kas-kecil*')"><i class="fas fa-wallet menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Kas Kecil</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/pengeluaran" :active="request()->is('admin/pengeluaran*')"><i class="fas fa-money-bill-transfer menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Pengeluaran</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/jurnal-umum" :active="request()->is('admin/jurnal-umum*')"><i class="fas fa-book-open menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Jurnal Umum</span></x-sidebar-link>
                    </x-sidebar-dropdown>

                    <x-sidebar-dropdown title="Laporan & Log" icon='<i class="fas fa-chart-line menu-icon"></i>' :active="request()->is('admin/laporan*', 'admin/buku-besar*', 'admin/arus-kas*', 'admin/tutup-buku*', 'admin/audit-log*')">
                        <x-sidebar-link href="/admin/laporan" :active="request()->is('admin/laporan*')"><i class="fas fa-file-invoice-dollar menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Laporan Keuangan</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/buku-besar" :active="request()->is('admin/buku-besar*')"><i class="fas fa-book menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Laporan Buku Besar</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/arus-kas" :active="request()->is('admin/arus-kas*')"><i class="fas fa-exchange-alt menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Laporan Arus Kas</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/tutup-buku" :active="request()->is('admin/tutup-buku*')"><i class="fas fa-lock menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Tutup Buku</span></x-sidebar-link>
                        <x-sidebar-link href="/admin/audit-log" :active="request()->is('admin/audit-log*')"><i class="fas fa-history menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Audit Log</span></x-sidebar-link>
                    </x-sidebar-dropdown>

                    <div class="pt-4 mt-4 border-t border-gray-200">
                        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2" x-show="!sidebarMinimized" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Pengaturan</p>
                        <x-sidebar-link href="{{ route('admin.profile.edit') }}" :active="request()->routeIs('admin.profile.*')">
                            <i class="fas fa-user-cog menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Profile Saya</span>
                        </x-sidebar-link>

                        <x-sidebar-link href="{{ route('admin.staff.index') }}" :active="request()->routeIs('admin.staff.*')">
                            <i class="fas fa-users-cog menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Kelola Staff</span>
                        </x-sidebar-link>
                    </div>

                @else
                    <x-sidebar-link href="{{ route('staff.dashboard') }}" :active="request()->routeIs('staff.dashboard')">
                        <i class="fas fa-home menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Dashboard</span>
                    </x-sidebar-link>

                    <x-sidebar-dropdown title="Transaksi" icon='<i class="fas fa-exchange-alt menu-icon"></i>' :active="request()->is('staff/penerimaan-donasi*', 'staff/pengeluaran*', 'staff/jurnal-umum*')">
                        <x-sidebar-link href="{{ route('staff.penerimaan-donasi.create') }}" :active="request()->routeIs('staff.penerimaan-donasi.*')">
                            <i class="fas fa-plus-circle menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Input Donasi</span>
                        </x-sidebar-link>
                        <x-sidebar-link href="{{ route('staff.pengeluaran.create') }}" :active="request()->routeIs('staff.pengeluaran.*')">
                            <i class="fas fa-minus-circle menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Input Pengeluaran</span>
                        </x-sidebar-link>
                        <x-sidebar-link href="/staff/jurnal-umum" :active="request()->is('staff/jurnal-umum*')"><i class="fas fa-book-open menu-icon"></i> <span x-show="!sidebarMinimized" class="ml-3" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Lihat Jurnal</span></x-sidebar-link>
                    </x-sidebar-dropdown>
                @endif

                {{-- Bottom Section: Toggle & Logout --}}
                <div class="mt-auto">
                    <!-- Tombol Minimize / Expand (Desktop) -->
                    <div class="hidden md:block px-4 pt-4 mt-4 border-t border-gray-200">
                        <button @click="toggleMinimize()"
                                class="w-full flex items-center gap-4 px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-xl transition duration-200 font-medium group"
                                :class="sidebarMinimized ? 'justify-center' : ''">
                            <i class="fas" :class="sidebarMinimized ? 'fa-angle-double-right' : 'fa-angle-double-left'"></i>
                            <span x-show="!sidebarMinimized">Perkecil Sidebar</span>
                        </button>

                        <!-- Tombol Tutup Total (Desktop) -->
                        <button @click="sidebarOpen = false"
                                class="mt-2 w-full flex items-center justify-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-xl transition duration-200">
                            <i class="fas fa-times"></i>
                            <span x-show="!sidebarMinimized">Sembunyikan Sidebar</span>
                        </button>
                    </div>
                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="px-2">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-4 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition duration-200 font-medium group" :class="sidebarMinimized ? 'justify-center' : ''">
                            <i class="fas fa-sign-out-alt menu-icon group-hover:text-red-600"></i>
                            <span x-show="!sidebarMinimized" class="whitespace-nowrap" x-transition:enter.opacity.duration.300ms.delay.100ms x-transition:leave.opacity.duration.100ms>Keluar</span>
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
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
             x-cloak>
        </div>

        {{-- ==================== MAIN CONTENT ==================== --}}
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300">
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4 flex items-center justify-between flex-shrink-0 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="toggleSidebar()" class="text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800">Panti Muhammadiyah Pesantunan</h2>
                </div>
                
                <div class="flex items-center gap-5">
                    <!-- Notifikasi Dropdown -->
                    @php
                        // Mengambil 5 aktivitas terakhir dari database (Spatie Activitylog)
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
                        <button @click="open = !open" class="text-gray-500 hover:text-gray-700 focus:outline-none relative">
                            <i class="fas fa-bell text-xl"></i>
                            <!-- Badge Indikator -->
                            <span x-show="hasUnread" x-cloak class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white transform translate-x-1/4 -translate-y-1/4"></span>
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
                                        <p class="text-sm text-gray-800 font-medium">{{ $notif->description }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $notif->causer->name ?? 'Sistem' }} • {{ $notif->created_at->diffForHumans() }}</p>
                                    </div>
                                @empty
                                    <div class="px-4 py-3 text-center text-gray-500 text-xs">Belum ada aktivitas baru.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="text-sm text-gray-500 hidden sm:block border-l pl-5 border-gray-300">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6 lg:p-8 bg-gray-50 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>