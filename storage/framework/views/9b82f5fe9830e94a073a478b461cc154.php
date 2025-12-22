<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'icon', 'active' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['title', 'icon', 'active' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div x-data="{ open: <?php echo e($active ? 'true' : 'false'); ?> }" class="mb-1">
    <button 
        @click="open = !open" 
        class="flex items-center w-full px-6 py-3 text-gray-700 transition rounded-md hover:bg-blue-100 hover:text-blue-600 <?php echo e($active ? 'bg-blue-100 text-blue-600 font-medium' : ''); ?>">
        
        <span class="flex items-center">
            <?php echo $icon; ?>

            <span class="ml-3"><?php echo e($title); ?></span>
        </span>
        
        <svg class="w-4 h-4 ml-auto transition-transform" 
             :class="{ 'rotate-90': open }" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <div x-show="open" x-transition x-cloak class="mt-1 ml-10 space-y-1">
        <?php echo e($slot); ?>

    </div>
</div><?php /**PATH C:\xampp\htdocs\web-panti\resources\views/components/sidebar-dropdown.blade.php ENDPATH**/ ?>