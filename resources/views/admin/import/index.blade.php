@extends('layouts.app')
@section('title', 'Import Data')

@section('content')
    <div class="max-w-full mx-auto px-4 py-8">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <h1 class="text-2xl font-semibold text-gray-800">Import Data</h1>
            <div class="mt-4 sm:mt-0 flex flex-wrap gap-3">
                <a href="{{ route('admin.donatur.index') }}"
                   class="px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                    Kembali ke Daftar Donatur
                </a>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Donatur -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM6 21a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Donatur</h2>
                </div>
                <p class="text-gray-600 mb-4">Import data donatur dari file Excel</p>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('admin.import.template', 'donatur') }}"
                       class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-800 rounded-lg text-center text-sm font-medium transition">
                        Download Template
                    </a>

                    <!-- Form Import Sederhana (tanpa modal) -->
                    <form action="{{ route('admin.import.donatur') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Excel (.xlsx, .xls, .csv)</label>
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                            Import Sekarang
                        </button>
                    </form>
                </div>
            </div>

            {{-- <!-- Anak Panti -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Anak Panti</h2>
                </div>
                <p class="text-gray-600 mb-4">Import data anak panti dari file Excel</p>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('admin.import.template', 'anak-panti') }}"
                       class="px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-lg text-center text-sm font-medium transition">
                        Download Template
                    </a>

                    <!-- Form Import Sederhana (tanpa modal) -->
                    <form action="{{ route('admin.import.anak-panti') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Excel (.xlsx, .xls, .csv)</label>
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                            Import Sekarang
                        </button>
                    </form>
                </div>
            </div>

            <!-- Inventaris -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Inventaris</h2>
                </div>
                <p class="text-gray-600 mb-4">Import data inventaris barang dari file Excel</p>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('admin.import.template', 'inventaris') }}"
                       class="px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-800 rounded-lg text-center text-sm font-medium transition">
                        Download Template
                    </a>

                    <!-- Form Import Sederhana (tanpa modal) -->
                    <form action="{{ route('admin.import.inventaris') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Excel (.xlsx, .xls, .csv)</label>
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium transition">
                            Import Sekarang
                        </button>
                    </form>
                </div>
            </div>

            <!-- Aset Tetap -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-amber-100 rounded-lg">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h-4m-6 0H5" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Aset Tetap</h2>
                </div>
                <p class="text-gray-600 mb-4">Import data aset tetap dari file Excel</p>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('admin.import.template', 'aset-tetap') }}"
                       class="px-4 py-2 bg-amber-100 hover:bg-amber-200 text-amber-800 rounded-lg text-center text-sm font-medium transition">
                        Download Template
                    </a>

                    <!-- Form Import Sederhana (tanpa modal) -->
                    <form action="{{ route('admin.import.aset-tetap') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Excel (.xlsx, .xls, .csv)</label>
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm font-medium transition">
                            Import Sekarang
                        </button>
                    </form>
                </div>
            </div> --}}

        </div>
    </div>
@endsection