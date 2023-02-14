<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function __invoke()
    {
        $brands = Brand::OnHomepage()->get();
        $categories = Category::OnHomepage()->get();
        $products = Product::OnHomepage()->get();

        return view('index', compact(
            'brands',
            'categories',
            'products',
        ));
    }
}
