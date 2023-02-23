<?php

namespace Tests\Feature;

use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_generated_success(): void
    {
        $size = '500x500';
        $method = 'resize';
        $storage = Storage::disk('images');

        config()->set('thumbnails', ['sizes' => [$size]]);

        $brand = BrandFactory::new()->create();

        $response = $this->get(thumbnail($brand->imagePath(), $size, $method));

        $response->assertOk();

        $storage->assertExists(".thumbnails/$size/$method/" . $brand->imagePath());
    }
}
