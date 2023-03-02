<?php

namespace Domain\Product\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class ProductQueryBuilder extends Builder
{
    public function onHomepage(): ProductQueryBuilder
    {
        return $this//->select(['id', 'slug', 'title', 'image']) //TODO:
            ->where('is_on_homepage', true)
            ->orderBy('order')
            ->orderBy('title')
            ->orderBy('id')
            ->limit(6);
    }

    public function searched(): ProductQueryBuilder
    {
        return $this->when(request('s'), function (Builder $q) {
            $q->whereFullText(['title', 'text'], request('s'));
        });
    }

    public function filtered(): ProductQueryBuilder
    {
        return app(Pipeline::class)
            ->send($this)
            ->through(filters())
            ->thenReturn();
    }

    public function sorted(): ProductQueryBuilder
    {
        return sorting()->apply($this);
    }

}
