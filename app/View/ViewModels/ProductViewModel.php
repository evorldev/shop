<?php

namespace App\View\ViewModels;

use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Spatie\ViewModels\ViewModel;

class ProductViewModel extends ViewModel
{
    public function __construct(
        public readonly Product $product,
        public readonly ?Collection $also = null
    )
    {
        $this->product->load(['optionValues.option']);
    }

    public function product()
    {
        return $this->product;
    }

    public function options()
    {
        return $this->product->optionValues->keyValues();
    }

    public function also()
    {
        return $this->also;
    }
}
