<?php

namespace Domain\Product\Providers;

use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->register(
            ActionsServiceProvider::class
        );

        $this->app->register(
            EventServiceProvider::class
        );
    }
}
