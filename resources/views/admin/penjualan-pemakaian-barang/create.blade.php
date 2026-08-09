@extends('layouts.app')
@section('title', 'Catat Transaksi Barang Keluar')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Catat Transaksi Barang Keluar</h1>
        <a href="{{ route('admin.penjualan-pemakaian-barang.index') }}" class="text-gray-600 hover:text-gray-900 text-sm flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-6 lg:p-8">
        <form action="{{ route('admin.penjualan-pemakaian-barang.store') }}" method="POST" 
              x-data="{ 
                  jenis: '{{ old('jenis_transaksi') }}',
                  items: {{ json_encode(old('items', [['barang_id' => '', 'qty' => 1, 'harga_jual' => 0, 'total_nilai' => 0, 'stok' => 0, 'price' => 0]])) }},
                  addItem() {
                      this.items.push({ barang_id: '', qty: 1, harga_jual: 0, total_nilai: 0, stok: 0, price: 0 });
                  },
                  removeItem(index) {
                      if (this.items.length > 1) this.items.splice(index, 1);
                  },
                  updateItem(index, event) {
                      const option = event.target.options[event.target.selectedIndex];
                      this.items[index].price = parseFloat(option.dataset.price || 0);
                      this.items[index].stok = parseFloat(option.dataset.stok || 0);
                      this.items[index].total_nilai = this.items[index].qty * this.items[index].price;
                  }
              }">
            @csrf

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
                    <p class="font-bold mb-1">Terjadi Kesalahan:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6">

                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                    @error('tanggal')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Transaksi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Transaksi *</label>
                    <select name="jenis_transaksi" x-model="jenis" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                        <option value="">-- Pilih Jenis Transaksi --</option>
                        <option value="pemakaian">Pemakaian (Internal)</option>
                        <option value="penjualan">Penjualan</option>
                    </select>
                    @error('jenis_transaksi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Daftar Barang -->
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Barang</h3>
                        <button type="button" @click="addItem()" class="text-sm bg-blue-50 text-blue-600 px-3 py-1 rounded hover:bg-blue-100 font-medium">
                            + Tambah Baris
                        </button>
                    </div>

                    <template x-for="(item, index) in items" :key="index">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4 relative">
                            <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                <!-- Barang -->
                                <div class="md:col-span-5">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Barang *</label>
                                    <select :name="'items['+index+'][barang_id]'" x-model="item.barang_id" @change="updateItem(index, $event)" required class="block w-full border border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 p-2">
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach($barangs as $b)
                                            <option value="{{ $b->id }}" data-price="{{ $b->harga_beli_rata2 }}" data-stok="{{ $b->stok_saat_ini }}">
                                                {{ $b->nama_barang }} (Stok: {{ $b->stok_saat_ini }} {{ $b->satuan }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Qty -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Qty *</label>
                                    <input type="number" :name="'items['+index+'][qty]'" x-model="item.qty" @input="item.total_nilai = item.qty * (item.price || 0)" min="1" required class="block w-full border border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 p-2">
                                    <p class="text-[10px] text-gray-500 mt-0.5" x-show="item.barang_id">Stok: <span x-text="item.stok"></span></p>
                                </div>

                                <!-- Harga Jual (Khusus Penjualan) -->
                                <div class="md:col-span-5" x-show="jenis === 'penjualan'">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Harga Jual (Rp) *</label>
                                    <input type="number" :name="'items['+index+'][harga_jual]'" x-model="item.harga_jual" min="0" class="block w-full border border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 p-2">
                                </div>

                                <!-- Total Nilai (Khusus Pemakaian) -->
                                <div class="md:col-span-5" x-show="jenis === 'pemakaian'">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Total Nilai (Cost) *</label>
                                    <input type="number" :name="'items['+index+'][total_nilai]'" x-model="item.total_nilai" min="0" class="block w-full border border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 p-2 bg-gray-100">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Akun - Penjualan -->
                <div x-show="jenis === 'penjualan'" class="space-y-6 border-t border-gray-100 pt-4">
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <h3 class="text-sm font-bold text-blue-800 mb-4">Akun Keuangan (Penjualan)</h3>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Masuk ke Akun (Kas/Bank) *</label>
                                <select name="kode_akun_kas" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                                    <option value="">-- Pilih Akun Kas/Bank --</option>
                                    @foreach($akunKas as $ak)
                                        <option value="{{ $ak->kode_akun }}" {{ old('kode_akun_kas') == $ak->kode_akun ? 'selected' : '' }}>
                                            {{ $ak->kode_akun }} - {{ $ak->nama_akun }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kode_akun_kas')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Akun Pendapatan *</label>
                                <select name="kode_akun_pendapatan" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                                    <option value="">-- Pilih Akun Pendapatan --</option>
                                    @foreach($akunPendapatan as $ap)
                                        <option value="{{ $ap->kode_akun }}" {{ old('kode_akun_pendapatan') == $ap->kode_akun ? 'selected' : '' }}>
                                            {{ $ap->kode_akun }} - {{ $ap->nama_akun }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kode_akun_pendapatan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Akun - Pemakaian -->
                <div x-show="jenis === 'pemakaian'" class="space-y-6 border-t border-gray-100 pt-4">
                    <div class="bg-orange-50 p-4 rounded-lg border border-orange-100">
                        <h3 class="text-sm font-bold text-orange-800 mb-4">Akun Beban (Pemakaian)</h3>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Akun Beban (Debit) *</label>
                                <select name="kode_akun_beban" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                                    <option value="">-- Pilih Akun Beban --</option>
                                    @foreach($akunBeban as $ab)
                                        <option value="{{ $ab->kode_akun }}" {{ old('kode_akun_beban') == $ab->kode_akun ? 'selected' : '' }}>
                                            {{ $ab->kode_akun }} - {{ $ab->nama_akun }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kode_akun_beban')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Akun Persediaan (Kredit) *</label>
                                <select name="kode_akun_persediaan" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">
                                    <option value="">-- Pilih Akun Persediaan --</option>
                                    @foreach($akunPersediaan as $ap)
                                        <option value="{{ $ap->kode_akun }}" {{ old('kode_akun_persediaan') == $ap->kode_akun ? 'selected' : '' }}>
                                            {{ $ap->kode_akun }} - {{ $ap->nama_akun }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kode_akun_persediaan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keterangan Umum (opsional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan (Opsional)</label>
                    <textarea name="keterangan" rows="3" placeholder="Contoh: Penjualan sisa barang bekas / Pemakaian untuk kegiatan panti"
                              class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2">{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('admin.penjualan-pemakaian-barang.index') }}"
                   class="px-6 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection