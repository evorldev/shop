<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Category;
use Illuminate\Support\Facades\Cache;

class CatalogController extends Controller
{
    public function __invoke(?Category $category = null)
    {
        $categories = Cache::rememberForever('categories', function() {
            return Category::query()
                ->select(['id', 'slug', 'title'])
                ->has('products')
                ->get();
        });

        $products = (is_null($category) ? Product::query() : $category->products())
            ->select(['id', 'slug', 'title', 'price', 'image'])
            ->searched()
            ->filtered()
            ->sorted()
            ->paginate(6)
            ->withQueryString();

        // $brands = BrandViewModel::make()
        //     ->onHomepage();

        // $categories = CategoryViewModel::make()
        //     ->onHomepage();

        // $products = Product::onHomepage()
        //     ->get();

        return view('catalog.index', compact(
            'categories',
            'products',
            'category',
        ));
    }
}
