<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductionDemoSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'content-manager']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $administerUsers = Permission::firstOrCreate(['name' => 'administer-users']);
        $viewAdminDashboard = Permission::firstOrCreate(['name' => 'view-admin-dashboard']);

        $adminRole->permissions()->syncWithoutDetaching([
            $administerUsers->id,
            $viewAdminDashboard->id,
        ]);
        $managerRole->permissions()->syncWithoutDetaching([
            $viewAdminDashboard->id,
        ]);

        $admin = User::updateOrCreate(
            ['email' => 'admin@me.com'],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email_verified_at' => now(),
                'password' => 'admin',
            ]
        );

        $manager = User::updateOrCreate(
            ['email' => 'manager@me.com'],
            [
                'first_name' => 'Content',
                'last_name' => 'Manager',
                'email_verified_at' => now(),
                'password' => 'manager',
            ]
        );

        $demoUser = User::updateOrCreate(
            ['email' => 'user@me.com'],
            [
                'first_name' => 'Demo',
                'last_name' => 'User',
                'email_verified_at' => now(),
                'password' => 'user',
            ]
        );

        $admin->roles()->sync([$adminRole->id, $managerRole->id]);
        $manager->roles()->sync([$managerRole->id]);
        $demoUser->roles()->sync([$userRole->id]);
    }
}
