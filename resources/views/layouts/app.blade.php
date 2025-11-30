<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Keuangan Panti</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="h-full font-sans antialiased">

<div class="flex h-screen overflow-hidden bg-gray-50">
    <!-- SIDEBAR -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg border-r border-gray-200">
        <div class="flex items-center h-16 px-6 bg-blue-600">
            <h1 class="text-xl font-bold text-white">Keuangan Panti</h1>
        </div>

        <div class="p-4 bg-gray-50 border-b border-gray-200">
            <p class="text-xs font-semibold text-gray-500 uppercase">User</p>
            <p class="mt-1 text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
            <span class="inline-block px-2 py-1 mt-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-full">
                {{ ucfirst(auth()->user()->role) }}
            </span>
        </div>

        <nav class="p-3 mt-4 overflow-y-auto h-[calc(100vh-12rem)]">
            @if(auth()->user()->role === 'admin')
                <!-- Dashboard -->
                <x-sidebar-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </x-sidebar-link>

                <!-- Master Data Dropdown -->
                <x-sidebar-dropdown 
                    title="Master Data" 
                    icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/></svg>'
                    :active="request()->is('admin/donatur*') || request()->is('admin/anak-asuh*') || request()->is('admin/daftar-akun*') || request()->is('admin/identitas-panti*') || request()->is('admin/aset-tetap*') || request()->is('admin/inventaris*')">
                    
                    <x-sidebar-link href="/admin/donatur">Donatur</x-sidebar-link>
                    <x-sidebar-link href="/admin/anak-asuh">Anak Asuh</x-sidebar-link>
                    <x-sidebar-link href="/admin/daftar-akun">Daftar Akun</x-sidebar-link>
                    <x-sidebar-link href="/admin/identitas-panti/edit">Identitas Panti</x-sidebar-link>
                    <x-sidebar-link href="/admin/aset-tetap">Aset Tetap</x-sidebar-link>
                    <x-sidebar-link href="/admin/inventaris">Inventaris</x-sidebar-link>
                </x-sidebar-dropdown>

                <!-- Transaksi Dropdown -->
                <x-sidebar-dropdown 
                    title="Transaksi" 
                    icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>'
                    :active="request()->is('admin/penerimaan-donasi*') || request()->is('admin/pengeluaran*') || request()->is('admin/jurnal-umum*') || request()->is('admin/saldo-awal*')">
                    
                    <x-sidebar-link href="/admin/penerimaan-donasi">Penerimaan Donasi</x-sidebar-link>
                    <x-sidebar-link href="/admin/pengeluaran">Pengeluaran</x-sidebar-link>
                    <x-sidebar-link href="/admin/jurnal-umum">Jurnal Umum</x-sidebar-link>
                    <x-sidebar-link href="/admin/saldo-awal">Saldo Awal</x-sidebar-link>
                </x-sidebar-dropdown>

                <!-- Laporan & Log -->
                <x-sidebar-dropdown 
                    title="Laporan & Log" 
                    icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>'
                    :active="request()->is('admin/laporan*') || request()->is('admin/log-aktivitas*')">
                    
                    <x-sidebar-link href="/admin/laporan">Laporan Keuangan</x-sidebar-link>
                    <x-sidebar-link href="/admin/log-aktivitas">Audit Log</x-sidebar-link>
                </x-sidebar-dropdown>

            @else
                <!-- STAFF: Hanya Transaksi -->
                <x-sidebar-link href="{{ route('staff.dashboard') }}" :active="request()->routeIs('staff.dashboard')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </x-sidebar-link>

                <x-sidebar-dropdown title="Transaksi" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>'>
                    <x-sidebar-link href="/staff/penerimaan-donasi/create">Input Donasi</x-sidebar-link>
                    <x-sidebar-link href="/staff/pengeluaran/create">Input Pengeluaran</x-sidebar-link>
                    <x-sidebar-link href="/staff/jurnal-umum">Lihat Jurnal</x-sidebar-link>
                </x-sidebar-dropdown>
            @endif

            <!-- Logout -->
            <div class="mt-8 border-t border-gray-200 pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-6 py-3 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-md transition">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H3a3 3 0 01-3-3v-1m6-4V5a3 3 0 013-3h6a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </nav>
    </div>

    <!-- CONTENT -->
    <div class="flex-1 flex flex-col ml-64">
        <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">@yield('title')</h2>
                <p class="text-sm text-gray-500">{{ now()->format('d F Y') }}</p>
            </div>
        </header>
        <main class="flex-1 p-8 bg-gray-50 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>