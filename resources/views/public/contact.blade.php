@extends('layouts.public')

@section('title', 'Kontak - PAM Pesantunan')

@section('content')
<main class="pt-16 sm:pt-20 pb-10 sm:pb-14 md:pb-18 lg:pb-20 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-20 max-w-[1440px] mx-auto">

    <div class="text-center mb-8 sm:mb-12 lg:mb-16 reveal">
        <h1 class="font-display-lg text-3xl sm:text-4xl md:text-[48px] text-on-surface mb-2 sm:mb-3">Hubungi Kami</h1>
        <p class="font-body-lg text-sm sm:text-base md:text-lg text-on-surface-variant max-w-2xl mx-auto">Kami siap membantu dan menjawab pertanyaan Anda. Jangan ragu untuk menghubungi kami.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 lg:gap-10 xl:gap-12">
        <div class="lg:col-span-5 flex flex-col gap-6">
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow border border-surface-container-low reveal">
                <h2 class="font-title-lg text-lg sm:text-xl text-on-surface mb-4">Informasi Kontak</h2>
                <div class="flex flex-col gap-4">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary">location_on</span>
                        <div>
                            <h3 class="font-label-md text-label-md text-on-surface">Alamat</h3>
                            <p class="font-body-md text-sm sm:text-base text-on-surface-variant mt-1">
                                {{ $identitas->alamat ?? 'Jl. Raya Pesantunan No. 123, Kecamatan Wanasari, Kabupaten Brebes, Jawa Tengah, 52252' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary">call</span>
                        <div>
                            <h3 class="font-label-md text-label-md text-on-surface">Telepon</h3>
                            <p class="font-body-md text-sm sm:text-base text-on-surface-variant mt-1">{{ $identitas->telepon ?? '+62 283 123456' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary">mail</span>
                        <div>
                            <h3 class="font-label-md text-label-md text-on-surface">Email</h3>
                            <p class="font-body-md text-sm sm:text-base text-on-surface-variant mt-1">{{ $identitas->email ?? 'info@pampesantunan.or.id' }}</p>
                        </div>
                    </div>
                    @if($identitas->website ?? false)
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary">public</span>
                            <div>
                                <h3 class="font-label-md text-label-md text-on-surface">Website</h3>
                                <p class="font-body-md text-sm sm:text-base text-on-surface-variant mt-1">{{ $identitas->website }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="mt-5 sm:mt-6">
                    <h3 class="font-label-md text-label-md text-on-surface mb-2">Media Sosial</h3>
                    <div class="flex gap-2 sm:gap-3">
                        <a class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-surface-container-low flex items-center justify-center text-on-surface-variant hover:bg-primary-container hover:text-on-primary-container transition-colors" href="#">
                            <span class="material-symbols-outlined text-sm sm:text-base">share</span>
                        </a>
                        <a class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-surface-container-low flex items-center justify-center text-on-surface-variant hover:bg-primary-container hover:text-on-primary-container transition-colors" href="#">
                            <span class="material-symbols-outlined text-sm sm:text-base">public</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-xl soft-shadow border border-surface-container-low overflow-hidden h-48 sm:h-56 md:h-64 relative group reveal" style="transition-delay: 100ms;">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.0!2d109.0!3d-7.0!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDAnMDAuMCJTIDEwOcKwMDAnMDAuMCJF!5e0!3m2!1sid!2sid!4v1234567890" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <div class="lg:col-span-7 reveal" style="transition-delay: 200ms;">
            <div class="bg-surface-container-lowest rounded-xl p-5 sm:p-6 lg:p-8 soft-shadow border border-surface-container-low h-full">
                <h2 class="font-title-lg text-lg sm:text-xl text-on-surface mb-2">Kirim Pesan</h2>
                <p class="font-body-md text-sm sm:text-base text-on-surface-variant mb-5 sm:mb-6">Silakan isi formulir di bawah ini untuk mengirimkan pertanyaan, saran, atau informasi lainnya.</p>
                
                <form class="flex flex-col gap-4 sm:gap-5" method="POST" action="{{ route('contact.send') }}">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label class="font-label-md text-label-md text-on-surface" for="nama">Nama Lengkap</label>
                            <input class="bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/50 @error('nama') border-red-500 @enderror" 
                                   id="nama" 
                                   name="nama" 
                                   placeholder="Masukkan nama Anda" 
                                   type="text" 
                                   value="{{ old('nama') }}"
                                   required>
                            @error('nama')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="font-label-md text-label-md text-on-surface" for="email">Alamat Email</label>
                            <input class="bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/50 @error('email') border-red-500 @enderror" 
                                   id="email" 
                                   name="email" 
                                   placeholder="nama@email.com" 
                                   type="email" 
                                   value="{{ old('email') }}"
                                   required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-1">
                        <label class="font-label-md text-label-md text-on-surface" for="telepon">Nomor Telepon</label>
                        <input class="bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/50 @error('telepon') border-red-500 @enderror" 
                               id="telepon" 
                               name="telepon" 
                               placeholder="0812-3456-7890" 
                               type="tel" 
                               value="{{ old('telepon') }}">
                        @error('telepon')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex flex-col gap-1">
                        <label class="font-label-md text-label-md text-on-surface" for="subjek">Subjek</label>
                        <select class="bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all @error('subjek') border-red-500 @enderror" 
                                id="subjek" 
                                name="subjek" 
                                required>
                            <option value="">Pilih Subjek</option>
                            <option value="informasi" {{ old('subjek') == 'informasi' ? 'selected' : '' }}>Informasi Panti</option>
                            <option value="donasi" {{ old('subjek') == 'donasi' ? 'selected' : '' }}>Konfirmasi Donasi</option>
                            <option value="kunjungan" {{ old('subjek') == 'kunjungan' ? 'selected' : '' }}>Rencana Kunjungan</option>
                            <option value="lainnya" {{ old('subjek') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('subjek')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex flex-col gap-1">
                        <label class="font-label-md text-label-md text-on-surface" for="pesan">Pesan</label>
                        <textarea class="bg-surface-bright border border-outline-variant rounded-lg px-3 sm:px-4 py-2.5 sm:py-3 font-body-md text-sm sm:text-base text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/50 resize-y @error('pesan') border-red-500 @enderror" 
                                  id="pesan" 
                                  name="pesan" 
                                  placeholder="Tulis pesan Anda di sini..." 
                                  rows="4 sm:rows-5" 
                                  required>{{ old('pesan') }}</textarea>
                        @error('pesan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
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