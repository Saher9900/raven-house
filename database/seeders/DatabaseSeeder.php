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
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone_number' => '01282236170',
            'password' => bcrypt('123123123'),
            'role' => 'admin',
            'shipping_address' => 'Zagazig'
        ]);

        // Create manager user
        User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'phone_number' => '01282236170',
            'password' => bcrypt('123123123'),
            'role' => 'manager',
            'shipping_address' => 'Zagazig'
        ]);

        // Create normal user
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone_number' => '01282236170',
            'password' => bcrypt('123123123'),
            'role' => 'normal_user',
            'shipping_address' => 'Zagazig'
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
