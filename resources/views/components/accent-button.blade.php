<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#F84453] border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-400 focus:outline-none transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
