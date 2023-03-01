<?php

declare(strict_types=1);

namespace Domain\Catalog\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Stringable;

abstract class AbstractFilter implements Stringable
{
    const REQUEST_KEY = 'filter';

    public function __invoke(Builder $query, $next)
    {
        $this->apply($query);

        $next($query);
    }

    abstract public function title(): string;

    abstract public function key(): string;

    abstract public function apply(Builder $query): Builder;

    abstract public function values(): array;

    public function view(): ?string
    {
        return null;
    }

    protected function isMultiple(): bool
    {
        return false;
    }

    public function requestKey(): string
    {
        return self::REQUEST_KEY;
    }

    public function requestValue(string $index = null, mixed $default = null): mixed
    {
        // filter.order
        // filter.price.from
        // filter.price.to
        // filter.brands[%] == $index

        $key = "{$this->requestKey()}.{$this->key()}";

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
        // filter[order]
        // filter[price][from]
        // filter[price][to]
        // filter[brands][]

        $name = "{$this->requestKey()}[{$this->key()}]";

        if ($this->isMultiple()) {
            $name .= '[]';
        } elseif (isset($index)) {
            $name .= "[$index]";
        }

        return $name;
    }

    public function id(string $index = null): string
    {
        // filter_order
        // filter_price_from
        // filter_price_to
        // filter_brands_{$index}

        return Str::of("{$this->requestKey()}_{$this->key()}")
            ->when(isset($index), fn($str) => $str->append("_$index"))
            ->slug('_')
            ->value();
    }

    public function __toString(): string
    {
        if (empty($this->view())) {
            return '';
        }

        return view($this->view(), [
            'filter' => $this,
        ])->render();
    }
}
