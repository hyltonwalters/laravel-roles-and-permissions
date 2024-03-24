@php
    // Hide the sidebar on small screens
    $hideOnSmallScreens = 'hidden sm:block';
@endphp
<aside class="bg-[#1D1D1D] text-white py-6 px-2 w-1/5 {{ $hideOnSmallScreens }}">
    <a href="{{ auth()->user()->hasRole('admin') ? route('users.index') : route('manager.dashboard') }}"
       class="text-white relative flex mx-2 py-2">
        <img src="{{ asset('storage/assets/icons/logo.svg') }}" class="h-7" alt="Logo">
    </a>
    <a href="{{ auth()->user()->hasRole('admin') ? route('users.index') : route('manager.dashboard') }}" class="relative flex items-center my-4 mx-2 px-4 py-2
    @if(request()->routeIs('users.index') || request()->routeIs('manager.dashboard')) bg-[#F84453] text-black hover:bg-red-400 @endif">
        <img src="{{ asset('storage/assets/icons/users.svg') }}" class="h-6 pr-2" alt="Users">
        <span class="font-semibold">Users</span>
    </a>
    @can('viewAny', App\Models\User::class)
        <span class="relative flex items-center my-4 mx-2 px-4 py-2
        @if(!request()->routeIs('users.index')) bg-[#F84453] text-black @endif">
            <img src="{{ asset('storage/assets/icons/pages.svg') }}" class="h-6 pr-2 invert" alt="Users">
            <span class="font-semibold">Pages</span>
        </span>
    @endcan
</aside>
