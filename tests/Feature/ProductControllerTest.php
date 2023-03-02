<?php

namespace Tests\Feature;

use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_success_response(): void
    {
        $this->get('/product')
            ->assertNotFound();

        $this->get('/product/slug')
            ->assertNotFound();

        $brand = BrandFactory::new()->create();
        $product = ProductFactory::new()->create();

        $this->get('/product/' . $product->slug)
            ->assertOk();
    }
}
