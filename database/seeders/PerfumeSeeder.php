<?php

namespace Database\Seeders;

use App\Models\Perfume;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerfumeSeeder extends Seeder
{
    public function run(): void
    {
        Perfume::factory(30)->create()->each(function (Perfume $perfume) {
            Image::factory(3)->create([
                'imageable_type' => Perfume::class,
                'imageable_id' => $perfume->id,
            ]);
        });
    }
}
