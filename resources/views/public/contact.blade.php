@extends('layouts.public')

@section('title', 'Kontak - PAM Pesantunan')

@section('content')
<main class="pt-16 sm:pt-20 pb-10 sm:pb-14 md:pb-18 lg:pb-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">

    <div class="text-center mb-8 sm:mb-12 lg:mb-16 reveal">
        <h1 class="font-display-lg text-3xl sm:text-4xl md:text-[48px] text-on-surface mb-2 sm:mb-3">Hubungi Kami</h1>
        <p class="font-body-lg text-sm sm:text-base md:text-lg text-on-surface-variant max-w-2xl mx-auto">Kami siap membantu dan menjawab pertanyaan Anda. Jangan ragu untuk menghubungi kami.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 lg:gap-10 xl:gap-12">
        <div class="lg:col-span-5 flex flex-col gap-6">
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow border border-surface-container-low reveal">
                <h2 class="font-title-lg text-lg sm:text-xl text-on-surface mb-4">Informasi Kontak</h2>
                <div class="flex flex-col gap-4">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary">location_on</span>
                        <div>
                            <h3 class="font-label-md text-label-md text-on-surface">Alamat</h3>
                            <p class="font-body-md text-sm sm:text-base text-on-surface-variant mt-1">Jl. Raya Pesantunan No. 123,<br>Kecamatan Wanasari, Kabupaten Brebes,<br>Jawa Tengah, 52252</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary">call</span>
                        <div>
                            <h3 class="font-label-md text-label-md text-on-surface">Telepon</h3>
                            <p class="font-body-md text-sm sm:text-base text-on-surface-variant mt-1">+62 283 123456</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary">mail</span>
                        <div>
                            <h3 class="font-label-md text-label-md text-on-surface">Email</h3>
                            <p class="font-body-md text-sm sm:text-base text-on-surface-variant mt-1">info@pampesantunan.or.id</p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    <h3 class="font-label-md text-label-md text-on-surface mb-2">Media Sosial</h3>
                    <div class="flex gap-2 sm:gap-3">
                        <a class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-surface-container-low flex items-center justify-center text-on-surface-variant hover:bg-primary-container hover:text-on-primary-container transition-colors" href="#"><span class="material-symbols-outlined text-sm sm:text-base">share</span></a>
                        <a class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-surface-container-low flex items-center justify-center text-on-surface-variant hover:bg-primary-container hover:text-on-primary-container transition-colors" href="#"><span class="material-symbols-outlined text-sm sm:text-base">public</span></a>
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-xl soft-shadow border border-surface-container-low overflow-hidden h-48 sm:h-56 md:h-64 relative group reveal" style="transition-delay: 100ms;">
                <div class="bg-cover bg-center w-full h-full" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCMi4yithcN_xTwYGcufCattcvXy4278cZ_bfACrn3l7uXtNU3mgamdXjYAuUhYw9THHLjGAkVJdii0wb-keFRkeh-SXSIYouwvzd-YePUD73_LDGCectY_nqdljgezVS3mLk05DLKGNhSjA2jDi8Wzv2Ke6m5aqRHQ5wBJaghKwchgVuxgGMjGglpfd4Q7TMXBzN7og0N1lBLWDHdVh9OH78T3tU2AK-lkks9OMb9Yt5plv7XNxv2u')"></div>
                <div class="absolute inset-0 bg-surface/20 group-hover:bg-transparent transition-colors duration-300"></div>
                <div class="absolute bottom-2 right-2 sm:bottom-3 sm:right-3 bg-surface-container-lowest px-2 sm:px-3 py-1 rounded-lg shadow-sm">
                    <span class="font-label-sm text-xs sm:text-sm text-on-surface">Buka di Google Maps</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7 reveal" style="transition-delay: 200ms;">
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow border border-surface-container-low h-full">
                <h2 class="font-title-lg text-lg sm:text-xl text-on-surface mb-2">Kirim Pesan</h2>
                <p class="font-body-md text-sm sm:text-base text-on-surface-variant mb-5 sm:mb-6">Silakan isi formulir di bawah ini untuk mengirimkan pertanyaan, saran, atau informasi lainnya.</p>
                <form class="flex flex-col gap-4 sm:gap-5" method="POST" action="#">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label class="font-label-md text-label-md text-on-surface" for="name">Nama Lengkap</label>
                            <input class="bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/50" id="name" name="name" placeholder="Masukkan nama Anda" type="text" required>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="font-label-md text-label-md text-on-surface" for="email">Alamat Email</label>
                            <input class="bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/50" id="email" name="email" placeholder="nama@email.com" type="email" required>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="font-label-md text-label-md text-on-surface" for="subject">Subjek</label>
                        <select class="bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" id="subject" name="subject">
                            <option value="">Pilih Subjek</option>
                            <option value="informasi">Informasi Panti</option>
                            <option value="donasi">Konfirmasi Donasi</option>
                            <option value="kunjungan">Rencana Kunjungan</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="font-label-md text-label-md text-on-surface" for="message">Pesan</label>
                        <textarea class="bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/50 resize-y" id="message" name="message" placeholder="Tulis pesan Anda di sini..." rows="4 sm:rows-5" required></textarea>
                    </div>
                    <button class="mt-1 sm:mt-2 self-start font-label-md text-label-md bg-primary-container text-on-primary-container px-5 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-primary hover:text-on-primary transition-all flex items-center gap-2 soft-shadow hover:shadow-lg" type="submit">
                        <span>Kirim Pesan</span>
                        <span class="material-symbols-outlined text-[18px]">send</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection