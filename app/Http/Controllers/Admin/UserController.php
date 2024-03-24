<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserCreateRequest;
use App\Http\Requests\Auth\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $this->authorize('viewDashboard', User::class);

        $query = User::query();

        // Check if there is a search query
        if ($request->has('search')) {
            $searchTerm = $request->search;

            // Perform the search on relevant fields
            $query->where('first_name', 'like', "%$searchTerm%")
                ->orWhere('last_name', 'like', "%$searchTerm%")
                ->orWhere('email', 'like', "%$searchTerm%");
        }

        $users = $query->paginate(10);

        return view('manager.dashboard', compact('users'));
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $query = User::query();

        // Check if there is a search query
        if ($request->has('search')) {
            $searchTerm = $request->search;

            // Perform the search on relevant fields
            $query->where('first_name', 'like', "%$searchTerm%")
                ->orWhere('last_name', 'like', "%$searchTerm%")
                ->orWhere('email', 'like', "%$searchTerm%");
        }

        $users = $query->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create(User $user)
    {
        $this->authorize('create', $user);

        // Eager Loading with User relationship to avoid using Role::all() for querying the db
        $roles = Role::with('users')->paginate(3);

        $roleNames = ['1' => 'Admin', '2' => 'Content Manager', '3' => 'User'];

        return view('admin.users.create', compact('roles', 'roleNames'));
    }

    public function store(UserCreateRequest $request, User $user): RedirectResponse
    {
        $this->authorize('create', $user);

        // Get user data, user location data, and role from the form request
        $data = $request->createUser();

        // Create the user
        $user = User::create($data['userData']);

        // Create the user location associated with the user
        $user->locations()->create($data['userLocationData']);

        // Fetch roles from the returned data
        $roles = Role::whereIn('id', $data['roles'])->get();

        // Attach the role to the user
        $user->roles()->attach($roles);

        return redirect()->route('users.index')->with('status', 'User Created Successfully!');
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        // Select the roles that belong to the user
        $selectedRoleIds = $user->roles()->pluck('id')->toArray();

        $roleNames = ['1' => 'Admin', '2' => 'Content Manager', '3' => 'User'];

        return view('admin.users.edit', compact('user', 'roleNames', 'selectedRoleIds'));
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        // Validate the incoming request data
        $validatedData = $request->validated();

        // Check if the password field is filled
        if ($request->filled('password')) {
            // Hash the new password
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            // Remove the password field if not filled
            unset($validatedData['password']);
        }

        // Update the user with the validated data
        $user->update($validatedData);

        // Sync/update the user roles with the provided roles
        $user->roles()->sync($request->roles);

        // Redirect back to the user detail page with a success message
        return redirect()->route('users.show', $user->id)->with('status', 'User Updated Successfully!');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        // Delete the user
        $user->delete();

        return redirect()->route('users.index')->with('status', 'User Deleted Successfully!');
    }
}
