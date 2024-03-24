<x-app-layout>

    <!-- Sidebar -->
    <x-sidebar/>

    <!-- Main Content -->
    <main class="flex-1 px-8 mt-8 bg-[#222222] w-4/5">

        <!-- Success Message -->
        <x-success-message/>

        <a href="{{ route('dashboard') }}" class="text-white hover:underline">Back to Dashboard</a>

        <div class="flex items-start justify-between ">
            <h1 class="text-white text-4xl mb-10 mt-4 font-bold">Users</h1>
            <!-- Create new user button -->
            @can('viewAny', App\Models\User::class)
                <a href="{{ route('users.create') }}"
                   class="justify-end bg-[#F84453] text-black font-semibold px-4 py-2 hover:bg-red-400">Create New
                    User</a>
            @endcan
        </div>

        <!-- Search box -->
        <x-search-input/>

        <div class="relative overflow-x-auto mb-4">
            <!-- Users table -->
            <table class="w-full">
                <thead>
                <tr>
                    <th scope="col" class="text-left text-white text-sm font-medium pl-4">First Name</th>
                    <th scope="col" class="text-left text-white text-sm font-medium pl-4">Last Name</th>
                    <th scope="col" class="text-left text-white text-sm font-medium pl-4">Email Address</th>
                    <th scope="col" class="text-left text-white text-sm font-medium pl-4">Role</th>
                    <th scope="col" class="text-left text-white text-sm font-medium pl-4">Member Since</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="">
                        <td class="bg-[#303030] text-white">
                            <div class="p-4 mb-1 text-sm">
                                <a href="{{ auth()->user()->hasRole('admin') ? route('users.show', $user->id) : route('users.index') }}"
                                   class="
                                   @can('viewAny', App\Models\User::class)
                                   bg-[#303030] underline underline-offset-4 decoration-[#FFCC34] text-[#FFCC34]
                                   @endcan
                                   ">{{ $user->first_name }}
                                </a>
                            </div>
                        </td>
                        <td class="bg-[#303030] text-white">
                            <div class="p-4 mb-1 text-sm">{{ $user->last_name }}</div>
                        </td>
                        <td class="bg-[#303030] text-white">
                            <div class="p-4 mb-1 text-sm">{{ $user->email }}</div>
                        </td>
                        <td class="bg-[#303030] text-white">
                            <div class="p-4 mb-1 text-sm">{{ $user->role_names->implode(', ') }}</div>
                        </td>
                        <td class="bg-[#303030] text-white">
                            <div class="p-4 mb-1 text-sm">{{ $user->created_at->format('d M Y') }}</div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination links -->
        {{ $users->links('pagination::tailwind') }}
    </main>
</x-app-layout>
