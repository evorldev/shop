<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'title',
        'is_on_homepage',
        'order',
    ];

    public function scopeOnHomepage(Builder $query)
    {
        $query->where('is_on_homepage', true)
            ->orderBy('order')
            ->orderBy('title')
            ->orderBy('id')
            ->limit(6);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
