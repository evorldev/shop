<?php

namespace Database\Factories;

use Domain\Catalog\Models\Brand;
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
            'price' => $this->faker->numberBetween(100000, 10000000),
            'image' => $this->faker->fixturesImage('images/products', 'products/fixtures'),

            'is_on_homepage' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(0, 255),
            'text' => $this->faker->realText(),
        ];
    }
}
