<?php

namespace Tests\Feature;

use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_success_response(): void
    {
        /*$brands = */BrandFactory::new([
            'is_on_homepage' => true,
            'order' => 100,
        ])->count(5)->create();

        $brand = BrandFactory::new([
            'is_on_homepage' => true,
            'order' => 1,
        ])->create();

        /*$categories = */CategoryFactory::new([
            'is_on_homepage' => true,
            'order' => 100,
        ])->count(5)->create();

        $category = CategoryFactory::new([
            'is_on_homepage' => true,
            'order' => 1,
        ])->create();

        /*$products = */ProductFactory::new([
            'is_on_homepage' => true,
            'order' => 100,
        ])->count(5)->create();

        $product = ProductFactory::new([
            'is_on_homepage' => true,
            'order' => 1,
        ])->create();

        $this->get('/')
            ->assertOk()
            ->assertViewHas('brands.0', $brand)
            ->assertViewHas('categories.0', $category)
            ->assertViewHas('products.0', $product);
    }
}
