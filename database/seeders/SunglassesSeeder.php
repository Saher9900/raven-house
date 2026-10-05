<?php

namespace Database\Seeders;

use App\Models\Sunglasses;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SunglassesSeeder extends Seeder
{
    public function run(): void
    {
        Sunglasses::factory(30)->create()->each(function (Sunglasses $sunglasses) {
            Image::factory(3)->create([
                'imageable_type' => Sunglasses::class,
                'imageable_id' => $sunglasses->id,
            ]);
        });
    }
}
