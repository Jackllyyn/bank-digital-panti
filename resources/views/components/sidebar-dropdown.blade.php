@props(['title', 'icon', 'active' => false])

<div x-data="{ open: {{ $active ? 'true' : 'false' }} }" class="relative">
    {{-- Tombol Toggle Dropdown --}}
    <button @click="open = !open"
        type="button"
        class="w-full flex items-center justify-between gap-4 px-4 py-3 rounded-xl transition duration-200 font-medium group
        {{ $active ? 'text-emerald-700 bg-emerald-50 shadow-sm ring-1 ring-emerald-100' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
        
        <div class="flex items-center gap-3">
            <span class="{{ $active ? 'text-emerald-600 [&_.menu-icon]:text-emerald-600' : 'text-gray-400 group-hover:text-gray-600 [&_.menu-icon]:text-gray-400 [&_.menu-icon]:group-hover:text-gray-600' }}">
                {!! $icon !!}
            </span>
            <span class="whitespace-nowrap" x-show="!sidebarMinimized"
                  x-transition:enter="transition-opacity duration-300 delay-100"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100"
                  x-transition:leave="transition-opacity duration-100"
                  x-transition:leave-start="opacity-100"
                  x-transition:leave-end="opacity-0">{{ $title }}</span>
        </div>
        
        {{-- Icon Panah --}}
        <svg class="w-3 h-3 transition-transform duration-200 opacity-50 group-hover:opacity-100"
             :class="open ? 'rotate-180' : ''" x-show="!sidebarMinimized"
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </button>

    {{-- Isi Dropdown (Sub-menu) --}}
    <div x-show="open" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="mt-1 pl-4">
         
         {{-- Garis vertikal tipis untuk hierarki visual --}}
         <div class="space-y-1 border-l-2 border-gray-100 pl-2">
            {{ $slot }}
         </div>
    </div>
</div>