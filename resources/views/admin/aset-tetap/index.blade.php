@extends('layouts.app')
@section('title', 'Aset Tetap')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-5 bg-green-600 text-white">
            <h1 class="text-xl font-semibold">Daftar Aset Tetap</h1>
            <p class="text-green-100 text-sm mt-1">Kelola aset tetap panti dengan mudah</p>
        </div>

        <!-- Konten -->
        <div class="p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <p class="text-sm text-gray-600">
                    Total aset: <span class="font-semibold text-green-700">{{ $asets->count() }}</span>
                </p>
                <a href="{{ route('admin.aset-tetap.create') }}"
                   class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                    <i class="fas fa-plus mr-2"></i> Tambah Aset
                </a>
            </div>

            @if($asets->count() > 0)
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach($asets as $aset)
                        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition duration-300">
                            <!-- Foto Aset -->
                            <div class="relative h-48 bg-gray-50">
                                @if($aset->foto && file_exists(public_path('storage/' . $aset->foto)))
                                    <img src="{{ asset('storage/' . $aset->foto) }}"
                                         alt="{{ $aset->nama_aset }}"
                                         class="w-full h-full object-cover"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @endif

                                <!-- Placeholder jika foto tidak ada atau gagal load -->
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 {{ $aset->foto && file_exists(public_path('storage/' . $aset->foto)) ? 'hidden' : '' }}">
                                    <i class="fas fa-building text-6xl mb-3"></i>
                                    <p class="text-sm">Tidak ada foto</p>
                                </div>
                            </div>

                            <!-- Detail Aset -->
                            <div class="p-5">
                                <h3 class="font-semibold text-gray-800 line-clamp-2">{{ $aset->nama_aset }}</h3>
                                <p class="text-xs text-gray-500 mt-1">Kode: <span class="font-mono">{{ $aset->kode_aset }}</span></p>

                                <div class="mt-4 space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Perolehan</span>
                                        <span class="font-medium text-gray-800">
                                            {{ $aset->tanggal_perolehan->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Harga Perolehan</span>
                                        <span class="font-semibold text-green-700">
                                            Rp {{ number_format($aset->harga_perolehan, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Nilai Buku Saat Ini</span>
                                        <span class="font-semibold text-blue-700">
                                            Rp {{ number_format($aset->nilaiBuku(), 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="mt-6 flex gap-3">
                                    <a href="{{ route('admin.aset-tetap.edit', $aset->kode_aset) }}"
                                       class="flex-1 text-center py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium text-sm">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <button @click="hapus('{{ $aset->kode_aset }}')"
                                            class="flex-1 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm">
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-box-open text-7xl text-gray-300 mb-4"></i>
                    <p class="text-xl text-gray-500 font-medium">Belum ada aset tetap terdaftar</p>
                    <p class="text-gray-400 mt-2">Mulai tambahkan aset tetap panti sekarang</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function hapus(kode) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Aset ini akan dihapus secara permanen dan tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, hapus permanen',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Buat form sementara untuk submit DELETE
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/aset-tetap/${kode}`;
            form.style.display = 'none';

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';

            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = '{{ csrf_token() }}';

            form.appendChild(methodInput);
            form.appendChild(tokenInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection