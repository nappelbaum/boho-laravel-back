<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use App\Models\Size;

class ProductResourceController extends Controller
{
    public function index()
    {
        $products = Product::all();

        foreach ($products as $product) {
            $product->categories;
            $product->images;
            $product->sizes;
        }

        return $products;
    }

    public function index_single(Request $request)
    {
        $product = Product::where('slug', $request->query('slug'))->first();
        $product->categories;
        $product->images;
        $product->sizes;

        return $product;
    }
}
