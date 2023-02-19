<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;

class HomeController extends Controller
{
    public function __invoke()
    {
        $brands = BrandViewModel::make()
            ->onHomepage();

        $categories = CategoryViewModel::make()
            ->onHomepage();

        $products = Product::onHomepage()
            ->get();

        return view('index', compact(
            'brands',
            'categories',
            'products',
        ));
    }
}
