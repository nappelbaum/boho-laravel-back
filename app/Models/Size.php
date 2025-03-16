<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Size extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'proportion',
        'cost'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
