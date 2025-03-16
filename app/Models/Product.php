<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Category;
use App\Models\Image;
use App\Models\Size;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'cost',
        'description',
        'materials',
        'rating'
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(Size::class);
    }
}
