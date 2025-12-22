@extends('layouts.app')
@section('title', 'Daftar Akun')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-6 bg-green-600 text-white">
            <h1 class="text-2xl font-semibold">Daftar Akun Perkiraan</h1>
            <p class="text-green-100 mt-1">Master data akuntansi Panti Muhammadiyah Pesantunan</p>
        </div>

        <!-- Konten -->
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <p class="text-sm text-gray-600">
                        Total: <span class="font-semibold text-green-700">{{ $akuns->count() }}</span> akun
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        Saldo awal ditampilkan untuk tahun <span class="font-medium">{{ $tahun }}</span>
                    </p>
                </div>
                <a href="{{ route('admin.daftar-akun.create') }}"
                   class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                    <i class="fas fa-plus mr-2"></i> Tambah Akun
                </a>
            </div>

            <div class="space-y-6">
                @foreach(['ASET', 'LIABILITAS', 'EKUITAS', 'PENDAPATAN', 'BEBAN'] as $kelompok)
                    @php $data = $akuns->where('kelompok', $kelompok); @endphp
                    @if($data->count())
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <!-- Judul Kelompok -->
                            <div class="bg-green-50 px-6 py-4 font-medium text-green-800 border-b border-gray-200">
                                {{ $kelompok }}
                            </div>

                            <!-- Daftar Akun -->
                            <div class="divide-y divide-gray-100">
                                @foreach($data as $akun)
                                    @php
                                        // Ambil saldo dari tabel saldo_awal tahun berjalan
                                        // Jika belum ada data → default Rp 0
                                        $saldo = $akun->saldoAwal->first()?->saldo ?? 0;
                                    @endphp
                                    <div class="px-6 py-4 flex justify-between items-center hover:bg-gray-50 transition">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-4">
                                                <span class="font-mono font-semibold text-gray-900 w-20">{{ $akun->kode_akun }}</span>
                                                <span class="text-gray-800 font-medium">{{ $akun->nama_akun }}</span>
                                            </div>
                                            <div class="mt-1 flex items-center gap-4 text-sm">
                                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $akun->posisi_saldo == 'DEBET' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $akun->posisi_saldo }}
                                                </span>

                                                <!-- SELALU TAMPILKAN SALDO (bahkan jika 0) -->
                                                <span class="text-gray-600">
                                                    Saldo awal {{ $tahun }}:
                                                    <span class="font-semibold text-gray-900">
                                                        Rp {{ number_format($saldo, 0, ',', '.') }}
                                                    </span>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="flex gap-3">
                                            <a href="{{ route('admin.daftar-akun.edit', $akun->kode_akun) }}"
                                               class="text-green-600 hover:text-green-800">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.daftar-akun.destroy', $akun->kode_akun) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin ingin menghapus akun ini?')" class="text-red-600 hover:text-red-800">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection