<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        foreach ($users as $user) {
            $location = $user->locations()->create([
                'ip_address' => fake()->ipv4,
                'user_agent' => fake()->userAgent,
                'location' => fake()->city,
                'login_at' => now(),
            ]);
            $user->locations()->save($location);
        }
    }
}
