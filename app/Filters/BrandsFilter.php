<?php

declare(strict_types=1);

namespace App\Filters;

use Domain\Catalog\Filters\AbstractFilter;
use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

final class BrandsFilter extends AbstractFilter
{
	public function title(): string
    {
        return 'Бренды';
	}

	public function key(): string
    {
        return 'brands';
	}

	public function apply(Builder $query): Builder
    {
        return $query->when($this->requestValue(), function (Builder $q) {
            $q->whereIn('brand_id', $this->requestValue());
        });
	}

	public function values(): array
    {
        return
            Cache::rememberForever('brands', function() {
                return Brand::query()
                    ->select(['id', 'title'])
                    ->has('products')
                    ->get();
            })
            ->pluck('title', 'id')
            ->toArray();
	}

	public function view(): ?string
    {
        return 'catalog.filters.brands';
	}

    protected function isMultiple(): bool
    {
        return true;
    }
}
