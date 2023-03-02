<?php

namespace Domain\Catalog\Observers;

use Domain\Catalog\Models\Brand;
use Illuminate\Support\Facades\Cache;

class BrandObserver
{
    private function clearCache()
    {
        Cache::forget('brands');
        Cache::forget('homepage.brands');
    }

    public function created(Brand $brand)
    {
        $this->clearCache();
    }

    public function updated(Brand $brand)
    {
        $this->clearCache();
    }

    public function deleted(Brand $brand)
    {
        $this->clearCache();
    }

    public function restored(Brand $brand)
    {
        $this->clearCache();
    }

    public function forceDeleted(Brand $brand)
    {
        $this->clearCache();
    }
}
