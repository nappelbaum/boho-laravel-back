<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class AdminPanelController extends Controller
{
    public function index()
    {
        $category_count = Category::all()->count();
        $products_count = Product::all()->count();

        return view('admin.index', [
            'category_count' => $category_count,
            'products_count' => $products_count
        ]);
    }
}
