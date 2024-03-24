<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
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
}
