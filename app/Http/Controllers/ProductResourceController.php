<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use App\Models\Size;

class ProductResourceController extends Controller
{
    public function index(Request $request)
    {
        $favorite_products = array();

        if($request->query('favorites')) {
            foreach (explode(",", $request->query('favorites')) as $fav_id) {
    
                $fav_product = Product::where('id', $fav_id)->first();
                $fav_product->images;
    
                array_push($favorite_products, $fav_product);
    
            }
        }

        return $favorite_products;
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
