<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_name',
        'long_name',
        'slug',
        'description',
        'order_by',
        'order_method'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
