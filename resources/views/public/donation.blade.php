@extends('layouts.public')

@section('title', 'Donasi - PAM Pesantunan')

@section('content')
<main class="pt-16 sm:pt-20 pb-10 sm:pb-14 md:pb-18 lg:pb-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">

    <div class="text-center mb-8 sm:mb-12 lg:mb-16 reveal">
        <h1 class="font-display-lg text-3xl sm:text-4xl md:text-[48px] text-primary mb-2 sm:mb-3">Donasi Sekarang</h1>
        <p class="font-body-lg text-sm sm:text-base md:text-lg text-on-surface-variant max-w-2xl mx-auto">Setiap donasi Anda sangat berarti bagi masa depan anak-anak asuh kami. Salurkan donasi dengan mudah dan aman melalui sistem yang transparan.</p>
    </div>

    <!-- Statistik Donasi -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 sm:mb-12 reveal">
        <div class="bg-surface-container-lowest rounded-xl p-4 text-center soft-shadow">
            <div class="font-playfair text-2xl sm:text-3xl text-primary">Rp {{ number_format($totalDonasi ?? 0, 0, ',', '.') }}</div>
            <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant">Total Donasi</p>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-4 text-center soft-shadow reveal" style="transition-delay: 100ms;">
            <div class="font-playfair text-2xl sm:text-3xl text-primary">{{ $totalDonatur ?? 0 }}</div>
            <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant">Donatur</p>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-4 text-center soft-shadow reveal" style="transition-delay: 200ms;">
            <div class="font-playfair text-2xl sm:text-3xl text-primary">{{ $totalAnakAktif ?? 0 }}</div>
            <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant">Anak Asuh</p>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-4 text-center soft-shadow reveal" style="transition-delay: 300ms;">
            <div class="font-playfair text-2xl sm:text-3xl text-primary">100%</div>
            <p class="font-jakarta text-xs sm:text-sm text-on-surface-variant">Transparan</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        <div class="lg:col-span-2 reveal">
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow border border-surface-container-low">
                <h2 class="font-title-lg text-lg sm:text-xl text-on-surface mb-2">Form Donasi</h2>
                <p class="font-body-md text-sm sm:text-base text-on-surface-variant mb-5 sm:mb-6">Isi data diri Anda dan nominal donasi yang ingin disalurkan.</p>

                <form method="POST" action="{{ route('donation.store') }}">
                    @csrf
                    <div class="mb-4 sm:mb-5">
                        <label class="font-label-md text-label-md text-on-surface block mb-2">Jenis Donasi</label>
                        <div class="grid grid-cols-2 gap-2 sm:gap-3">
                            @foreach($categories ?? [] as $index => $cat)
                                <label class="flex items-center gap-2 p-2.5 sm:p-3 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low transition-colors">
                                    <input type="radio" name="donation_type" value="{{ $cat->nama }}" {{ $index == 0 ? 'checked' : '' }}>
                                    <span class="font-body-md text-sm sm:text-base text-on-surface">{{ $cat->nama }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4 sm:mb-5">
                        <label class="font-label-md text-label-md text-on-surface block mb-2">Nominal Donasi (Rp)</label>
                        <div class="grid grid-cols-3 gap-2 mb-2">
                            @php
                                $nominals = [50000, 100000, 250000, 500000, 1000000, 0];
                            @endphp
                            @foreach($nominals as $nominal)
                                <button type="button" class="nominal-btn py-1.5 sm:py-2 text-sm sm:text-base border border-outline-variant rounded-lg font-label-md text-label-md hover:bg-primary-container hover:text-on-primary-container transition-colors" data-nominal="{{ $nominal }}">
                                    {{ $nominal > 0 ? 'Rp ' . number_format($nominal, 0, ',', '.') : 'Lainnya' }}
                                </button>
                            @endforeach
                        </div>
                        <input type="number" class="w-full bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/50" 
                               placeholder="Masukkan nominal lainnya" 
                               name="amount" 
                               id="amount_input"
                               min="10000"
                               required>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4 sm:mb-5">
                        <div class="flex flex-col gap-1">
                            <label class="font-label-md text-label-md text-on-surface" for="name">Nama Lengkap</label>
                            <input class="bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" 
                                   id="name" 
                                   name="nama" 
                                   placeholder="Nama lengkap" 
                                   type="text" 
                                   required>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="font-label-md text-label-md text-on-surface" for="email">Email</label>
                            <input class="bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" 
                                   id="email" 
                                   name="email" 
                                   placeholder="email@example.com" 
                                   type="email" 
                                   required>
                        </div>
                    </div>

                    <div class="mb-4 sm:mb-5">
                        <label class="font-label-md text-label-md text-on-surface" for="phone">Nomor Telepon</label>
                        <input class="w-full bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" 
                               id="phone" 
                               name="telepon" 
                               placeholder="0812-3456-7890" 
                               type="tel" 
                               required>
                    </div>

                    <div class="mb-4 sm:mb-5">
                        <label class="font-label-md text-label-md text-on-surface" for="program">Program Donasi (Opsional)</label>
                        <select class="w-full bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" 
                                id="program" 
                                name="program_id">
                            <option value="">Pilih Program</option>
                            @foreach($programs ?? [] as $program)
                                <option value="{{ $program->nama }}">{{ $program->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4 sm:mb-5">
                        <label class="font-label-md text-label-md text-on-surface" for="message">Pesan (Opsional)</label>
                        <textarea class="w-full bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-y" 
                                  id="message" 
                                  name="pesan" 
                                  placeholder="Tulis pesan atau doa Anda..." 
                                  rows="2 sm:rows-3"></textarea>
                    </div>

                    <div class="mb-5 sm:mb-6">
                        <label class="font-label-md text-label-md text-on-surface block mb-2">Metode Pembayaran</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            @php
                                $methods = [
                                    ['value' => 'bank_transfer', 'label' => 'Transfer Bank'],
                                    ['value' => 'qris', 'label' => 'QRIS'],
                                    ['value' => 'e-wallet', 'label' => 'E-Wallet'],
                                    ['value' => 'cash', 'label' => 'Tunai']
                                ];
                            @endphp
                            @foreach($methods as $index => $method)
                                <label class="flex items-center gap-2 p-2 sm:p-2.5 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low transition-colors">
                                    <input type="radio" name="metode_pembayaran" value="{{ $method['value'] }}" {{ $index == 0 ? 'checked' : '' }}>
                                    <span class="font-body-sm text-xs sm:text-sm">{{ $method['label'] }}</span>
                                </label>
                            @endforeach
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
                        <p class="font-label-sm text-label-sm opacity-80">{{ $identitas->nama_bank ?? 'Bank BCA' }}</p>
                        <p class="font-headline-md text-lg sm:text-xl md:text-2xl font-bold">{{ $identitas->no_rekening ?? '123 4567 890' }}</p>
                        <p class="font-body-sm text-xs sm:text-sm opacity-80">A/n {{ $identitas->nama_yayasan ?? 'Yayasan PAM Pesantunan' }}</p>
                    </div>
                </div>
                <div class="mt-3 sm:mt-4 p-3 bg-on-primary-container/10 rounded-lg">
                    <p class="font-body-sm text-xs sm:text-sm">💰 Konfirmasi donasi via WhatsApp: <strong>{{ $identitas->telepon ?? '0812-3456-7890' }}</strong></p>
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

<!-- Donasi Terbaru -->
@if(isset($donasiTerbaru) && $donasiTerbaru->count() > 0)
    <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-7 soft-shadow border border-surface-container-low reveal" style="transition-delay: 300ms;">
        <h3 class="font-title-lg text-lg sm:text-xl text-on-surface mb-3">Donasi Terbaru</h3>
        <div class="space-y-2">
            @foreach($donasiTerbaru->take(5) as $donasi)
                <div class="flex justify-between items-center py-2 border-b border-outline-variant/20">
                    <div>
                        <p class="font-jakarta text-sm font-medium text-on-surface">{{ $donasi->donatur->nama ?? $donasi->kode_donatur ?? 'Anonim' }}</p>
                        <p class="font-body-md text-xs text-on-surface-variant">
                            @if(isset($donasi->created_at))
                                @if($donasi->created_at instanceof \Carbon\Carbon)
                                    {{ $donasi->created_at->diffForHumans() }}
                                @else
                                    {{ \Carbon\Carbon::parse($donasi->created_at)->diffForHumans() }}
                                @endif
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <span class="font-jakarta text-sm font-semibold text-primary">+Rp {{ number_format($donasi->jumlah ?? 0, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endif
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nominalBtns = document.querySelectorAll('.nominal-btn');
        const amountInput = document.getElementById('amount_input');
        
        nominalBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const nominal = parseInt(this.dataset.nominal);
                if (nominal > 0) {
                    amountInput.value = nominal;
                    // Highlight active button
                    nominalBtns.forEach(b => b.classList.remove('bg-primary-container', 'text-on-primary-container'));
                    this.classList.add('bg-primary-container', 'text-on-primary-container');
                } else {
                    amountInput.value = '';
                    amountInput.focus();
                    nominalBtns.forEach(b => b.classList.remove('bg-primary-container', 'text-on-primary-container'));
                }
            });
        });
    });
</script>
@endsection