<?php

namespace Domain\Catalog\Models;

use Domain\Catalog\Collections\BrandCollection;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Models\HasImage;
use Support\Traits\Models\HasSlug;

class Brand extends Model
{
    use HasFactory;
    use HasSlug;
    use HasImage;

    protected $fillable = [
        'title',
        'image',
        'is_on_homepage',
        'order',
    ];

    public function newCollection(array $models = []): BrandCollection
    {
        return new BrandCollection($models);
    }

    public function newEloquentBuilder($query): BrandQueryBuilder
    {
        return new BrandQueryBuilder($query);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
