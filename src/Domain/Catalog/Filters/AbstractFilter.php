<?php

declare(strict_types=1);

namespace Domain\Catalog\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Stringable;

abstract class AbstractFilter implements Stringable
{
    public function __invoke(Builder $query, $next)
    {
        $this->apply($query);

        $next($query);
    }

    abstract public function title(): string;

    abstract public function key(): string;

    abstract public function apply(Builder $query): Builder;

    abstract public function values(): array;

    abstract public function view(): string;

    protected function isMultiple(): bool
    {
        return false;
    }

    public function requestValue(string $index = null, mixed $default = null): mixed
    {
        // filters.order
        // filters.price.from
        // filters.price.to
        // filters.brands[%] == $index

        $key = "filters.{$this->key()}";

        if (isset($index)) {
            if ($this->isMultiple()) {
                $values = request($key, []);

                return in_array($index, $values) ? $index : $default;
            }

            $key .= ".$index";
        }

        return request($key, $default);
    }

    public function name(string $index = null): string
    {
        // filters[order]
        // filters[price][from]
        // filters[price][to]
        // filters[brands][]

        $name = "filters[{$this->key()}]";

        if ($this->isMultiple()) {
            $name .= '[]';
        } elseif (isset($index)) {
            $name .= "[$index]";
        }

        return $name;
    }

    public function id(string $index = null): string
    {
        // filters_order
        // filters_price_from
        // filters_price_to
        // filters_brands_{$index}

        return Str::of("filters_{$this->key()}")
            ->when(isset($index), fn($str) => $str->append("_$index"))
            ->slug('_')
            ->value();
    }

    public function __toString(): string
    {
        return view($this->view(), [
            'filter' => $this,
        ])->render();
    }
}
