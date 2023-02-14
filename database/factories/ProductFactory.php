<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),

            'title' => $this->faker->unique()->words(2, true),
            'price' => $this->faker->numberBetween(1000, 100000),
            'thumbnail' => $this->faker->fixturesImage('images/products', 'images/products'),

            'is_on_homepage' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(0, 255),
        ];
    }
}
