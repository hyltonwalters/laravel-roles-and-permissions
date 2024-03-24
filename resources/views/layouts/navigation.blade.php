@php use App\Models\User; @endphp
<nav x-data="{ open: false }" class="bg-white dark:bg-[#303030] border-b border-white dark:text-white">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current"/>
                    </a>
                </div>
            </div>

            <!-- Admin Button -->
            <div class="flex items-center space-x-4">
                @can('viewAny', User::class)
                    <form action="{{ route('users.index') }}" method="GET">
                        <button type="submit"
                                class="bg-[#F84453]/[.75] text-black font-semibold px-4 py-2 hover:bg-red-400">
                            Admin
                        </button>
                    </form>
                @elsecan('viewDashboard', User::class)
                    <form action="{{ route('manager.dashboard') }}" method="GET">
                        <button type="submit"
                                class="bg-[#F84453]/75 text-black font-semibold px-4 py-2 hover:bg-red-400">
                            View Users
                        </button>
                    </form>
                @endcan

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium text-white dark:text-white bg-white bg-[#303030] dark:bg-[#303030] hover:text-white dark:hover:text-white focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white dark:text-white bg-white dark:bg-[#303030] hover:text-white dark:hover:text-white focus:outline-none transition ease-in-out duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white bg-[#303030] dark:bg-[#303030] dark:hover:bg-[#303030]">
            <div class="px-4">
                <div
                    class="font-medium text-base text-white dark:text-white">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                <div class="font-medium text-sm text-text">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
