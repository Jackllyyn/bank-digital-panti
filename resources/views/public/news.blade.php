@extends('layouts.public')

@section('title', 'Berita - PAM Pesantunan')

@section('content')
<main class="pt-16 sm:pt-20 pb-10 sm:pb-14 md:pb-18 lg:pb-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">

    <div class="text-center mb-8 sm:mb-12 lg:mb-16 reveal">
        <h1 class="font-display-lg text-3xl sm:text-4xl md:text-[48px] text-primary mb-2 sm:mb-3">Berita & Informasi</h1>
        <p class="font-body-lg text-sm sm:text-base md:text-lg text-on-surface-variant">Kabar terbaru dari Panti Asuhan Muhammadiyah Pesantunan.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 sm:gap-8">
        <div class="md:col-span-8 flex flex-col gap-6 sm:gap-8">
            <article class="bg-surface-container-lowest rounded-xl overflow-hidden soft-shadow hover:shadow-lg transition-shadow group relative reveal">
                <div class="aspect-video relative">
                    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBJRfwAgiOvK5c34C2Bka3BYMrlfjSDDM23PVPiuTvCGEp9BIB8WizW0XU84GjwyuqpBbbBb1jkhZtDnyJMVJioDLv3qwJj4dzbvmrH55UoG-rlTgdcQiOo_ggs4mL76fc-8lTWgeHQBds7JGrRfcDgoXLZFiFhGg8cSrNO9h973Y5b_k7D5xObQJN11KezCda1Ytv7LpUbpaYnNkwOKnVRvZUad_dth2VNX1RQB_HOIuqqjt0CxMU5" alt="Program Belajar Digital">
                    <div class="absolute top-3 left-3 sm:top-4 sm:left-4 bg-primary text-on-primary font-label-sm text-label-sm px-3 py-1 rounded-full shadow-sm">Sorotan Utama</div>
                </div>
                <div class="p-4 sm:p-5 md:p-6">
                    <div class="flex items-center gap-1 sm:gap-2 text-on-surface-variant mb-2 font-label-sm text-label-sm">
                        <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                        <span>15 Oktober 2024</span>
                        <span class="mx-1 sm:mx-2">•</span>
                        <span class="text-secondary font-medium">Kegiatan Panti</span>
                    </div>
                    <h2 class="font-headline-md text-xl sm:text-2xl text-on-surface group-hover:text-primary transition-colors mb-2">Peluncuran Program Belajar Digital Terpadu untuk Anak Asuh</h2>
                    <p class="font-body-md text-sm sm:text-base text-on-surface-variant mb-3 sm:mb-4 line-clamp-3">Sebagai langkah maju dalam pendidikan, kami resmi meluncurkan program belajar digital. Program ini diharapkan dapat meningkatkan literasi teknologi anak asuh, mempersiapkan mereka untuk masa depan yang lebih cerah dengan fasilitas modern yang didukung oleh donatur tercinta.</p>
                    <a class="inline-flex items-center gap-1 font-label-md text-label-md text-primary hover:text-primary-fixed-variant transition-colors" href="#">Baca Selengkapnya <span class="material-symbols-outlined text-[18px]">arrow_forward</span></a>
                </div>
            </article>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 md:gap-6">
                <article class="bg-surface-container-lowest rounded-xl overflow-hidden soft-shadow hover:shadow-lg transition-shadow flex flex-col group reveal" style="transition-delay: 100ms;">
                    <div class="h-40 sm:h-48 relative overflow-hidden">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCXDszGb1ncKTBUuRQS72EqsD7G1QiwKVr1sMfaO90NKCZrWNEoesZlhXAx1BekuHS5G_yqH79QIzPTKlSzv4bHyq-zxpmj1nepzqyeeQ2Qa07rBbaG_sVczOejoy0xuBL9r9_cO-pe14UU_nIlwTbLO2NtwvBzWV0aNeLQZ7JSr2peBRnjB9Pp7_x8V6QDtK-RFm0o56myLnxQ6edHPBaQnnaZT5BFVHRXsXT90IOxLiH8gEGTSbjp" alt="Laporan Keuangan">
                    </div>
                    <div class="p-4 sm:p-5 flex-1 flex flex-col">
                        <div class="text-secondary font-label-sm text-label-sm mb-1">Laporan Donasi</div>
                        <h3 class="font-title-lg text-base sm:text-lg text-on-surface group-hover:text-primary transition-colors mb-2 line-clamp-2">Laporan Transparansi Keuangan Kuartal III 2024</h3>
                        <p class="font-body-md text-sm sm:text-base text-on-surface-variant flex-1 line-clamp-2 mb-2 sm:mb-3">Rincian lengkap penerimaan dan penyaluran dana amanah dari para donatur selama periode Juli-September.</p>
                        <div class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1 mt-auto"><span class="material-symbols-outlined text-[14px]">schedule</span> 10 Okt 2024</div>
                    </div>
                </article>

                <article class="bg-surface-container-lowest rounded-xl overflow-hidden soft-shadow hover:shadow-lg transition-shadow flex flex-col group reveal" style="transition-delay: 200ms;">
                    <div class="h-40 sm:h-48 relative overflow-hidden">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBFiRYNZYcoVavB4jDcwsIM-I4l-xLYd2yyfn5Yo4re7xoXPA8Wj-nHqvWGYFCTiHyea1QOWerRBG0uPTA4-Z-5xPD4ZuJ6zY_VMtTwDzzRjk_2lf0kRLv9VXJ9FDzR9QOqzWGePOPh44rrz6WarSdACT6yzlOy0OgPt3vBITtNQCpatvq0b3NGWJ3HJ0zf8llGcZ7y2x5acFf1Jn-XH-nVMbktZ4ybLhh-bYJEkAETZFBSn3Pqziwf" alt="Panen Raya">
                    </div>
                    <div class="p-4 sm:p-5 flex-1 flex flex-col">
                        <div class="text-primary font-label-sm text-label-sm mb-1">Kegiatan Panti</div>
                        <h3 class="font-title-lg text-base sm:text-lg text-on-surface group-hover:text-primary transition-colors mb-2 line-clamp-2">Panen Raya Kebun Sayur Organik Anak Asuh</h3>
                        <p class="font-body-md text-sm sm:text-base text-on-surface-variant flex-1 line-clamp-2 mb-2 sm:mb-3">Hasil panen kebun organik yang dikelola mandiri oleh anak-anak asuh kini siap untuk dikonsumsi bersama.</p>
                        <div class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1 mt-auto"><span class="material-symbols-outlined text-[14px]">schedule</span> 05 Okt 2024</div>
                    </div>
                </article>

                <article class="bg-surface-container-lowest rounded-xl overflow-hidden soft-shadow hover:shadow-lg transition-shadow flex flex-col group reveal" style="transition-delay: 300ms;">
                    <div class="h-40 sm:h-48 relative overflow-hidden">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDhypgTbRkTA78ChIB5Db_bXTsiFGJ0k6kVz15GIADen_Ouiz6jHjaK7e6tSsf_u-80HCTCtHiz6NWiTNQBI5akc6RsJ3eVgHPCqgtHOHS8f0egd-vKOUUCQz-9-akGfLhmQjzbmmA6COf3fsS8YkNcL5ScurMhZHZAnuvOu562V8jSNgnxAFTWwvtclYGimDD1Agobn3ySHv0iKJzpUb7I-mpxk6A6yhM6BKaNuuuFUwukMiBZ3C_u" alt="Fitur Lacak Donasi">
                    </div>
                    <div class="p-4 sm:p-5 flex-1 flex flex-col">
                        <div class="text-secondary font-label-sm text-label-sm mb-1">Sistem Digital</div>
                        <h3 class="font-title-lg text-base sm:text-lg text-on-surface group-hover:text-primary transition-colors mb-2 line-clamp-2">Pembaruan Fitur Lacak Donasi di Portal Donatur</h3>
                        <p class="font-body-md text-sm sm:text-base text-on-surface-variant flex-1 line-clamp-2 mb-2 sm:mb-3">Kini para donatur dapat melacak riwayat penyaluran donasi secara real-time dengan antarmuka yang lebih intuitif.</p>
                        <div class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1 mt-auto"><span class="material-symbols-outlined text-[14px]">schedule</span> 28 Sep 2024</div>
                    </div>
                </article>

                <article class="bg-surface-container-lowest rounded-xl overflow-hidden soft-shadow hover:shadow-lg transition-shadow flex flex-col group reveal" style="transition-delay: 400ms;">
                    <div class="h-40 sm:h-48 relative overflow-hidden">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDlEcS_hsYrz6RzS3Qi1ykH6zNTzmsjE9hPy6ROrqFSUvK5g1cDRwRLw3-DJjYYVnQzPP5uB6c5B-iVITDRnsydIAGhfV17zcYdO9SzhjxQEkOZlYOkn6SUYicmlgsausYqoe9uHyQ5vXh-GU7ghTkY79f8STkqu-5HC0ddRKFX34IrMQV_XjLYWWTSa_QWyb8at4rfLvxDdOQ4gBAMp731TAouRV-3I1MuSkEI-9KHG7XmA7bDXsXj" alt="Kunjungan Alumni">
                    </div>
                    <div class="p-4 sm:p-5 flex-1 flex flex-col">
                        <div class="text-primary font-label-sm text-label-sm mb-1">Kegiatan Panti</div>
                        <h3 class="font-title-lg text-base sm:text-lg text-on-surface group-hover:text-primary transition-colors mb-2 line-clamp-2">Kunjungan Motivasi dari Ikatan Alumni</h3>
                        <p class="font-body-md text-sm sm:text-base text-on-surface-variant flex-1 line-clamp-2 mb-2 sm:mb-3">Membangun semangat belajar anak asuh melalui sesi berbagi pengalaman bersama kakak-kakak alumni yang telah sukses.</p>
                        <div class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1 mt-auto"><span class="material-symbols-outlined text-[14px]">schedule</span> 20 Sep 2024</div>
                    </div>
                </article>
            </div>

            <div class="flex justify-center mt-4 sm:mt-6 gap-2 reveal">
                <button class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-surface-variant transition-colors disabled:opacity-50" disabled><span class="material-symbols-outlined text-[20px]">chevron_left</span></button>
                <button class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg bg-primary text-on-primary flex items-center justify-center font-label-md">1</button>
                <button class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-surface-variant transition-colors font-label-md">2</button>
                <button class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-surface-variant transition-colors font-label-md">3</button>
                <button class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-surface-variant transition-colors"><span class="material-symbols-outlined text-[20px]">chevron_right</span></button>
            </div>
        </div>

        <aside class="md:col-span-4 flex flex-col gap-6">
            <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 md:p-6 soft-shadow reveal">
                <h3 class="font-title-lg text-lg text-on-surface mb-3">Cari Berita</h3>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input class="w-full bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg pl-9 sm:pl-10 pr-3 py-2 font-body-md text-sm sm:text-base text-on-surface transition-colors placeholder:text-outline" placeholder="Masukkan kata kunci..." type="text">
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 md:p-6 soft-shadow reveal" style="transition-delay: 100ms;">
                <h3 class="font-title-lg text-lg text-on-surface mb-3 border-b border-outline-variant pb-2">Kategori</h3>
                <ul class="flex flex-col gap-2 font-body-md text-sm sm:text-base">
                    <li><a class="flex justify-between items-center text-on-surface-variant hover:text-primary transition-colors py-1" href="#"><span>Kegiatan Panti</span><span class="bg-surface-container px-2 py-0.5 rounded-full text-label-sm font-label-sm">24</span></a></li>
                    <li><a class="flex justify-between items-center text-on-surface-variant hover:text-primary transition-colors py-1" href="#"><span>Laporan Donasi</span><span class="bg-surface-container px-2 py-0.5 rounded-full text-label-sm font-label-sm">12</span></a></li>
                    <li><a class="flex justify-between items-center text-on-surface-variant hover:text-primary transition-colors py-1" href="#"><span>Sistem Digital</span><span class="bg-surface-container px-2 py-0.5 rounded-full text-label-sm font-label-sm">8</span></a></li>
                    <li><a class="flex justify-between items-center text-on-surface-variant hover:text-primary transition-colors py-1" href="#"><span>Prestasi</span><span class="bg-surface-container px-2 py-0.5 rounded-full text-label-sm font-label-sm">5</span></a></li>
                </ul>
            </div>

            <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 md:p-6 soft-shadow reveal" style="transition-delay: 200ms;">
                <h3 class="font-title-lg text-lg text-on-surface mb-3 border-b border-outline-variant pb-2">Berita Populer</h3>
                <div class="flex flex-col gap-3 sm:gap-4">
                    <a class="flex gap-3 group" href="#">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded bg-surface-variant flex-shrink-0 overflow-hidden">
                            <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" src="https://lh3.googleusercontent.com/aida-public/AB6AXuArTm5CdfBi1BhYq8B4VllugWnK-7fAE5NtJh_9Sx0jH2kDykDKGjDAK6JgN4PdzSjqxSFC1Fl467p_vBeiFWtqSSFoxWfUu_LSOltEjvni-EkngOrutQRgJJSU8adtEEve0qNrNJQVfbw-oE6at2S0KcuLng7bH-LfYbizannkpbIsDVqtc5W-1970TUThJ1NL0jEi446NtTvOmvB06UTekkXqAjJNERyHj14BT8F1mTw0jzExYcQi" alt="Gedung Asrama Baru">
                        </div>
                        <div class="flex flex-col justify-center">
                            <h4 class="font-label-md text-sm sm:text-base text-on-surface group-hover:text-primary transition-colors line-clamp-2 mb-1">Peresmian Gedung Asrama Baru untuk Putra</h4>
                            <span class="font-label-sm text-label-sm text-on-surface-variant">01 Sep 2024</span>
                        </div>
                    </a>
                    <a class="flex gap-3 group" href="#">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded bg-surface-variant flex-shrink-0 overflow-hidden">
                            <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDpL5mCoy5m8y4WD83qA859MWP6yutT-bKYwezsA6gxNxQ0B3sIKVFcNQJ6pfObuBtGfNrSXDc48fBZMEKGa2wcFCPQF5dNbovuiuO-YeN7B2xdvQgHvZCRukFra32rlK3XJBB0qqgbDlKJaon0rPvTjqiTbkzTUsTqAPs9ee4dJBPikd7xIBkI51-lxGAHYYc-hAlnylJ812JCtrpzVPH9ZN3BjDmyao_xGoFQjy6kdLIBAyH5nPze" alt="Audit Keuangan">
                        </div>
                        <div class="flex flex-col justify-center">
                            <h4 class="font-label-md text-sm sm:text-base text-on-surface group-hover:text-primary transition-colors line-clamp-2 mb-1">Audit Keuangan Tahunan Dinyatakan Wajar</h4>
                            <span class="font-label-sm text-label-sm text-on-surface-variant">15 Agu 2024</span>
                        </div>
                    </a>
                    <a class="flex gap-3 group" href="#">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded bg-surface-variant flex-shrink-0 overflow-hidden">
                            <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB2yBHLIN5m99UaprWDBPODnD55tgqtUj1rnJ2KWVeFP_9pK_DiQC3uw2lBe8gsftHIB3tNK8NjNljLDO6IEtH2dmkbLxeluihded_jT5ZSrt0nJRLuwXRSO2Vu8uQGmqe6u5TdLDmLF6XRbaAb2YkR6_kDWnVOfjXnFbyzZJ_nIcoKfxoQYDlSO1SxfSY3K6V53wa6Z1F_TP_5UO36KhqPefSWAlB3bBohmu2BwUMPQ9grg6GKSZGT" alt="Beasiswa">
                        </div>
                        <div class="flex flex-col justify-center">
                            <h4 class="font-label-md text-sm sm:text-base text-on-surface group-hover:text-primary transition-colors line-clamp-2 mb-1">Dua Anak Asuh Raih Beasiswa Penuh</h4>
                            <span class="font-label-sm text-label-sm text-on-surface-variant">10 Agu 2024</span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="bg-primary-container text-on-primary-container rounded-xl p-4 sm:p-5 md:p-6 soft-shadow flex flex-col items-center text-center reveal" style="transition-delay: 300ms;">
                <span class="material-symbols-outlined text-[36px] sm:text-[40px] mb-2 opacity-80">volunteer_activism</span>
                <h3 class="font-title-lg text-lg mb-2">Dukung Kegiatan Kami</h3>
                <p class="font-body-sm text-sm mb-3 sm:mb-4 opacity-90">Setiap donasi Anda membantu memastikan kegiatan panti berjalan lancar dan transparan.</p>
                <a href="{{ route('donation') }}" class="w-full bg-on-primary-container text-primary-container font-label-md text-label-md py-2 rounded-lg hover:bg-white transition-colors">Donasi Sekarang</a>
            </div>
        </aside>
    </div>
</main>
@endsection