@extends('layouts.public')

@section('title', 'Donasi - PAM Pesantunan')

@section('content')
<main class="pt-16 sm:pt-20 pb-10 sm:pb-14 md:pb-18 lg:pb-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">

    <div class="text-center mb-8 sm:mb-12 lg:mb-16 reveal">
        <h1 class="font-display-lg text-3xl sm:text-4xl md:text-[48px] text-primary mb-2 sm:mb-3">Donasi Sekarang</h1>
        <p class="font-body-lg text-sm sm:text-base md:text-lg text-on-surface-variant max-w-2xl mx-auto">Setiap donasi Anda sangat berarti bagi masa depan anak-anak asuh kami. Salurkan donasi dengan mudah dan aman melalui sistem yang transparan.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        <div class="lg:col-span-2 reveal">
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow border border-surface-container-low">
                <h2 class="font-title-lg text-lg sm:text-xl text-on-surface mb-2">Form Donasi</h2>
                <p class="font-body-md text-sm sm:text-base text-on-surface-variant mb-5 sm:mb-6">Isi data diri Anda dan nominal donasi yang ingin disalurkan.</p>

                <form method="POST" action="#">
                    @csrf
                    <div class="mb-4 sm:mb-5">
                        <label class="font-label-md text-label-md text-on-surface block mb-2">Jenis Donasi</label>
                        <div class="grid grid-cols-2 gap-2 sm:gap-3">
                            <label class="flex items-center gap-2 p-2.5 sm:p-3 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low transition-colors">
                                <input type="radio" name="donation_type" value="uang" checked>
                                <span class="font-body-md text-sm sm:text-base text-on-surface">Donasi Uang</span>
                            </label>
                            <label class="flex items-center gap-2 p-2.5 sm:p-3 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low transition-colors">
                                <input type="radio" name="donation_type" value="barang">
                                <span class="font-body-md text-sm sm:text-base text-on-surface">Donasi Barang</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4 sm:mb-5">
                        <label class="font-label-md text-label-md text-on-surface block mb-2">Nominal Donasi</label>
                        <div class="grid grid-cols-3 gap-2 mb-2">
                            <button type="button" class="py-1.5 sm:py-2 text-sm sm:text-base border border-outline-variant rounded-lg font-label-md text-label-md hover:bg-primary-container hover:text-on-primary-container transition-colors">Rp 50.000</button>
                            <button type="button" class="py-1.5 sm:py-2 text-sm sm:text-base border border-outline-variant rounded-lg font-label-md text-label-md hover:bg-primary-container hover:text-on-primary-container transition-colors">Rp 100.000</button>
                            <button type="button" class="py-1.5 sm:py-2 text-sm sm:text-base border border-outline-variant rounded-lg font-label-md text-label-md hover:bg-primary-container hover:text-on-primary-container transition-colors">Rp 250.000</button>
                            <button type="button" class="py-1.5 sm:py-2 text-sm sm:text-base border border-outline-variant rounded-lg font-label-md text-label-md hover:bg-primary-container hover:text-on-primary-container transition-colors">Rp 500.000</button>
                            <button type="button" class="py-1.5 sm:py-2 text-sm sm:text-base border border-outline-variant rounded-lg font-label-md text-label-md hover:bg-primary-container hover:text-on-primary-container transition-colors">Rp 1.000.000</button>
                            <button type="button" class="py-1.5 sm:py-2 text-sm sm:text-base border border-outline-variant rounded-lg font-label-md text-label-md hover:bg-primary-container hover:text-on-primary-container transition-colors">Lainnya</button>
                        </div>
                        <input type="number" class="w-full bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/50" placeholder="Masukkan nominal lainnya" name="amount">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4 sm:mb-5">
                        <div class="flex flex-col gap-1">
                            <label class="font-label-md text-label-md text-on-surface" for="name">Nama Lengkap</label>
                            <input class="bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" id="name" name="name" placeholder="Nama lengkap" type="text" required>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="font-label-md text-label-md text-on-surface" for="email">Email</label>
                            <input class="bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" id="email" name="email" placeholder="email@example.com" type="email" required>
                        </div>
                    </div>

                    <div class="mb-4 sm:mb-5">
                        <label class="font-label-md text-label-md text-on-surface" for="phone">Nomor Telepon</label>
                        <input class="w-full bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" id="phone" name="phone" placeholder="0812-3456-7890" type="tel" required>
                    </div>

                    <div class="mb-4 sm:mb-5">
                        <label class="font-label-md text-label-md text-on-surface" for="message">Pesan (Opsional)</label>
                        <textarea class="w-full bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-y" id="message" name="message" placeholder="Tulis pesan atau doa Anda..." rows="2 sm:rows-3"></textarea>
                    </div>

                    <div class="mb-5 sm:mb-6">
                        <label class="font-label-md text-label-md text-on-surface block mb-2">Metode Pembayaran</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            <label class="flex items-center gap-2 p-2 sm:p-2.5 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low transition-colors">
                                <input type="radio" name="payment_method" value="bank_transfer" checked>
                                <span class="font-body-sm text-xs sm:text-sm">Transfer Bank</span>
                            </label>
                            <label class="flex items-center gap-2 p-2 sm:p-2.5 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low transition-colors">
                                <input type="radio" name="payment_method" value="qris">
                                <span class="font-body-sm text-xs sm:text-sm">QRIS</span>
                            </label>
                            <label class="flex items-center gap-2 p-2 sm:p-2.5 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low transition-colors">
                                <input type="radio" name="payment_method" value="e-wallet">
                                <span class="font-body-sm text-xs sm:text-sm">E-Wallet</span>
                            </label>
                            <label class="flex items-center gap-2 p-2 sm:p-2.5 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low transition-colors">
                                <input type="radio" name="payment_method" value="cash">
                                <span class="font-body-sm text-xs sm:text-sm">Tunai</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-primary-container text-on-primary-container font-label-md text-label-md py-2.5 sm:py-3 rounded-lg hover:bg-primary hover:text-on-primary transition-all soft-shadow hover:shadow-lg flex items-center justify-center gap-2">
                        <span>Donasi Sekarang</span>
                        <span class="material-symbols-outlined text-[18px]">volunteer_activism</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-1 flex flex-col gap-6">
            <div class="bg-primary-container rounded-xl p-5 sm:p-6 lg:p-7 text-on-primary-container reveal" style="transition-delay: 100ms;">
                <span class="material-symbols-outlined text-[32px] sm:text-[40px] mb-2">account_balance</span>
                <h3 class="font-title-lg text-lg sm:text-xl mb-3">Rekening Donasi</h3>
                <div class="space-y-3 sm:space-y-4">
                    <div>
                        <p class="font-label-sm text-label-sm opacity-80">Bank BCA</p>
                        <p class="font-headline-md text-lg sm:text-xl md:text-2xl font-bold">123 4567 890</p>
                        <p class="font-body-sm text-xs sm:text-sm opacity-80">A/n Yayasan PAM Pesantunan</p>
                    </div>
                    <div>
                        <p class="font-label-sm text-label-sm opacity-80">Bank Mandiri</p>
                        <p class="font-headline-md text-lg sm:text-xl md:text-2xl font-bold">987 6543 210</p>
                        <p class="font-body-sm text-xs sm:text-sm opacity-80">A/n Yayasan PAM Pesantunan</p>
                    </div>
                </div>
                <div class="mt-3 sm:mt-4 p-3 bg-on-primary-container/10 rounded-lg">
                    <p class="font-body-sm text-xs sm:text-sm">💰 Konfirmasi donasi via WhatsApp: <strong>0812-3456-7890</strong></p>
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-7 soft-shadow border border-surface-container-low reveal" style="transition-delay: 200ms;">
                <h3 class="font-title-lg text-lg sm:text-xl text-on-surface mb-3">Kenapa Donasi di Sini?</h3>
                <ul class="space-y-2 sm:space-y-3 font-body-md text-sm sm:text-base text-on-surface-variant">
                    <li class="flex items-start gap-2"><span class="material-symbols-outlined text-primary text-sm">check_circle</span><span>100% Transparan</span></li>
                    <li class="flex items-start gap-2"><span class="material-symbols-outlined text-primary text-sm">check_circle</span><span>Laporan Keuangan Real-time</span></li>
                    <li class="flex items-start gap-2"><span class="material-symbols-outlined text-primary text-sm">check_circle</span><span>Terdaftar dan Terpercaya</span></li>
                    <li class="flex items-start gap-2"><span class="material-symbols-outlined text-primary text-sm">check_circle</span><span>Tepat Sasaran untuk Anak Asuh</span></li>
                </ul>
            </div>
        </div>
    </div>
</main>
@endsection