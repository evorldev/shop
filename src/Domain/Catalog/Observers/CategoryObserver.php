<?php

namespace Domain\Catalog\Observers;

use Domain\Catalog\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    public function created(Category $category)
    {
        Cache::forget('categories_homepage');
    }

    public function updated(Category $category)
    {
        Cache::forget('categories_homepage');
    }

    public function deleted(Category $category)
    {
        Cache::forget('categories_homepage');
    }

    public function restored(Category $category)
    {
        Cache::forget('categories_homepage');
    }

    public function forceDeleted(Category $category)
    {
        Cache::forget('categories_homepage');
    }
}
