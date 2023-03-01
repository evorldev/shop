<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CatalogController extends Controller
{
    const VIEW_REQUEST_KEY = 'view';
    const VIEW_SESSION_KEY = 'view';

    const AVAILABLE_VIEW_TYPES = [
        'grid',
        'list',
    ];
    const DEFAULT_VIEW_TYPE = 'grid';

    public function __invoke(Request $request, ?Category $category = null)
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

        $viewType = $this->getViewType($request);

        return view('catalog.index', compact(
            'categories',
            'products',
            'category',
            'viewType',
        ));
    }

    private function getViewType(Request $request): string
    {
        $type = $request->get(self::VIEW_REQUEST_KEY);
        if (in_array($type, self::AVAILABLE_VIEW_TYPES)) {
            $request->session()->put(self::VIEW_SESSION_KEY, $type);

            return $type;
        }

        $type = $request->session()->get(self::VIEW_SESSION_KEY);
        if (in_array($type, self::AVAILABLE_VIEW_TYPES)) {
            return $type;
        }

        return self::DEFAULT_VIEW_TYPE;
    }
}
