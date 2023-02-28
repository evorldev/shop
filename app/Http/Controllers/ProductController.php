<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function __invoke(Product $product = null)
    {
        $product->load(['optionValues.option']);
        $options = $product->optionValues->mapToGroups(function ($item) {
            return [$item->option->title => $item];
        });

        return view('product.show', compact(
            'product',
            'options',
        ));
    }
}
