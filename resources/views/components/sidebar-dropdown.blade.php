@props(['title', 'icon', 'active' => false])

<div x-data="{ open: {{ $active ? 'true' : 'false' }} }" class="mb-1">
    <button 
        @click="open = !open" 
        class="flex items-center w-full px-6 py-3 text-gray-700 transition rounded-md hover:bg-blue-100 hover:text-blue-600 {{ $active ? 'bg-blue-100 text-blue-600 font-medium' : '' }}">
        
        <span class="flex items-center">
            {!! $icon !!}
            <span class="ml-3">{{ $title }}</span>
        </span>
        
        <svg class="w-4 h-4 ml-auto transition-transform" 
             :class="{ 'rotate-90': open }" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <div x-show="open" x-transition x-cloak class="mt-1 ml-10 space-y-1">
        {{ $slot }}
    </div>
</div>