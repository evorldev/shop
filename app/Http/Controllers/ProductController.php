<?php

namespace App\Http\Controllers;

use App\View\ViewModels\ProductViewModel;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductController extends Controller
{
    public function __invoke(Product $product)
    {
        $also = $this->getAlso($product);

        return (new ProductViewModel($product, $also))
            ->view('product.show');
    }

    private function getAlso(Product $product): ?Collection
    {
        $also = null;
        try {
            // session()->forget('also');
            $_also = session('also', []);
            $_also = array_diff($_also, [$product->id]);

            $also = Product::query()
                ->whereIn('id', $_also)
                // ->where('id', '!=', $product->id)
                ->limit(4)
                ->get()
                ->sortBy(function($item) use ($_also){
                    return array_search($item->getKey(), $_also);
                });

            array_unshift($_also, $product->id);
            $_also = array_slice($_also, 0, 5);
            session()->put('also', $_also);
        } catch (\Throwable $th) {
            //throw $th;
        }

        return $also;
    }
}
