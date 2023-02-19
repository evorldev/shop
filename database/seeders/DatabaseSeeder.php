<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        BrandFactory::new()->count(10)->create();

        $categories = CategoryFactory::new()->count(20)->create();

        Product::factory(100)->create()
            ->each(function ($product) use ($categories) {
                $product->categories()->attach($categories->random(rand(1, 3)));
            });
    }
}
