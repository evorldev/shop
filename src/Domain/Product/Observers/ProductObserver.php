<?php

namespace Domain\Product\Observers;

use Domain\Product\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    private function clearCache()
    {
        // Cache::forget('products');
        Cache::forget('homepage.products');
    }

    public function created(Product $product)
    {
        $this->clearCache();
    }

    public function updated(Product $product)
    {
        $this->clearCache();
    }

    public function deleted(Product $product)
    {
        $this->clearCache();
    }

    public function restored(Product $product)
    {
        $this->clearCache();
    }

    public function forceDeleted(Product $product)
    {
        $this->clearCache();
    }
}
