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
</head>
<body class="h-full bg-gray-50 font-sans antialiased text-gray-800">

    {{-- AlpineJS utama: sidebar otomatis terbuka di layar ≥1024px (lg) --}}
    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="flex min-h-screen">

        {{-- ==================== SIDEBAR ==================== --}}
        <aside :class="sidebarOpen ? 'w-72' : 'w-0'"
               class="h-screen bg-white shadow-xl transition-all duration-300 ease-in-out overflow-hidden flex flex-col"
               aria-label="Sidebar">

            {{-- Header Sidebar --}}
            <div class="flex items-center justify-between h-16 px-6 bg-gradient-to-r from-emerald-500 to-green-600 text-white flex-shrink-0">
                <div class="flex items-center space-x-3" x-show="sidebarOpen" x-transition>
                    <i class="fas fa-mosque text-xl"></i>
                    <h1 class="text-lg font-bold tracking-wide">Keuangan Panti</h1>
                </div>
                <button @click="sidebarOpen = false"
                        x-show="sidebarOpen"
                        class="text-white hover:bg-white/20 rounded p-2">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            {{-- User Info --}}
            <div x-show="sidebarOpen" x-transition class="p-5 bg-gray-50 border-b border-gray-200 flex-shrink-0">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Selamat datang</p>
                <p class="mt-1 text-base font-medium text-gray-800 truncate">{{ auth()->user()->name }}</p>
                <span class="inline-block px-3 py-1 mt-2 text-xs font-medium text-emerald-700 bg-emerald-100 rounded-full">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>

            {{-- Navigasi Menu --}}
            <nav x-show="sidebarOpen" x-transition class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                @if(auth()->user()->role === 'admin')
                    <x-sidebar-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </x-sidebar-link>

                    <x-sidebar-dropdown title="Master Data" icon='<i class="fas fa-database"></i>'>
                        <x-sidebar-link href="/admin/saldo-awal"><i class="fas fa-balance-scale mr-3"></i> Saldo Awal</x-sidebar-link>
                        <x-sidebar-link href="/admin/donatur"><i class="fas fa-users mr-3"></i> Donatur</x-sidebar-link>
                        <x-sidebar-link href="/admin/anak-panti"><i class="fas fa-child mr-3"></i> Anak Panti</x-sidebar-link>
                        <x-sidebar-link href="/admin/daftar-akun"><i class="fas fa-list-ul mr-3"></i> Daftar Akun</x-sidebar-link>
                        <x-sidebar-link href="/admin/identitas-panti/edit"><i class="fas fa-building mr-3"></i> Identitas Panti</x-sidebar-link>
                        <x-sidebar-link href="/admin/aset-tetap"><i class="fas fa-home mr-3"></i> Aset Tetap</x-sidebar-link>
                        <x-sidebar-link href="/admin/inventaris"><i class="fas fa-boxes-stacked mr-3"></i> Inventaris</x-sidebar-link>
                    </x-sidebar-dropdown>

                    <x-sidebar-dropdown title="Transaksi" icon='<i class="fas fa-exchange-alt"></i>'>
                        <x-sidebar-link href="/admin/penerimaan-donasi"><i class="fas fa-hand-holding-heart mr-3"></i> Penerimaan Donasi</x-sidebar-link>
                        <x-sidebar-link href="/admin/pengeluaran"><i class="fas fa-money-bill-wave mr-3"></i> Pengeluaran</x-sidebar-link>
                        <x-sidebar-link href="/admin/jurnal-umum"><i class="fas fa-book mr-3"></i> Jurnal Umum</x-sidebar-link>
                    </x-sidebar-dropdown>

                    <x-sidebar-dropdown title="Laporan & Log" icon='<i class="fas fa-chart-bar"></i>'>
                        <x-sidebar-link href="/admin/laporan"><i class="fas fa-file-invoice-dollar mr-3"></i> Laporan Keuangan</x-sidebar-link>
                        <x-sidebar-link href="/admin/audit-log"><i class="fas fa-history mr-3"></i> Audit Log</x-sidebar-link>
                    </x-sidebar-dropdown>

                    <x-sidebar-link href="{{ route('admin.profile.edit') }}" :active="request()->routeIs('admin.profile.*')">
                        <i class="fas fa-user-cog"></i> Profile Saya
                    </x-sidebar-link>

                    <x-sidebar-link href="{{ route('admin.staff.index') }}" :active="request()->routeIs('admin.staff.*')">
                        <i class="fas fa-users-cog"></i> Kelola Staff
                    </x-sidebar-link>

                @else
                    <x-sidebar-link href="{{ route('staff.dashboard') }}" :active="request()->routeIs('staff.dashboard')">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </x-sidebar-link>

                    <x-sidebar-dropdown title="Transaksi" icon='<i class="fas fa-exchange-alt"></i>'>
                        <x-sidebar-link href="{{ route('staff.penerimaan-donasi.create') }}">
                            <i class="fas fa-plus-circle mr-3"></i> Input Donasi
                        </x-sidebar-link>
                        <x-sidebar-link href="{{ route('staff.pengeluaran.create') }}">
                            <i class="fas fa-minus-circle mr-3"></i> Input Pengeluaran
                        </x-sidebar-link>
                        <x-sidebar-link href="/staff/jurnal-umum"><i class="fas fa-book mr-3"></i> Lihat Jurnal</x-sidebar-link>
                    </x-sidebar-dropdown>
                @endif

                {{-- Logout --}}
                <div class="mt-auto pt-6 border-t border-gray-200">
                    <form method="POST" action="{{ route('logout') }}" class="px-2">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition duration-200 font-medium">
                            <i class="fas fa-sign-out-alt mr-3"></i> Keluar
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        {{-- ==================== MAIN CONTENT ==================== --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Header --}}
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4 flex items-center justify-between flex-shrink-0">
                {{-- Tombol Hamburger (selalu muncul) --}}
                <button @click="sidebarOpen = !sidebarOpen"
                        class="text-emerald-600 hover:text-emerald-700 z-10">
                    <i class="fas fa-bars text-2xl"></i>
                </button>

                {{-- Nama Panti & Tanggal --}}
                <div class="flex items-center space-x-6">
                    <h2 class="text-xl font-semibold text-gray-800">Panti Muhammadiyah Pesantunan</h2>
                    <div class="text-sm text-gray-500 hidden sm:block">
                        {{ now()->translatedFormat('d F Y') }}
                    </div>
                </div>

                <div></div> {{-- spacer kanan --}}
            </header>

            {{-- Konten Utama --}}
            <main class="flex-1 p-6 lg:p-10 bg-gray-50 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Overlay gelap hanya di mobile saat sidebar terbuka --}}
    <div x-show="sidebarOpen && window.innerWidth < 1024"
         x-transition.opacity
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden">
    </div>

</body>

</html>