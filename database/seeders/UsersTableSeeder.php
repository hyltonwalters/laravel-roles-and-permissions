<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Create the Admin User
        User::factory()->create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@me.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin'),
            'remember_token' => Str::random(60),
        ]);

        // Create the Content Manager User
        User::factory()->create([
            'first_name' => 'Content',
            'last_name' => 'Manager',
            'email' => 'manager@me.com',
            'email_verified_at' => now(),
            'password' => bcrypt('manager'),
            'remember_token' => Str::random(60),
        ]);

        // Create all other users
        User::factory()->count(98)->create();
    }
}
