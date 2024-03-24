<!-- Search box -->
<div class="mb-6">
    <form action="{{ auth()->user()->hasRole('admin') ? route('users.index') : route('manager.dashboard') }}"
          method="GET">
        <label for="search" class="text-white block mb-2 w-1/4">User name</label>
        <div class="flex items-center">
            <input type="text" id="search" name="search" placeholder="Search for users"
                   value="{{ request('search') }}"
                   class="h-10 sm:w-1/4 placeholder-[#777] text-sm text-[#777] border-2 border-[#303030] bg-[#303030] focus:ring-[#222] focus:border-none">
            <button type="submit"
                    class="p-3 bg-[#303030] border-l-2 border-[#222] text-[#222] hover:bg-[#F84453]]">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-search text-[#222]" viewBox="0 0 16 16">
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </button>
        </div>
    </form>
</div>
