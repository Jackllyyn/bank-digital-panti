@extends('layouts.app')
@section('title', 'Saldo Awal Tahun')

@section('content')
    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">

            <!-- Header + Tombol Export -->
            <div
                class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-green-50 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h1 class="text-lg font-bold text-gray-800">Saldo Awal Tahun {{ $tahun }}</h1>
                    <p class="text-xs text-gray-600 mt-1">Pilih kelompok akun untuk mengatur saldo awal</p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin.saldo-awal.export-all') }}"
                        class="inline-flex items-center px-4 py-2 text-xs font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition">
                        <i class="fas fa-file-excel mr-2"></i> Export Semua
                    </a>

                    <a href="{{ route('admin.saldo-awal.export-pdf') }}"
                        class="inline-flex items-center px-4 py-2 text-xs font-medium text-white bg-red-600 rounded-md hover:bg-red-700 transition"
                        target="_blank">
                        <i class="fas fa-file-pdf mr-2"></i> Cetak PDF
                    </a>
                    <form action="{{ route('admin.saldo-awal.export-kelompok') }}" method="POST" id="form-export"
                        class="hidden">
                        @csrf
                        <input type="hidden" name="kelompok" id="export-kelompok-value">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-xs font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition">
                            <i class="fas fa-download mr-2"></i> Export Kelompok Ini
                        </button>
                        <!-- Di dalam div flex gap-3 bersama tombol export excel -->
                    </form>
                </div>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.saldo-awal.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelompok Akun</label>
                        <select id="kelompok"
                            class="w-full max-w-xs px-4 py-2.5 text-sm rounded-md border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">-- Pilih Kelompok --</option>
                            <option value="ASET">ASET</option>
                            <option value="LIABILITAS">LIABILITAS</option>
                            <option value="EKUITAS">EKUITAS</option>
                            <option value="PENDAPATAN">PENDAPATAN</option>
                            <option value="BEBAN">BEBAN</option>
                        </select>
                    </div>

                    <div id="form-kelompok" class="hidden mt-6 space-y-4">
                        <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                            <h3 class="text-base font-semibold text-gray-800 mb-4">
                                Kelompok: <span id="nama-kelompok" class="text-emerald-600"></span>
                            </h3>

                            <div id="daftar-akun" class="space-y-3"></div>

                            <div class="mt-6 flex justify-end gap-3">
                                <button type="button" id="btn-batal"
                                    class="px-5 py-2 text-sm border border-gray-300 rounded-md hover:bg-gray-100 transition">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-6 py-2 text-sm bg-emerald-600 text-white font-medium rounded-md hover:bg-emerald-700 transition shadow-sm">
                                    Simpan Semua
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const akunData = @json($akunGrouped);
        const select = document.getElementById('kelompok');
        const container = document.getElementById('form-kelompok');
        const title = document.getElementById('nama-kelompok');
        const list = document.getElementById('daftar-akun');
        const formExport = document.getElementById('form-export');
        const exportInput = document.getElementById('export-kelompok-value');

        select.addEventListener('change', function () {
            const kelompok = this.value;

            if (!kelompok) {
                container.classList.add('hidden');
                formExport.classList.add('hidden');
                return;
            }

            const data = akunData[kelompok] || {};
            title.textContent = kelompok;
            list.innerHTML = '';

            Object.entries(data).forEach(([kode, a]) => {
                const row = document.createElement('div');
                row.className = 'flex items-center justify-between bg-white px-4 py-3 rounded-md border border-gray-200';

                row.innerHTML = `
                <div class="flex-1">
                    <div class="text-xs font-mono text-gray-500">${a.kode}</div>
                    <div class="text-sm font-medium text-gray-800 mt-0.5">${a.nama}</div>
                </div>
                <div class="w-40 ml-6">
                    <input type="number" name="saldo[${a.kode}]" value="${a.saldo}" step="any"
                           placeholder="0"
                           class="w-full px-3 py-2 text-sm text-right rounded border border-gray-300 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div class="ml-3 text-xs font-medium ${a.posisi === 'DEBET' ? 'text-green-600' : 'text-red-600'}">
                    ${a.posisi === 'DEBET' ? 'D' : 'K'}
                </div>
            `;
                list.appendChild(row);
            });

            container.classList.remove('hidden');
            exportInput.value = kelompok;
            formExport.classList.remove('hidden');
            container.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });

        document.getElementById('btn-batal').addEventListener('click', () => {
            select.value = '';
            container.classList.add('hidden');
            formExport.classList.add('hidden');
        });
    </script>

    @if(session('success'))
        <div class="fixed bottom-5 right-5 bg-emerald-600 text-white px-5 py-3 rounded-lg shadow-lg text-sm z-50">
            {{ session('success') }}
        </div>
        <script>setTimeout(() => document.querySelector('.fixed.bottom-5')?.remove(), 4000);</script>
    @endif
@endsection