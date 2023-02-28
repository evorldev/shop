<?php

namespace App\Models;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pipeline\Pipeline;
use Support\Casts\PriceCast;
use Support\Traits\Models\HasImage;
use Support\Traits\Models\HasSlug;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasImage;

    protected $fillable = [
        'brand_id',
        'title',
        'price',
        'image',
        'is_on_homepage',
        'order',
        'text',
    ];

    protected $casts = [
        'price' => PriceCast::class,
    ];

    public function scopeSearched(Builder $query)
    {
        $query->when(request('s'), function (Builder $q) {
            $q->whereFullText(['title', 'text'], request('s'));
        });
    }

    public function scopeFiltered(Builder $query)
    {
        app(Pipeline::class)
            ->send($query)
            ->through(filters())
            ->thenReturn();
    }

    public function scopeSorted(Builder $query)
    {
        $query->when(request('sort'), function (Builder $q) {
            $column = request()->str('sort');

            if ($column->contains(['price', 'title'])) {
                $direction = $column->contains('-') ? 'DESC' : 'ASC';

                $q->orderBy($column->remove('-')->toString(), $direction);
            }
        });
    }

    public function scopeOnHomepage(Builder $query)
    {
        $query->where('is_on_homepage', true)
            ->orderBy('order')
            ->orderBy('title')
            ->orderBy('id')
            ->limit(6);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)
            ->withPivot('value');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }
}
