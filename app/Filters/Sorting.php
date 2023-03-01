<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

final class Sorting
{
    const REQUEST_KEY = 'sort';

    public function apply(Builder $query): Builder
    {
        return $query->when(
            $this->requestValue() && array_key_exists($this->requestValue(), $this->values()),
            function (Builder $q) {
                $column = trim($this->requestValue(), '-');
                $direction = $this->requestValue()[0] == '-' ? 'DESC' : 'ASC';

                $q->orderBy($column, $direction);
            }
        );
    }

    public function values(): array
    {
        return [
            '' => 'по умолчанию',
            'price' => 'от дешевых к дорогим',
            '-price' => 'от дорогих к дешевым',
            'title' => 'по наименованию',
        ];
    }

    public function requestKey(): string
    {
        return self::REQUEST_KEY;
    }

    public function requestValue(mixed $default = null): mixed
    {
        return request($this->requestKey(), $default);
    }
}
