@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-none text-start text-base font-medium text-white dark:text-white bg-[#303030] dark:bg-[#303030] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-none text-start text-base font-medium text-white dark:text-white bg-[#303030] hover:text-white dark:hover:text-white hover:bg-[#222222] dark:hover:bg-[#222222] hover:bg-[#222222] dark:hover:bg-[#222222] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
