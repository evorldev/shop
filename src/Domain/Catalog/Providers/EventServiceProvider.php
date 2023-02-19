<?php

namespace Domain\Catalog\Providers;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Catalog\Observers\BrandObserver;
use Domain\Catalog\Observers\CategoryObserver;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Brand::observe(BrandObserver::class);
        Category::observe(CategoryObserver::class);
    }
}
