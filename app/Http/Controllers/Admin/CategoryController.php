<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Order;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = Order::find(1);

        if($request['method']) {
            $sort->method = $request['method'];
            $sort->save();
        }

        $categories = Category::orderBy('created_at', $sort->method)->get();

        return view('admin.category.index', [
            'categories' => $categories,
            'method' => $sort->method
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'long_name' => 'required|unique:categories|max:255',
        ]);

        $new_category = new Category();
        $new_category->long_name = $validated['long_name'];
        $new_category->short_name = Str::slug($validated['long_name']);
        $new_category->slug = Str::slug($validated['long_name']);
        $new_category->description = $request->description;
        $new_category->order_by = 'created_at';
        $new_category->order_method = 'asc';
        $new_category->save();

        return redirect()->back()->withSuccess('Категория была успешно добавлена');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if($request->created_at) {
            $validated = $request->validate([
                'created_at' => 'nullable|date_format:Y-m-d\\TH:i:s|after:1990-01-01T01:01:01|before:2037-12-31T23:59:59',
            ]);
    
            $category->created_at = $validated['created_at'];
            $category->save();
    
            return redirect()->back()->withSuccess('Категория была успешно обновлена');
        } else {
            $repeat = Category::where('long_name', $request['long_name'])->first();
    
            if ($repeat && $category->id != $repeat->id) {
                return redirect()->back()->withError('Категория с названием "' . $repeat->long_name . '" уже есть');
            }
    
            $validated = $request->validate([
                'long_name' => 'required|max:255',
            ]);
            
            $category->long_name = $validated['long_name'];
            $category->short_name = Str::slug($validated['long_name']);
            $category->slug = Str::slug($validated['long_name']);
            $category->description = $request->description;
            $category->save();
    
            return redirect()->back()->withSuccess('Категория была успешно обновлена');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()->withSuccess('Категория была успешно удалена');
    }
}
