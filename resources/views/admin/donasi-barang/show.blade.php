@extends('layouts.app')
@section('title', 'Detail Donasi - ' . $donasi->no_transaksi)

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Detail Donasi Barang</h1>
            <a href="{{ route('admin.donasi-barang.struk', $donasi->id) }}" 
               class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                Cetak Struk
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <strong>No Transaksi:</strong> {{ $donasi->no_transaksi }}<br>
                <strong>Tanggal:</strong> {{ $donasi->tanggal->format('d F Y') }}<br>
                <strong>Donatur:</strong> {{ $donasi->donatur?->nama ?? 'Umum' }}
            </div>
            <div>
                <strong>Petugas:</strong> {{ $donasi->user?->name ?? 'Admin' }}<br>
                <strong>Keterangan:</strong> {{ $donasi->keterangan ?? '-' }}
            </div>
        </div>

        <h2 class="text-xl font-semibold mb-4">Detail Barang</h2>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-3">Barang</th>
                    <th class="border p-3">Deskripsi</th>
                    <th class="border p-3 text-right">Qty</th>
                    <th class="border p-3 text-right">Satuan</th>
                    <th class="border p-3 text-right">Nilai per Unit (Rp)</th>
                    <th class="border p-3 text-right">Total Nilai (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donasi->details as $detail)
                    <tr>
                        <td class="border p-3">{{ $detail->barang?->nama_barang ?? '-' }}</td>
                        <td class="border p-3">{{ $detail->deskripsi_barang ?? '-' }}</td>
                        <td class="border p-3 text-right">{{ number_format($detail->qty, 0, ',', '.') }}</td>
                        <td class="border p-3 text-right">{{ $detail->barang?->satuan ?? 'unit' }}</td>
                        <td class="border p-3 text-right">{{ number_format($detail->nilai_satuan ?? 0, 0, ',', '.') }}</td>
                        <td class="border p-3 text-right">{{ number_format($detail->total_nilai ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6 text-right font-semibold">
            Total Qty: {{ number_format($donasi->details->sum('qty'), 0, ',', '.') }}<br>
            Total Nilai Donasi: Rp {{ number_format($donasi->details->sum('total_nilai'), 0, ',', '.') }}
        </div>

        <div class="mt-10 flex justify-center gap-16 text-center">
            <div>
                <p class="mb-16">Mengetahui,<br>Pimpinan Panti</p>
                <p>(..........................................)</p>
            </div>
            <div>
                <p class="mb-16">Donatur / Pemberi</p>
                <p>{{ $donasi->donatur?->nama ?? '..........................................' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection