<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageMain extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_name',
        'slogan',
        'main_path',
        'copy_main',
        'copy_2400',
        'copy_1600',
        'copy_1200',
        'copy_800'
    ];
}
