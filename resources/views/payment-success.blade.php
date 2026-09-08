@extends('layouts.public')

@section('title', 'Pembayaran Berhasil - PAM Pesantunan')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-6 text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-green-600 text-5xl">check_circle</span>
        </div>
        <h2 class="text-2xl font-bold text-green-700 mb-2">Pembayaran Berhasil!</h2>
        <p class="text-gray-600">Terima kasih telah berdonasi. Semoga menjadi amal jariyah yang bermanfaat.</p>

        <div class="bg-gray-50 rounded-lg p-4 mt-6 text-left">
            <div class="flex justify-between mb-2">
                <span class="text-gray-600">Order ID</span>
                <span class="font-semibold">{{ $donasi->order_id ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Jumlah Donasi</span>
                <span class="font-bold text-green-700">Rp {{ number_format($donasi->jumlah ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('home') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection