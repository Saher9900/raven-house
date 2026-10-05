<?php

namespace Database\Seeders;

use App\Models\SunglassesCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SunglassesCategorySeeder extends Seeder
{
    public function run(): void
    {
        SunglassesCategory::factory(7)->create();
    }
}
