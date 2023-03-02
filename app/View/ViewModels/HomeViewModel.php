<?php

namespace App\View\ViewModels;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Support\Facades\Cache;
use Spatie\ViewModels\ViewModel;

class HomeViewModel extends ViewModel
{
    public function __construct() {}

    public function brands()
    {
        return Cache::rememberForever('homepage.brands', function() {
            return Brand::onHomepage()
                ->get();
        });
    }

    public function categories()
    {
        return Cache::rememberForever('homepage.categories', function() {
            return Category::onHomepage()
                ->get();
        });
    }

    public function products()
    {
        return Cache::rememberForever('homepage.products', function() {
            return Product::onHomepage()
                ->get();
        });
    }
}
