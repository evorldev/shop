<?php

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Models\Category;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class CategoryViewModel
{
    use Makeable;

    public function onHomepage()
    {
        return Cache::rememberForever('categories_homepage', function() {
            return Category::onHomepage()
                ->get();
        });
    }
}
