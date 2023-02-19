<?php

namespace Database\Factories;

use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Catalog\Models\Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->company(),
            'image' => $this->faker->fixturesImage('images/brands', 'brands/fixtures'),

            'is_on_homepage' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(0, 255),
        ];
    }
}
