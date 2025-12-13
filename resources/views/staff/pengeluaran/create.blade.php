<!-- resources/views/staff/pengeluaran/create.blade.php -->
@extends('layouts.app')
@section('title', 'Input Pengeluaran')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-8">Input Pengeluaran Operasional</h1>

        <form action="{{ route('staff.pengeluaran.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                           class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Akun Beban</label>
                    <select name="kode_akun" required class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-400">
                        <option value="">Pilih Akun</option>
                        @foreach(\App\Models\DaftarAkun::where('kelompok', 'BEBAN')->orderBy('kode_akun')->get() as $a)
                            <option value="{{ $a->kode_akun }}">{{ $a->kode_akun }} - {{ $a->nama_akun }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah (Rp)</label>
                    <input type="number" name="jumlah" required min="1"
                           class="w-full px-4 py-3 rounded-xl border text-2xl font-bold text-red-600 focus:ring-2 focus:ring-emerald-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No. Bukti (Opsional)</label>
                    <input type="text" name="no_bukti" value="{{ old('no_bukti') }}"
                           class="w-full px-4 py-3 rounded-xl border">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="4" required placeholder="Contoh: Pembayaran listrik bulan ini"
                              class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-400"></textarea>
                </div>
            </div>

            <div class="mt-10 flex justify-end space-x-4">
                <a href="{{ route('staff.dashboard') }}"
                   class="px-8 py-3 bg-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-10 py-3 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition shadow-md">
                    Simpan & Buat Jurnal Otomatis
                </button>
            </div>
        </form>
    </div>
</div>
@endsection