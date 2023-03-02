<?php

namespace Domain\Product\Providers;

use Domain\Product\Models\Product;
use Domain\Product\Observers\ProductObserver;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Product::observe(
            ProductObserver::class
        );
    }
}
