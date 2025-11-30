<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Dashboard Staff Keuangan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-4xl font-bold text-blue-600">Halo, Staff!</h1>
                    <p class="mt-4 text-lg">Anda login sebagai <strong>STAFF KEUANGAN</strong></p>

                    <div class="mt-10 space-x-4">
                        <a href="#" class="inline-block px-8 py-6 text-2xl font-bold text-white bg-green-600 rounded-lg hover:bg-green-700">
                            + Input Donasi
                        </a>
                        <a href="#" class="inline-block px-8 py-6 text-2xl font-bold text-white bg-red-600 rounded-lg hover:bg-red-700">
                            + Input Pengeluaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>