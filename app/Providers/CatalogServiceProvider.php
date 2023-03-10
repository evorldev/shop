<?php

namespace App\Providers;

use App\Filters\BrandsFilter;
use App\Filters\PriceFilter;
use App\Filters\Sorting;
use Domain\Catalog\Filters\FilterManager;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FilterManager::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        app(FilterManager::class)->registerFilters([
            new PriceFilter(),
            new BrandsFilter(),
        ]);

        $this->app->bind(Sorting::class, function () {
            return new Sorting();
        });
    }
}
