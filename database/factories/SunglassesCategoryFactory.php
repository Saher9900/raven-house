<?php

namespace Database\Factories;

use App\Models\SunglassesCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SunglassesCategory>
 */
class SunglassesCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Aviator', 'Wayfarer', 'Cat Eye', 'Round', 'Square', 'Oversized', 'Sporty']),
            'image' => '/storage/images/default-category.png',
        ];
    }
}
