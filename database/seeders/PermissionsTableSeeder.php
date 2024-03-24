<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $allRoles = Role::all()->keyBy('id');

        $permissions = [
            'administer-users' => [Role::ROLE_ADMIN],
            'view-admin-dashboard' => [Role::ROLE_ADMIN, Role::ROLE_CONTENT_MANAGER],
        ];

        foreach ($permissions as $key => $roles) {
            $permission = Permission::create(['name' => $key]);
            foreach ($roles as $role) {
                $allRoles[$role]->permissions()->attach($permission->id);
            }
        }
    }
}

