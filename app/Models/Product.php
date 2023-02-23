<?php

namespace App\Models;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function scopeFiltered(Builder $query)
    {
        return app(Pipeline::class)
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

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
