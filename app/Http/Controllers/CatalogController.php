<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CatalogController extends Controller
{
    public function __invoke(?Category $category)
    {
        //TODO: Cache
        $categories = Category::query()
            ->select(['id', 'slug', 'title'])
            ->has('products')
            ->get();

        $products = Product::query()
            ->select(['id', 'slug', 'title', 'price', 'image'])
            ->when(request('s'), function (Builder $query) {
                $query->whereFullText(['title', 'text'], request('s'));
            })
            ->when($category->exists, function (Builder $query) use($category) {
                $query->whereRelation(
                    'categories',
                    'categories.id',
                    '=',
                    $category->id
                );
            })
            ->filtered()
            ->sorted()
            ->paginate(6)
            ->withQueryString(); //TODO: ??? withQueryString()

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
