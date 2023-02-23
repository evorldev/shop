<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Domain\Catalog\Collections\CategoryCollection;
use Domain\Catalog\QueryBuilders\CategoryQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Models\HasSlug;

class Category extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'title',
        'is_on_homepage',
        'order',
    ];

    public function newCollection(array $models = []): CategoryCollection
    {
        return new CategoryCollection($models);
    }

    public function newEloquentBuilder($query): CategoryQueryBuilder
    {
        return new CategoryQueryBuilder($query);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
