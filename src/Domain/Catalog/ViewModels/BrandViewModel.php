<?php

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Models\Brand;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class BrandViewModel
{
    use Makeable;

    public function onHomepage()
    {
        return Cache::rememberForever('brands_homepage', function() {
            return Brand::onHomepage()
                ->get();
        });
    }
}
