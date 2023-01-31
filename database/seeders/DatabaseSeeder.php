<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Brand::factory(10)->create();

        $categories = Category::factory(20)->create();

        Product::factory(100)->create()
            ->each(function ($product) use ($categories) {
                $product->categories()->attach($categories->random(rand(1, 3)));
            });
    }
}
