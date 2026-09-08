@extends('layouts.public')

@section('title', 'Pembayaran Donasi - PAM Pesantunan')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-6">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-green-700">Konfirmasi Pembayaran</h2>
            <p class="text-gray-600 text-sm">Selesaikan pembayaran Anda</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="flex justify-between mb-2">
                <span class="text-gray-600">Order ID</span>
                <span class="font-semibold">{{ $orderId }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Total</span>
                <span class="font-bold text-green-700">Rp {{ number_format($donasi->jumlah ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <div id="payment-container">
            <button id="pay-button" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition">
                Bayar Sekarang
            </button>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('donation') }}" class="text-gray-500 hover:text-gray-700 text-sm">← Kembali ke Donasi</a>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    document.getElementById('pay-button').onclick = function() {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = "{{ route('payment.success') }}?order_id={{ $orderId }}";
            },
            onPending: function(result) {
                alert('Pembayaran dalam proses...');
            },
            onError: function(result) {
                window.location.href = "{{ route('payment.failed') }}";
            },
            onClose: function() {
                alert('Anda menutup popup pembayaran.');
            }
        });
    };
</script>
@endsection