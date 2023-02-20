<?php

namespace App\Models;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    ];

    protected $casts = [
        'price' => PriceCast::class,
    ];

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
