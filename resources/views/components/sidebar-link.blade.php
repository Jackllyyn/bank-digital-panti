@props(['href', 'active' => false])

<a href="{{ $href }}" 
   class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition rounded-md {{ $active ? 'bg-blue-100 text-blue-600 font-medium' : '' }}">
    {!! $slot !!}
</a>