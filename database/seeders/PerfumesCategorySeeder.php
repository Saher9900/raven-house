<?php

namespace Database\Seeders;

use App\Models\PerfumesCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerfumesCategorySeeder extends Seeder
{
    public function run(): void
    {
        PerfumesCategory::factory(7)->create();
    }
}
