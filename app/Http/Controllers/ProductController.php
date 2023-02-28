<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function __invoke(Product $product = null)
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



        $product->load(['optionValues.option']);
        $options = $product->optionValues->mapToGroups(function ($item) {
            return [$item->option->title => $item];
        });

        return view('product.show', compact(
            'product',
            'options',
            'also',
        ));
    }
}
