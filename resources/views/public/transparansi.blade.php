@extends('layouts.public')

@section('title', 'Transparansi Keuangan - PAM Pesantunan')

@section('content')
<main class="pt-16 sm:pt-20 pb-10 sm:pb-14 md:pb-18 lg:pb-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">

    <div class="text-center mb-8 sm:mb-12 lg:mb-16 reveal">
        <h1 class="font-display-lg text-3xl sm:text-4xl md:text-[48px] text-primary mb-2 sm:mb-3">Transparansi Keuangan</h1>
        <p class="font-body-lg text-sm sm:text-base md:text-lg text-on-surface-variant max-w-2xl mx-auto">
            Laporan keuangan {{ $identitas->nama_panti ?? 'Panti Asuhan Muhammadiyah Pesantunan' }} disajikan secara transparan untuk memastikan setiap dana amanah tersalurkan dengan tepat.
        </p>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8 sm:mb-12 reveal">
        <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 text-center soft-shadow">
            <div class="font-playfair text-2xl sm:text-3xl text-green-600">Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}</div>
            <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant">Total Pemasukan</p>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 text-center soft-shadow reveal" style="transition-delay: 100ms;">
            <div class="font-playfair text-2xl sm:text-3xl text-red-600">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</div>
            <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant">Total Pengeluaran</p>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 text-center soft-shadow reveal" style="transition-delay: 200ms;">
            <div class="font-playfair text-2xl sm:text-3xl {{ ($saldoAkhir ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">Rp {{ number_format($saldoAkhir ?? 0, 0, ',', '.') }}</div>
            <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant">Saldo Akhir</p>
        </div>
    </div>

    <!-- Tabel Laporan -->
    <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow reveal">
        <h2 class="font-title-lg text-lg sm:text-xl text-on-surface mb-4">Laporan Per Bulan</h2>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm sm:text-base">
                <thead>
                    <tr class="border-b border-outline-variant">
                        <th class="text-left py-3 px-3 font-jakarta font-semibold text-on-surface">Periode</th>
                        <th class="text-right py-3 px-3 font-jakarta font-semibold text-on-surface">Pemasukan</th>
                        <th class="text-right py-3 px-3 font-jakarta font-semibold text-on-surface">Pengeluaran</th>
                        <th class="text-right py-3 px-3 font-jakarta font-semibold text-on-surface">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanBulanan ?? [] as $item)
                        <tr class="border-b border-outline-variant/20 hover:bg-surface-container-low transition-colors">
                            <td class="py-3 px-3 font-body-md text-on-surface">{{ $item->periode ?? '-' }}</td>
                            <td class="py-3 px-3 text-right font-body-md text-green-600">Rp {{ number_format($item->total_pemasukan ?? 0, 0, ',', '.') }}</td>
                            <td class="py-3 px-3 text-right font-body-md text-red-600">Rp {{ number_format($item->total_pengeluaran ?? 0, 0, ',', '.') }}</td>
                            <td class="py-3 px-3 text-right font-body-md font-bold {{ ($item->saldo_akhir ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                Rp {{ number_format($item->saldo_akhir ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-on-surface-variant">Belum ada data laporan keuangan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Keterangan -->
    <div class="mt-6 sm:mt-8 bg-primary-container/10 rounded-xl p-4 sm:p-5 border border-primary-container/20 reveal">
        <p class="font-body-sm text-sm text-on-surface-variant">
            <span class="material-symbols-outlined text-primary text-sm align-middle">info</span>
            Data keuangan diperbarui secara berkala. Untuk informasi lebih detail, silakan hubungi pengurus panti.
        </p>
    </div>
</main>
@endsection