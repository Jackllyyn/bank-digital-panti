@extends('layouts.app')
@section('title', 'Tutup Buku Akhir Tahun')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-red-600 text-white">
            <h1 class="text-lg font-semibold">Tutup Buku (Closing Entry)</h1>
            <p class="text-red-100 text-xs mt-1">Proses ini akan memindahkan Laba/Rugi berjalan ke akun Modal.</p>
        </div>

        <div class="p-6">
            @if(session('error'))
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 text-red-700">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('admin.tutup-buku.store') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin melakukan tutup buku? Tindakan ini akan membuat Jurnal Penutup otomatis.');">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Pilih Tahun -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tutup Buku Tahun</label>
                        <select name="tahun" class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
                            @for($i = date('Y'); $i >= date('Y')-5; $i--)
                                <option value="{{ $i }}" {{ $i == $tahun ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Semua akun Pendapatan & Beban pada tahun ini akan dinolkan.</p>
                    </div>

                    <!-- Pilih Akun Modal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pindahkan Laba/Rugi ke Akun</label>
                        <select name="akun_tujuan" class="w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500" required>
                            <option value="">-- Pilih Akun Modal / Laba Ditahan --</option>
                            @foreach($akunModal as $akun)
                                <option value="{{ $akun->kode_akun }}">{{ $akun->kode_akun }} - {{ $akun->nama_akun }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Biasanya akun "Laba Ditahan" atau "Modal Yayasan".</p>
                    </div>
                </div>

                <!-- Opsi Tambahan -->
                <div class="mt-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="generate_saldo_next_year" name="generate_saldo_next_year" type="checkbox" value="1" checked class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="generate_saldo_next_year" class="font-medium text-gray-700">Generate Saldo Awal Tahun Berikutnya Otomatis</label>
                            <p class="text-gray-500">Jika dicentang, sistem akan menghitung saldo akhir tahun ini dan menyimpannya sebagai saldo awal tahun depan. Akun Pendapatan & Beban akan menjadi 0.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center gap-2">
                        <i class="fas fa-lock"></i>
                        Proses Tutup Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection