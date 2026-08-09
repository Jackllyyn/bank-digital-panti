@props(['active' => false])

@php
    $baseClasses = 'flex items-center gap-4 px-4 py-3 rounded-xl transition duration-200 font-medium group w-full text-left';
    
    // State Aktif: Background hijau muda, teks hijau tua, icon hijau
    $activeClasses = 'bg-emerald-50 text-emerald-700 [&_.menu-icon]:text-emerald-600 shadow-sm ring-1 ring-emerald-100';
    
    // State Tidak Aktif: Teks abu-abu, hover background abu-abu muda
    $inactiveClasses = 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 [&_.menu-icon]:group-hover:text-gray-800';
    
    $classes = $baseClasses . ' ' . ($active ? $activeClasses : $inactiveClasses);
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>