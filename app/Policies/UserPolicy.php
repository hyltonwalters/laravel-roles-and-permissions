<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewDashboard(User $user): bool
    {
        return $user->hasAnyPermission([Permission::ADMIN_DASHBOARD, Permission::ADMINISTER_USERS]);
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermission(Permission::ADMINISTER_USERS);
    }

    public function view(User $user): bool
    {
        return $user->hasPermission(Permission::ADMINISTER_USERS);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(Permission::ADMINISTER_USERS);
    }

    public function update(User $user): bool
    {
        return $user->hasPermission(Permission::ADMINISTER_USERS);
    }

    public function delete(User $user): bool
    {
        return $user->hasPermission(Permission::ADMINISTER_USERS);
    }
}
