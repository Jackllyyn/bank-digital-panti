@extends('layouts.public')

@section('title', 'Tentang Kami - PAM Pesantunan')

@section('content')
<main class="pt-16 sm:pt-20 pb-10 sm:pb-14 md:pb-18 lg:pb-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">

    <section class="relative rounded-xl overflow-hidden mb-8 sm:mb-12 lg:mb-16 soft-shadow bg-surface-container-lowest h-[250px] sm:h-[300px] md:h-[400px] flex items-center justify-center">
        <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuD5SCMLAjtu5lExzZXE2U5x9zT5XUV0nrgV046J2MatvF3XOpp0tVByOwS6JlEiCD2AZRfOkvBcwDYocgFpLshuCUw1zHbkoKQXsIIzqeyjz8vBJ8dwT6VBAqo9gBaxTns1fJYOFJ7t-otEaCdbX4TBQoCnkMTWmSa3W0kUyOcxOTWAFX_RGLkNm8JUt48dFzBMXRl-5gFmpUwdX6u3okGF07EbnEMrlwzbK8JVXYPt0g070Rc5A-nt')"></div>
        <div class="relative z-10 text-center max-w-3xl px-4">
            <h1 class="font-display-lg text-3xl sm:text-4xl md:text-[48px] text-primary mb-2 sm:mb-3">Tentang Kami</h1>
            <p class="font-body-lg text-sm sm:text-base md:text-lg text-on-surface-variant px-2">Panti Asuhan Muhammadiyah Pesantunan berkomitmen untuk memberikan pengasuhan yang amanah, pendidikan yang berkualitas, dan transparansi pengelolaan yang terpercaya.</p>
        </div>
    </section>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 mb-8 sm:mb-12 lg:mb-16">
        <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow reveal">
            <div class="flex items-center gap-2 sm:gap-3 mb-3 text-primary">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">history_edu</span>
                <h2 class="font-headline-md text-xl sm:text-2xl">Sejarah Singkat</h2>
            </div>
            <p class="font-body-md text-sm sm:text-base text-on-surface-variant mb-3">Berdiri sejak tahun 1985, Panti Asuhan Muhammadiyah Pesantunan lahir dari semangat kepedulian sosial umat. Dimulai dari sebuah bangunan sederhana, kini kami telah berkembang menjadi institusi pengasuhan modern yang menaungi lebih dari 120 anak asuh.</p>
            <p class="font-body-md text-sm sm:text-base text-on-surface-variant">Perjalanan kami tidak lepas dari dukungan para donatur dan masyarakat yang menaruh kepercayaan penuh pada prinsip "Amanah" yang kami pegang teguh.</p>
        </div>
        <div class="rounded-xl overflow-hidden soft-shadow h-[200px] sm:h-[250px] md:h-[300px]">
            <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAfduf8xYKusSqYYPhrmJkGYGEFcN14xxQFyEKcStcSYW3H7LeVV8Ftiyl7aAaUdeXebNnGCVU4pd10cO7-1eF7zN6VK0rI8Q7eId9SKQCDvnUNwLr7vDXH5QLVQksC7ZZcu4V6lkKk3G2Ms9IO5-u3pmixY2wm6YZsiEDCvs_SzxdkY_1h8sZx00N--PywTm5wXEdUFM_pFxEWvyOQqdsGFLeSMBMFWs2jDNw3e6xbx5K6l89FtKeE" alt="Sejarah PAM Pesantunan">
        </div>
    </div>

    <section class="mb-8 sm:mb-12 lg:mb-16">
        <h2 class="font-headline-lg text-2xl sm:text-3xl lg:text-[32px] text-center text-primary mb-6 sm:mb-8 lg:mb-10 reveal">Visi &amp; Misi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-surface-bright rounded-xl p-5 sm:p-6 lg:p-8 border border-outline-variant/30 relative overflow-hidden group reveal">
                <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-[80px] sm:text-[100px] text-primary">visibility</span>
                </div>
                <h3 class="font-title-lg text-lg sm:text-xl text-primary mb-2 relative z-10">Visi Kami</h3>
                <p class="font-body-md text-sm sm:text-base text-on-surface-variant relative z-10">Menjadi lembaga pengasuhan anak yang unggul, mandiri, dan berlandaskan nilai-nilai Islam berkemajuan, serta menjadi model percontohan tata kelola panti yang transparan dan profesional di era digital.</p>
            </div>
            <div class="bg-surface-bright rounded-xl p-5 sm:p-6 lg:p-8 border border-outline-variant/30 relative overflow-hidden group reveal" style="transition-delay: 100ms;">
                <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-[80px] sm:text-[100px] text-secondary">explore</span>
                </div>
                <h3 class="font-title-lg text-lg sm:text-xl text-primary mb-2 relative z-10">Misi Kami</h3>
                <ul class="list-disc pl-4 sm:pl-5 font-body-md text-sm sm:text-base text-on-surface-variant space-y-1 sm:space-y-2 relative z-10">
                    <li>Memberikan pengasuhan paripurna (fisik, mental, spiritual) bagi anak asuh.</li>
                    <li>Menyelenggarakan pendidikan berkualitas yang adaptif terhadap perkembangan zaman.</li>
                    <li>Menerapkan sistem manajemen keuangan digital yang akuntabel dan transparan.</li>
                    <li>Membangun kemitraan strategis dengan berbagai pihak untuk kemandirian lembaga.</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow mb-8 sm:mb-12 lg:mb-16 border-l-4 border-secondary-container reveal">
        <div class="flex flex-col md:flex-row gap-6 lg:gap-8 items-center">
            <div class="md:w-1/2">
                <div class="inline-flex items-center gap-1 sm:gap-2 px-3 py-1 bg-secondary-fixed text-on-secondary-fixed rounded-full font-label-sm text-label-sm mb-2 sm:mb-3">
                    <span class="material-symbols-outlined text-sm">verified_user</span>
                    Komitmen Amanah
                </div>
                <h2 class="font-headline-md text-xl sm:text-2xl text-on-surface mb-2 sm:mb-3">Transparansi Finansial Digital</h2>
                <p class="font-body-md text-sm sm:text-base text-on-surface-variant mb-3">Kami memahami bahwa kepercayaan donatur adalah amanah terbesar. Oleh karena itu, PAM Pesantunan mengadopsi sistem pencatatan keuangan digital berbasis teknologi terkini.</p>
                <p class="font-body-md text-sm sm:text-base text-on-surface-variant">Setiap donasi, sekecil apapun, tercatat secara real-time. Kami menyediakan dashboard laporan keuangan yang dapat diakses publik, memastikan setiap rupiah tersalurkan tepat sasaran.</p>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <div class="w-full max-w-sm bg-white rounded-xl soft-shadow p-4 sm:p-5 border-t-4 border-secondary overflow-hidden relative">
                    <div class="absolute -right-10 -top-10 w-24 sm:w-32 h-24 sm:h-32 bg-secondary-fixed rounded-full opacity-20 blur-xl"></div>
                    <h4 class="font-label-md text-label-md text-on-surface-variant mb-2">Contoh Catatan Digital</h4>
                    <div class="text-xl sm:text-2xl font-bold text-on-surface mb-2">Rp Transparan</div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center py-1.5 sm:py-2 border-b border-surface-variant">
                            <span class="font-body-sm text-xs sm:text-sm text-on-surface-variant flex items-center gap-1 sm:gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">arrow_downward</span> Donasi Masuk
                            </span>
                            <span class="font-label-md text-sm sm:text-base text-primary">+ Rp 5.000.000</span>
                        </div>
                        <div class="flex justify-between items-center py-1.5 sm:py-2 border-b border-surface-variant">
                            <span class="font-body-sm text-xs sm:text-sm text-on-surface-variant flex items-center gap-1 sm:gap-2">
                                <span class="material-symbols-outlined text-outline text-sm">school</span> Biaya Pendidikan
                            </span>
                            <span class="font-label-md text-sm sm:text-base text-on-surface-variant">- Rp 1.200.000</span>
                        </div>
                        <div class="flex justify-between items-center py-1.5 sm:py-2">
                            <span class="font-body-sm text-xs sm:text-sm text-on-surface-variant flex items-center gap-1 sm:gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">arrow_downward</span> Donasi Masuk
                            </span>
                            <span class="font-label-md text-sm sm:text-base text-primary">+ Rp 2.500.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <h2 class="font-headline-lg text-2xl sm:text-3xl lg:text-[32px] text-center text-primary mb-6 sm:mb-8 lg:mb-10 reveal">Pengurus Panti</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 sm:gap-5 lg:gap-6">
            <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 text-center soft-shadow hover-soft-shadow transition-all reveal">
                <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-full overflow-hidden mb-2 sm:mb-3 border-2 border-primary-fixed-dim">
                    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAWavp5AlhUKAuvOR7rrhs2HkyouvlheaZ2ZcRID17PKfdp_OC7jYl101Z7r7oPVxnIyMsG7O47LOb4AMiDh5IHadlfZKXEJF5uV5ECVTq-vyezadM-y9hL-EPFejQei3ST-yarIwiiSjcwv1PI86XdzCla9HzSwZFgQoF65dLBBFC32SloFMOJmXbRKK9gkUjpvl8aLPDnQq8qS5GDkHkAxqJ_l-ctav_uxRZf6EyiRTWN6NxVhTaU" alt="Ketua Panti">
                </div>
                <h3 class="font-title-lg text-sm sm:text-lg text-on-surface">Bpk. H. Abdullah</h3>
                <p class="font-label-md text-xs sm:text-sm text-primary mt-1">Ketua Panti</p>
            </div>
            <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 text-center soft-shadow hover-soft-shadow transition-all reveal" style="transition-delay: 100ms;">
                <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-full overflow-hidden mb-2 sm:mb-3 border-2 border-primary-fixed-dim">
                    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAGvJMoEZE_yudR_vJgAXRVNKjiGZa0lFrYQip_9_YqAq9vARXpZd5atcMod6B96Ml67Kq49dUkA5dfDxoL2tAnNyOZjRs-mG5OFauERg9kpzx4Le4H4RqYaP80IEkaL6xYeUjuQARteKrvzYuyCVQY_2nc6-p1GTSybt5X9xb26LrR2YUHXYdAFUHrSgutC2b7ihnAWi9M8F7EfXNcvWzgj87Lm5S6HeNnMYMdnlUb7JowRnegtGG0" alt="Sekretaris">
                </div>
                <h3 class="font-title-lg text-sm sm:text-lg text-on-surface">Ibu Siti Aminah</h3>
                <p class="font-label-md text-xs sm:text-sm text-primary mt-1">Sekretaris</p>
            </div>
            <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 text-center soft-shadow hover-soft-shadow transition-all reveal" style="transition-delay: 200ms;">
                <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-full overflow-hidden mb-2 sm:mb-3 border-2 border-primary-fixed-dim">
                    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCNErfof9AjTy9aDqnBs76ZqubUqQYpNTjykdl2kFoEC2zx0Slfcu90np5d96xbdsG9Oa8gThqQbxAjeAZ0ubaE4qMnVGSYgKJdMkpNvtBHfbpUuIQJcNSUYQ1CqnVb6EACtQBwKgznI_iLV4TCYQ2vokdB6B4VzEtw3SZxho4S71aiD4WjTtAIhiwVK6-6Bo5ME1u1Kb59Batec0FGXzrqYUXWZdP5zX55vmpfxKGO2mRhO4HOMzeh" alt="Bendahara">
                </div>
                <h3 class="font-title-lg text-sm sm:text-lg text-on-surface">Bpk. Rahmat H.</h3>
                <p class="font-label-md text-xs sm:text-sm text-primary mt-1">Bendahara Digital</p>
            </div>
            <div class="bg-surface-container-lowest rounded-xl p-4 sm:p-5 text-center soft-shadow hover-soft-shadow transition-all reveal" style="transition-delay: 300ms;">
                <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-full overflow-hidden mb-2 sm:mb-3 border-2 border-primary-fixed-dim">
                    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDb1TFpT-rytI0hl5pMd4oAP04GzkJD1JXx3HV89bvV3KV2SBi-uqGKF0kTnVuLZRfvlc_SMJOoVmhUU41oCGwl1Hi4hd7jDcLJ1rZxkmd-QrTu8ap_O6GLm6uqQKZJC5cg35MD80imMgo2Hhf022vnXvcfZ9zmhW6Teh9HCRDB4RRLYVh_wcUw-Bzib27DdSaEMmZ8pFEEocPhMz9LjBQCyiRMGoRS6Aa4saV5fjbYdFkRJxccPdEq" alt="Kepala Pengasuhan">
                </div>
                <h3 class="font-title-lg text-sm sm:text-lg text-on-surface">Ibu Fatimah</h3>
                <p class="font-label-md text-xs sm:text-sm text-primary mt-1">Kepala Pengasuhan</p>
            </div>
        </div>
    </section>
</main>
@endsection