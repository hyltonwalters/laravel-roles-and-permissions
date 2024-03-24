<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class RolesUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the admin and manager users by their email addresses
        $admin = User::where('email', 'admin@me.com')->first();
        $manager = User::where('email', 'manager@me.com')->first();

        if ($admin && $manager) {
            // Attach the admin and content manager roles to the admin user
            $admin->roles()->attach([1, 2]);

            // Attach the manager role to the manager user
            $manager->roles()->attach(2);
        }

        // Attach role ID 3 to all other users
        User::whereNotIn('email', ['admin@me.com', 'manager@me.com'])
            ->each(function ($user) {
                $user->roles()->attach(3);
            });
    }
}
