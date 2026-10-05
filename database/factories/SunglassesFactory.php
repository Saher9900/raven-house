<?php

namespace Database\Factories;

use App\Models\Sunglasses;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sunglasses>
 */
class SunglassesFactory extends Factory
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
            'sunglasses_category_id' => $this->faker->numberBetween(1, 7),
            'name' => $this->faker->word() . ' ' . $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 100, 350),
            'brand' => $this->faker->randomElement(['Ray-Ban', 'Gucci', 'Prada', 'Tom Ford', 'Burberry', 'Versace']),
            'description' => $this->faker->sentence(),
            'sale' => $salePrice,
            'stock' => $this->faker->numberBetween(0, 100),
            'gender' => $this->faker->randomElement(['male', 'female']),
        ];
    }
}
