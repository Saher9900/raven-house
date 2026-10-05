<?php

namespace Database\Factories;

use App\Models\PerfumesCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PerfumesCategory>
 */
class PerfumesCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Floral', 'Oriental', 'Fresh', 'Citrus', 'Fruity', 'Woody', 'Spicy']),
            'image' => '/storage/images/default-category.png',
        ];
    }
}
