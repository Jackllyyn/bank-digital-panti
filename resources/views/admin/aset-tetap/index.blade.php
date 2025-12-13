@extends('layouts.app')
@section('title', 'Aset Tetap')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-5 bg-green-600 text-white">
            <h1 class="text-xl font-semibold">Daftar Aset Tetap</h1>
            <p class="text-green-100 text-sm mt-1">Kelola aset tetap panti dengan mudah</p>
        </div>

        <div class="p-6">
            <div class="flex justify-between items-center mb-5">
                <p class="text-sm text-gray-600">
                    Total aset: <span class="font-semibold text-green-700">{{ $asets->count() }}</span>
                </p>
                <a href="{{ route('admin.aset-tetap.create') }}"
                   class="inline-flex items-center px-4 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i> Tambah Aset
                </a>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse($asets as $aset)
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
                        @if($aset->foto)
                            <img src="{{ asset('storage/' . $aset->foto) }}" alt="{{ $aset->nama_aset }}"
                                 class="w-full h-40 object-cover">
                        @else
                            <div class="bg-gray-100 h-40 flex items-center justify-center">
                                <i class="fas fa-building text-5xl text-gray-400"></i>
                            </div>
                        @endif

                        <div class="p-3">
                            <h3 class="font-medium text-sm text-gray-800 line-clamp-2">{{ $aset->nama_aset }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Kode: {{ $aset->kode_aset }}</p>

                            <div class="mt-2 space-y-1 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Perolehan</span>
                                    <span class="font-medium">{{ $aset->tanggal_perolehan->translatedFormat('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Harga</span>
                                    <span class="font-semibold text-green-700">
                                        Rp {{ number_format($aset->harga_perolehan, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Nilai Buku</span>
                                    <span class="font-semibold text-blue-700">
                                        Rp {{ number_format($aset->nilaiBuku(), 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('admin.aset-tetap.edit', $aset->kode_aset) }}"
                                   class="flex-1 text-center py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-xs font-medium">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button @click="hapus('{{ $aset->kode_aset }}')"
                                        class="flex-1 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-xs font-medium">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10">
                        <i class="fas fa-box-open text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Belum ada aset tetap</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function hapus(kode) {
    Swal.fire({
        title: 'Yakin hapus?',
        text: "Data aset ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/aset-tetap/${kode}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      Swal.fire('Terhapus!', 'Aset telah dihapus.', 'success')
                          .then(() => location.reload());
                  }
              });
        }
    });
}
</script>
@endsection