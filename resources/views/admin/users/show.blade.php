<x-app-layout>

    <!-- Sidebar -->
    <x-sidebar/>

    <!-- Main Content -->
    <main class="flex-1 px-8 mt-8 bg-[#222222] w-4/5">

        <!-- Success Message -->
        <x-success-message/>

        <div class="flex justify-between items-start mb-6">
            <h1 class="text-white text-4xl mb-6 font-bold">User Details</h1>
            <div class="flex space-x-4">

                <!-- Edit Button -->
                <a href="{{ route('users.edit', $user->id) }}"
                   class="bg-[#F84453] text-black font-semibold px-4 py-2 hover:bg-red-400">Edit</a>

                <!-- Delete Button -->
                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-[#F84453] text-black font-semibold px-4 py-2 hover:bg-red-400">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- User Details Table -->
        <div class="relative overflow-x-auto">
            <table class="w-full">
                <tbody>
                <tr class="">
                    <td class="bg-[#303030] text-white text-sm p-4">First Name</td>
                    <td class="bg-[#303030] text-sm p-4 text-[#FFCC34] font-bold">{{ $user->first_name }}</td>
                </tr>
                <tr class="">
                    <td class="bg-[#303030] text-white text-sm p-4">Last Name</td>
                    <td class="bg-[#303030] text-sm p-4 text-[#FFCC34] font-bold">{{ $user->last_name }}</td>
                </tr>
                <tr class="">
                    <td class="bg-[#303030] text-white text-sm p-4">Email Address</td>
                    <td class="bg-[#303030] text-sm p-4 text-[#FFCC34] font-bold">{{ $user->email }}</td>
                </tr>
                <tr class="">
                    <td class="bg-[#303030] text-white text-sm p-4">Role</td>
                    <td class="bg-[#303030] text-sm p-4 text-[#FFCC34] font-bold">{{ $user->role_names->implode(', ') }}</td>
                </tr>
                <tr class="">
                    <td class="bg-[#303030] text-white text-sm p-4">Member Since</td>
                    <td class="bg-[#303030] text-sm p-4 text-[#FFCC34] font-bold">{{ $user->created_at->format('d M Y') }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </main>
</x-app-layout>
