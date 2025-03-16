<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'main_path',
        'copy_main',
        'copy_2400',
        'copy_1600',
        'copy_1200',
        'copy_800',
        'copy_400'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
