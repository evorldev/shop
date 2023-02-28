<?php

declare(strict_types=1);

namespace Domain\Catalog\Facades;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Builder run(Builder $query)
 * @see \Domain\Catalog\Sorters\Sorter
 */
final class Sorter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Domain\Catalog\Sorters\Sorter::class;
    }
}
