<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['active' => false]));

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

foreach (array_filter((['active' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $baseClasses = 'flex items-center gap-4 px-4 py-3 rounded-xl transition duration-200 font-medium group w-full text-left';
    
    // State Aktif: Background hijau muda, teks hijau tua, icon hijau
    $activeClasses = 'bg-emerald-50 text-emerald-700 [&_.menu-icon]:text-emerald-600 shadow-sm ring-1 ring-emerald-100';
    
    // State Tidak Aktif: Teks abu-abu, hover background abu-abu muda
    $inactiveClasses = 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 [&_.menu-icon]:group-hover:text-gray-800';
    
    $classes = $baseClasses . ' ' . ($active ? $activeClasses : $inactiveClasses);
?>

<a <?php echo e($attributes->merge(['class' => $classes])); ?>>
    <?php echo e($slot); ?>

</a><?php /**PATH C:\xampp\htdocs\web-panti\resources\views/components/sidebar-link.blade.php ENDPATH**/ ?>