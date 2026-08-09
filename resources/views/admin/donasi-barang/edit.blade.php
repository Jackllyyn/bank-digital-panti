@extends('layouts.app')
@section('title', 'Edit Donasi Barang')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Donasi Barang</h1>
        <a href="{{ route('admin.donasi-barang.index') }}" class="text-gray-600 hover:text-gray-900 text-sm flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6 lg:p-8">
        <form action="{{ route('admin.donasi-barang.update', $donasi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">

                <!-- Info Transaksi -->
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 text-sm text-blue-800 mb-2">
                    <strong>No Transaksi:</strong> {{ $donasi->no_transaksi }}
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $donasi->tanggal->format('Y-m-d')) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                    @error('tanggal')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Donatur (opsional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Donatur (opsional)</label>
                    <select name="kode_donatur" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                        <option value="">-- Umum / Tidak diketahui --</option>
                        @foreach($donaturs as $d)
                            <option value="{{ $d->kode_donatur }}" {{ old('kode_donatur', $donasi->kode_donatur) == $d->kode_donatur ? 'selected' : '' }}>
                                {{ $d->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Akun Debet (Aset/Persediaan) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Akun Debet (Aset/Persediaan) *</label>
                    <select name="kode_akun_debet" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                        <option value="">-- Pilih Akun Debet --</option>
                        @foreach($akunDebet as $ad)
                            <option value="{{ $ad->kode_akun }}" {{ old('kode_akun_debet', $currentDebit) == $ad->kode_akun ? 'selected' : '' }}>
                                {{ $ad->kode_akun }} - {{ $ad->nama_akun }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Pilih akun Aset (misal: Persediaan Barang, Peralatan, Kendaraan) yang bertambah.</p>
                </div>

                <!-- Akun Pendapatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Akun Pendapatan *</label>
                    <select name="kode_akun" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                        <option value="">-- Pilih Akun Pendapatan --</option>
                        @foreach($akuns as $akun)
                            <option value="{{ $akun->kode_akun }}" {{ old('kode_akun', $donasi->kode_akun) == $akun->kode_akun ? 'selected' : '' }}>
                                {{ $akun->kode_akun }} - {{ $akun->nama_akun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Dynamic Items Section -->
                <div x-data="{
                    items: {{ json_encode(array_values(old('items', $items->toArray()))) }},
                    errors: {{ json_encode($errors->messages()) }},
                    addItem() {
                        this.items.push({ barang_id: '', qty: 1, nilai_satuan: 0, deskripsi_barang: '' });
                    },
                    removeItem(index) {
                        if (this.items.length > 1) {
                            this.items.splice(index, 1);
                        }
                    },
                    formatRupiah(number) {
                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
                    },
                    get totalEstimasi() {
                        return this.items.reduce((sum, item) => sum + (item.qty * item.nilai_satuan), 0);
                    },
                    getError(field) {
                        return this.errors[field] ? this.errors[field][0] : '';
                    }
                }" class="border-t border-gray-200 pt-4">
                    
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Barang</h3>
                        <button type="button" @click="addItem()" class="text-sm bg-blue-50 text-blue-600 px-3 py-1 rounded hover:bg-blue-100 font-medium">
                            + Tambah Barang
                        </button>
                    </div>

                    <template x-for="(item, index) in items" :key="index">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                                <!-- Barang -->
                                <div class="md:col-span-4">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Barang *</label>
                                    <select :name="'items['+index+'][barang_id]'" x-model="item.barang_id" required class="block w-full border border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 p-2">
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach($barangs as $b)
                                            <option value="{{ $b->id }}">{{ $b->nama_barang }} ({{ $b->satuan }})</option>
                                        @endforeach
                                    </select>
                                    <p x-show="getError('items.'+index+'.barang_id')" x-text="getError('items.'+index+'.barang_id')" class="text-red-500 text-xs mt-1"></p>
                                </div>

                                <!-- Qty -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Qty *</label>
                                    <input type="number" :name="'items['+index+'][qty]'" x-model="item.qty" min="1" required class="block w-full border border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 p-2">
                                    <p x-show="getError('items.'+index+'.qty')" x-text="getError('items.'+index+'.qty')" class="text-red-500 text-xs mt-1"></p>
                                </div>

                                <!-- Nilai Satuan -->
                                <div class="md:col-span-3">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Nilai Satuan (Rp) *</label>
                                    <input type="number" :name="'items['+index+'][nilai_satuan]'" x-model="item.nilai_satuan" min="0" required class="block w-full border border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 p-2">
                                    <p x-show="getError('items.'+index+'.nilai_satuan')" x-text="getError('items.'+index+'.nilai_satuan')" class="text-red-500 text-xs mt-1"></p>
                                </div>

                                <!-- Deskripsi -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Ket. Barang (Opsional)</label>
                                    <input type="text" :name="'items['+index+'][deskripsi_barang]'" x-model="item.deskripsi_barang" placeholder="Merk/Kondisi" class="block w-full border border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 p-2">
                                </div>

                                <!-- Hapus -->
                                <div class="md:col-span-1 flex justify-center md:justify-end pb-0.5">
                                    <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="text-red-500 hover:text-red-700 p-2 rounded hover:bg-red-50 transition" title="Hapus baris">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="text-right font-bold text-gray-700 mt-2">
                        Total Estimasi Nilai: <span x-text="formatRupiah(totalEstimasi)" class="text-green-600 text-xl"></span>
                    </div>
                </div>

                <!-- Keterangan Umum (opsional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Umum (opsional)</label>
                    <textarea name="keterangan" rows="3" placeholder="Contoh: Donasi bulanan dari keluarga Bapak Ahmad"
                              class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">{{ old('keterangan', $donasi->keterangan) }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('admin.donasi-barang.index') }}"
                   class="px-6 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection