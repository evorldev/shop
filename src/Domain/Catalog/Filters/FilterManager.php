<?php

declare(strict_types=1);

namespace Domain\Catalog\Filters;

final class FilterManager
{
    public function __construct(
        protected array $filters = []
    ) {}

    public function registerFilters(array $filters): void
    {
        $this->filters = $filters;
    }

    public function filters(): array
    {
        return $this->filters;
    }

    public function isActive(): bool
    {
        foreach ($this->filters as $filter) {
            if ($filter->requestValue()) {
                return true;
            }
        }

        return false;
    }
}
