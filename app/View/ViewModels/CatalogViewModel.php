<?php

declare(strict_types=1);

namespace App\View\ViewModels;

use App\Http\Controllers\CatalogController;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\ViewModels\ViewModel;

class CatalogViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Category $category = null,
        public readonly string $viewType = CatalogController::DEFAULT_VIEW_TYPE
    ) {}

    public function category(): ?Category
    {
        return $this->category;
    }

    public function categories(): Collection|array
    {
        return Cache::rememberForever('categories', function() {
            return Category::query()
                ->select(['id', 'slug', 'title'])
                ->has('products')
                ->get();
        });
    }

    public function products(): LengthAwarePaginator
    {
        return (is_null($this->category) ? Product::query() : $this->category->products())
            ->select(['id', 'slug', 'title', 'price', 'image', 'json_properties'])
            ->searched()
            ->filtered()
            ->sorted()
            ->paginate(6)
            ->withQueryString();
    }

    public function viewType(): string
    {
        return $this->viewType;
    }
}
