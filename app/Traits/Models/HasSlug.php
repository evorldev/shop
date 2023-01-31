<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        static::creating(function (Model $item) {
            if (is_null($item->slug)) {
                $item->slug = $slug = Str::limit(Str::slug($item->{self::slugFrom()}), 200, '');

                $count = 0;
                while (get_class($item)::firstWhere('slug', 'LIKE', $item->slug)) {
                    $item->slug = $slug . ++$count;
                }
            }
        });
    }

    public static function slugFrom()
    {
        return 'title';
    }
}
