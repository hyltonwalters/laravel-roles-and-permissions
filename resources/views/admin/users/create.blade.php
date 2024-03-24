<x-app-layout>

    <!-- Sidebar -->
    <x-sidebar/>

    <!-- Main Content -->
    <main class="flex-1 px-8 mt-8 bg-[#222222] w-4/5">

        <!-- Success Message -->
        <x-success-message/>
        <a href="{{ route('users.index') }}" class="text-white hover:underline">Back to Users</a>
        <h1 class="text-white text-4xl mb-10 mt-4 font-bold">Create New User</h1>

        <form action="{{ route('users.store') }}" method="POST" class="bg-[#303030] px-8 pt-1 pb-8">
            @csrf

            <h1 class="text-white text-2xl my-4 font-semibold">User Detail</h1>
            <div class="mb-4 flex flex-wrap sm:w-1/2">
                <!-- First Name -->
                <div class="w-full md:w-1/2 md:pr-2 mb-1 mt-2">
                    <x-input-label for="first_name" class="block text-white text-sm mb-1 font-normal">First name
                    </x-input-label>
                    <x-text-input type="text" name="first_name" id="first_name"
                                  value="{{ old('first_name') }}"/>
                    <x-input-error class="mt-2" :messages="$errors->get('first_name')"/>
                </div>

                <!-- Last name -->
                <div class="w-full md:w-1/2 md:pl-2 mb-1 mt-2">
                    <x-input-label for="last_name" class="block text-white text-sm mb-1 font-normal">Last name
                    </x-input-label>
                    <x-text-input type="text" name="last_name" id="last_name"
                                  value="{{ old('last_name') }}"/>
                    <x-input-error class="mt-2" :messages="$errors->get('last_name')"/>
                </div>
            </div>

            <!-- Email -->
            <div class="mb-4 sm:w-1/2">
                <x-input-label for="email" class="block text-white text-sm mb-1 font-normal">Email</x-input-label>
                <x-text-input type="email" name="email" id="email" value="{{ old('email') }}"
                              autocomplete="username"/>
                <x-input-error class="mt-2" :messages="$errors->get('email')"/>
            </div>

            <!-- Select Multiple Roles -->
            <div class="mb-4 sm:w-1/2">
                <label for="roles" class="block text-white text-sm mb-1 font-normal">Roles</label>

                <div
                    x-data="{ open: false, selectedOptions: [], roleNames: { 1: 'Admin', 2: 'Content Manager', 3: 'User' } }"
                    class="max-w-md">
                    <div class="relative">
                        <button @click="open = !open"
                                class="bg-[#303030] px-4 py-2 my-2 text-white border border-white focus:outline-none hover:bg-[#222]">
                            <span x-show="selectedOptions.length === 0">Select Roles</span>
                            <template x-if="selectedOptions.length > 0">
                                <span x-text="selectedOptions.map(id => roleNames[id]).join(', ')"
                                      class="whitespace-nowrap"></span>
                            </template>
                        </button>

                        <div x-show="open" @click.away="open = false"
                             class="w-full bg-[#303030] border border-white">
                            <template x-for="(name, id) in roleNames" :key="id">
                                <label :for="'role_' + id" class="block p-3 hover:bg-[#222] cursor-pointer">
                                    <input type="checkbox" name="roles[]" x-model="selectedOptions" :value="id"
                                           :id="'role_' + id"
                                           class="mr-2 cursor-pointer focus:ring-[#222]">
                                    <span x-text="name" class="text-white"></span>
                                </label>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 flex flex-wrap sm:w-1/2">
                <!-- Password -->
                <div class="w-full md:w-1/2 md:pr-2 mb-4">
                    <x-input-label for="password" class="block text-white text-sm mb-1 font-normal">Password
                    </x-input-label>
                    <x-text-input id="password" name="password" type="password" class="mt-2 block w-full" required
                                  autocomplete="new-password"/>
                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <!-- Confirm Password -->
                <div class="w-full md:w-1/2 md:pl-2 mb-4">
                    <x-input-label for="password_confirmation" class="block text-white text-sm mb-1 font-normal">Confirm
                        Password
                    </x-input-label>
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                  class="mt-2 block w-full" required autocomplete="new-password"/>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between mb-2">
                <button type="submit"
                        class="text-[#FFCC34] outline outline-2 outline-offset-1 py-2 px-4 rounded-full focus:shadow-outline text-xs hover:text-yellow-500">
                    Create User
                </button>
            </div>
        </form>
    </main>
</x-app-layout>
