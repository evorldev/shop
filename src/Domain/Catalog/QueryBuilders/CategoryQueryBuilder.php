<?php

namespace Domain\Catalog\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class CategoryQueryBuilder extends Builder
{
    public function onHomepage()
    {
        return $this->select(['id', 'slug', 'title'])
            ->where('is_on_homepage', true)
            ->orderBy('order')
            ->orderBy('title')
            ->orderBy('id')
            ->limit(6);
    }
}
