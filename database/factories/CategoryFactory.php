<?php

namespace Database\Factories;

use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Catalog\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),

            'is_on_homepage' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(0, 255),
        ];
    }
}
