<?php

namespace Support\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    protected function getSlugColumnName(): string
    {
        return 'slug';
    }

    protected function getSlugFromColumnName(): string
    {
        return 'title';
    }

    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $item) {
            $item->makeSlug();
        });
    }

    protected function makeSlug(): void
    {
        if (! $this->{$this->getSlugColumnName()}) {
            $slug = $_slug = Str::limit(Str::slug($this->{$this->getSlugFromColumnName()}), 100, '');

            $count = 0;
            while ($this->newModelQuery()->where($this->getSlugColumnName(), 'LIKE', $slug)->exists()) {
                $slug = $_slug . '-' . ++$count;
            }

            $this->{$this->getSlugColumnName()} = $slug;
        }
    }
}
