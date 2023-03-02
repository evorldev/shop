<?php

namespace Domain\Catalog\Observers;

use Domain\Catalog\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    private function clearCache()
    {
        Cache::forget('categories');
        Cache::forget('homepage.categories');
    }

    public function created(Category $category)
    {
        $this->clearCache();
    }

    public function updated(Category $category)
    {
        $this->clearCache();
    }

    public function deleted(Category $category)
    {
        $this->clearCache();
    }

    public function restored(Category $category)
    {
        $this->clearCache();
    }

    public function forceDeleted(Category $category)
    {
        $this->clearCache();
    }
}
