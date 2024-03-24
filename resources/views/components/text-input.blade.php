@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full text-gray-300 py-2 px-0 bg-[#303030] border-solid border-0 border-b text-sm focus:!ring-transparent focus:!border-white']) !!}>
