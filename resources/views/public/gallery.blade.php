@extends('layouts.public')

@section('title', 'Galeri - PAM Pesantunan')

@section('content')
<main class="pt-16 sm:pt-20 pb-10 sm:pb-14 md:pb-18 lg:pb-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">

    <section class="text-center mb-8 sm:mb-12 lg:mb-16 reveal">
        <h1 class="font-display-lg text-3xl sm:text-4xl md:text-[48px] text-primary mb-2 sm:mb-3">Galeri Kegiatan</h1>
        <p class="font-body-lg text-sm sm:text-base md:text-lg text-on-surface-variant max-w-2xl mx-auto">Melihat lebih dekat aktivitas, keceriaan, dan perkembangan anak-anak asuh di Panti Asuhan Muhammadiyah Pesantunan.</p>
    </section>

    <section class="mb-6 sm:mb-8 lg:mb-10 flex flex-wrap justify-center gap-2 sm:gap-3 reveal">
        <button class="px-4 py-2 rounded-full font-label-md text-label-md bg-primary-container text-on-primary-container shadow-sm transition-all hover:bg-primary hover:text-white">Semua</button>
        <button class="px-4 py-2 rounded-full font-label-md text-label-md bg-surface-container-low text-on-surface-variant hover:bg-surface-container transition-colors">Kegiatan Anak</button>
        <button class="px-4 py-2 rounded-full font-label-md text-label-md bg-surface-container-low text-on-surface-variant hover:bg-surface-container transition-colors">Donasi</button>
        <button class="px-4 py-2 rounded-full font-label-md text-label-md bg-surface-container-low text-on-surface-variant hover:bg-surface-container transition-colors">Fasilitas</button>
        <button class="px-4 py-2 rounded-full font-label-md text-label-md bg-surface-container-low text-on-surface-variant hover:bg-surface-container transition-colors">Keagamaan</button>
    </section>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-5 md:gap-6 mb-8 sm:mb-10">
        <div class="gallery-item relative md:col-span-2 md:row-span-2 rounded-xl overflow-hidden soft-shadow hover:shadow-lg transition-shadow group bg-white cursor-pointer h-[250px] sm:h-[350px] md:h-[450px] lg:h-[600px] reveal">
            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDPaeNs2fUfgQTn4u6BLo4XBPHswwWVRbVcAmdxYCJUWHLu92VAkQHHDCv0YVpGboUqFAm7szif0alAolllbKSzZ1AzgtIM_-CYuBeYZC8hyDtKvNHrLWe7WMfT5C6lY09qc1gljMgZnGzOkiBjI6U3xfr9IAxJjeL0xtUWJV82cu38K6d4EGqUmgQ4bvesRs3MvD_-qMzVW0tLCer6iXJqEL3ToglAa_B1JljX0r3YM0BKoRu3oSeO" alt="Kegiatan Belajar">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4 sm:p-5">
                <span class="text-white font-label-sm text-label-sm mb-1">15 Oktober 2024</span>
                <h3 class="text-white font-title-lg text-base sm:text-lg md:text-xl">Kegiatan Belajar Bersama di Taman Panti</h3>
            </div>
        </div>

        <div class="gallery-item relative rounded-xl overflow-hidden soft-shadow hover:shadow-lg transition-shadow group bg-white cursor-pointer h-[180px] sm:h-[200px] md:h-[250px] lg:h-[280px] reveal" style="transition-delay: 100ms;">
            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA7sq2RLxn0CTOnHUFdg9GTFofGpg-fB16aMwjxnYAqVwFPFgVKtyPUfQCwn5jcKcv4ViqZqLu3VfW1uKqI0TdJbbmPZhDTDDD9bXcl-C3afmEf2a5sGViotglU23dqLfhyYQIMCpmlDm4QoQ6na5Hp3rvEjxze4ra3dpfmNnOBYx2ihZEuTlaHstIsHZ9PfSYc6Pdx0aGOHnJeb8fIF0TT7OKbbwjhRZQWWB27TkF-vepBBwN2RZrv" alt="Donasi Buku">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-3 sm:p-4">
                <span class="text-white font-label-sm text-label-sm mb-1">10 Oktober 2024</span>
                <h3 class="text-white font-title-lg text-sm sm:text-base">Penyaluran Donasi Buku</h3>
            </div>
        </div>

        <div class="gallery-item relative rounded-xl overflow-hidden soft-shadow hover:shadow-lg transition-shadow group bg-white cursor-pointer h-[180px] sm:h-[200px] md:h-[250px] lg:h-[280px] reveal" style="transition-delay: 200ms;">
            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCwLS7msP8P-CtqG-TYh0CMsZLuQ7Cs5xlxwOMn0V8XDNAAEHUn131tb1rHMTvUwPLeEAL-QXqzhT-G4e88vqt2V4WEWXLtuWhsKXcERluDUhWIybKzG8ATiLoTZnddODYcCUy1Ax2dMLxq2FMq-lG74ZARHTIjh6XqrNwyZtRKg8pXZhXqTZvURYxU4curMPrxTvtVZsPEffjwn-SGoJP4KGI4E-I8TRL8cOPmEK3P1rgdnjNjRchF" alt="Renovasi Asrama">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-3 sm:p-4">
                <span class="text-white font-label-sm text-label-sm mb-1">05 Oktober 2024</span>
                <h3 class="text-white font-title-lg text-sm sm:text-base">Renovasi Ruang Asrama</h3>
            </div>
        </div>

        <div class="gallery-item relative rounded-xl overflow-hidden soft-shadow hover:shadow-lg transition-shadow group bg-white cursor-pointer h-[200px] sm:h-[220px] md:h-[280px] reveal" style="transition-delay: 300ms;">
            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBUMTs_7U_CL3dbcDRvwo8l2asX3gDteN12kqvuAHlUM0KajPFzRQMOr9RgcmhScB6Dd6_B1mJuBRNHaEZk3tCsUX_rbPdyBAPfJipbqFe-iex9veAtOhY2k9lvCk-c4ZhsWjSl8cR1IeCthxv7EtNlylLaq3RYbi8y7PXEZg12bHpE3Yy2GpozaKKTwfGp-S9eSqX1v496rMY1SzkHGpOaMVv6zt7ut9DDuzKnkk_CEm0CfAU3NKs6" alt="Pengajian">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-3 sm:p-4">
                <span class="text-white font-label-sm text-label-sm mb-1">28 September 2024</span>
                <h3 class="text-white font-title-lg text-sm sm:text-base">Pengajian Rutin Mingguan</h3>
            </div>
        </div>

        <div class="gallery-item relative rounded-xl overflow-hidden soft-shadow hover:shadow-lg transition-shadow group bg-white cursor-pointer h-[200px] sm:h-[220px] md:h-[280px] reveal" style="transition-delay: 400ms;">
            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDUX-nfVaSlA0xudWvUJY_X4Gbls-rqqN4GSWEFhE2ajdFWeQ-wK1RliyKBe_Onn2M-u5B6TGfL520epca7cWJno3wNBDEqmv0YDbth069iRgzJjONcfTi9JOtAZ18dJSlzUsA6b4FxBsaUyJQrUoStXoHG1ybTff9h9Zbs2x1dHPGznxBe2_JpuJ0guzQSjyPlMvVCO4qxlUgDue1Se2elF8v8FOnNQeMEkALh5Jq4iYDk2S6Fxf78" alt="Pelatihan Seni">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-3 sm:p-4">
                <span class="text-white font-label-sm text-label-sm mb-1">20 September 2024</span>
                <h3 class="text-white font-title-lg text-sm sm:text-base">Pelatihan Keterampilan Seni</h3>
            </div>
        </div>

        <div class="gallery-item relative rounded-xl overflow-hidden soft-shadow hover:shadow-lg transition-shadow group bg-white cursor-pointer h-[200px] sm:h-[220px] md:h-[280px] reveal" style="transition-delay: 500ms;">
            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAatC1TzQC80lM8HzYGCZuKnItxaVdt8l3qYvIKlT3ZZE3xVchMJfOBDCzT45VCCZFjcqKf9G-Amkw482dWb2T2ZX99YbKHTE4CaKnwJzXPTiphHSluDHXRFqH2g1sRS5ABJiuRrdw9akxD4DRuwDsaYJbmF1rnbOlpZmtKMObZRLAoKEJbJqgtBPXnSJ5P9eB2eM8tMA2cvz62bSRR5SqcRfXrCY7G7wLgg17cf3oAGdiOfTvd5UFb" alt="Makan Siang">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-3 sm:p-4">
                <span class="text-white font-label-sm text-label-sm mb-1">15 September 2024</span>
                <h3 class="text-white font-title-lg text-sm sm:text-base">Makan Siang Bersama</h3>
            </div>
        </div>
    </div>

    <section class="text-center reveal">
        <button class="px-6 sm:px-8 py-2.5 sm:py-3 rounded-full font-label-md text-label-md border-2 border-primary text-primary hover:bg-primary hover:text-white transition-colors">Muat Lebih Banyak</button>
    </section>
</main>

<style>
    .gallery-item:hover img {
        transform: scale(1.05);
    }
</style>
@endsection