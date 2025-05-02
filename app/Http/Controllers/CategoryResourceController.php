<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;

class CategoryResourceController extends Controller
{
    public function index()
    {
        $sort = Order::find(1);

        $categories = Category::orderBy($sort->by, $sort->method)->get();

        foreach ($categories as $category) {
            $products = $category->products()->orderBy($category->order_by, $category->order_method)->get();

            foreach ($products as $product) {
                $product->images;
                $product->sizes;
            }

            $category->products = $products;
        }

        // $query->orderBy('published_at', 'desc'); //просто пример

        return $categories;
    }

    public function index_single(Request $request)
    {
        $category = Category::where('slug', $request->query('slug'))->first();

        $products = $category->products()->orderBy($category->order_by, $category->order_method)->get();

        foreach ($products as $product) {
            $product->images;
            $product->sizes;
        }

        $category->products = $products;
        
        return $category;
    }

    public function index_simple()
    {
        $sort = Order::find(1);

        $categories = Category::orderBy($sort->by, $sort->method)->get();

        return $categories;
    }
}
