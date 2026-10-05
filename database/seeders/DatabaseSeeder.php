<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('123123123'),
            'role' => 'admin',
        ]);

        // Create manager user
        User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => bcrypt('123123123'),
            'role' => 'manager',
        ]);

        // Create normal user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('123123123'),
            'role' => 'normal_user',
        ]);

        // $this->call([
        //     PerfumesCategorySeeder::class,
        //     SunglassesCategorySeeder::class,
        //     PerfumeSeeder::class,
        //     SunglassesSeeder::class,
        //     ImageSeeder::class,
        // ]);
    }
}
