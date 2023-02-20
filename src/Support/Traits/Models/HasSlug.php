<?php

namespace Support\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    const SLUG_LENGTH_LIMIT = 100; // max: 255 - tail

    protected function slugColumn(): string
    {
        return 'slug';
    }

    protected function slugFromColumn(): string
    {
        return 'title';
    }

    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->makeSlug();
        });
    }

    protected function makeSlug(): void
    {
        if (! $this->{$this->slugColumn()}) {
            $slug = $_slug = Str::limit(Str::slug($this->{$this->slugFromColumn()}), self::SLUG_LENGTH_LIMIT, '');

            $count = 0;
            while ($this->newModelQuery()->where($this->slugColumn(), 'LIKE', $slug)->exists()) {
                $slug = $_slug . '-' . ++$count;
            }

            $this->{$this->slugColumn()} = $slug;
        }
    }
}
