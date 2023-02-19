<?php

namespace Domain\Catalog\Observers;

use Domain\Catalog\Models\Brand;
use Illuminate\Support\Facades\Cache;

class BrandObserver
{
    public function created(Brand $brand)
    {
        Cache::forget('brands_homepage');
    }

    public function updated(Brand $brand)
    {
        Cache::forget('brands_homepage');
    }

    public function deleted(Brand $brand)
    {
        Cache::forget('brands_homepage');
    }

    public function restored(Brand $brand)
    {
        Cache::forget('brands_homepage');
    }

    public function forceDeleted(Brand $brand)
    {
        Cache::forget('brands_homepage');
    }
}
