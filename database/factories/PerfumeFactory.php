<?php

namespace Database\Factories;

use App\Models\Perfume;
use App\Models\PerfumesCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Perfume>
 */
class PerfumeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $salePrice = fake()->boolean(30) ? $this->faker->randomFloat(2, 50, 150) : null;
        
        return [
            'perfumes_category_id' => PerfumesCategory::factory(),
            'name' => $this->faker->word() . ' ' . $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 80, 250),
            'brand' => $this->faker->randomElement(['Dior', 'Chanel', 'Guerlain', 'Dolce & Gabbana', 'Tom Ford', 'Hermès']),
            'description' => $this->faker->sentence(),
            'sale' => $salePrice,
            'stock' => $this->faker->numberBetween(0, 100),
            'gender' => $this->faker->randomElement(['male', 'female']),
        ];
    }
}
