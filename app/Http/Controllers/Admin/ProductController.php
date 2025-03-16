<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Order;

use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortCats = Order::find(1);

        $categories = Category::orderBy($sortCats->by, $sortCats->method)->get();

        $products = [];
        $method = '';
        $filter = [];
        
        if($request['filter']) {
            $category = Category::find($request['filter']);
            
            if($category) {
                if($request['method']) {
                    $category->order_method = $request['method'];
                    $category->save();
                }

                $products = $category->products()->orderBy($category->order_by, $category->order_method)->get();
                $method = $category->order_method;
                $filter['long_name'] = $category->long_name;
                $filter['id'] = $category->id;
            }
        } else {
            $sort = Order::find(2);
    
            if($request['method']) {
                $sort->method = $request['method'];
                $sort->save();
            }

            $products = Product::orderBy($sort->by, $sort->method)->get();
            $method = $sort->method;
        }

        foreach ($products as $product) {
            $product->categories = $product->categories()->orderBy($sortCats->by, $sortCats->method)->get();
        }

        return view('admin.product.index', [
            'products' => $products,
            'categories' => $categories,
            'method' => $method,
            'filter' => $filter
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sort = Order::find(1);

        $categories = Category::orderBy($sort->by, $sort->method)->get();

        return view('admin.product.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:products|max:255',
        ]);

        $new_product = new Product();
        $new_product->name = $validated['name'];
        $new_product->slug = Str::slug($validated['name']);
        $new_product->description = $request->description;
        $new_product->materials = $request->materials;
        $new_product->save();

        if($request->category_id) {
            $new_product->categories()->sync(explode(",", $request->category_id));
        }

        if($request->image_path) {
            // create image manager with desired driver
            $manager = new ImageManager(new Driver());
            
            foreach (explode("#%?&", $request->image_path) as $path) {
                $forImagesTable = array("main_path"=>$path); //объявляю массив для последующей загрзки данных в таблицу images

                $image = $manager->read($path); //получаю исходную загруженную из админки картинку
                $height = $image->height(); // узнаю высоту картинки
                $width = $image->width(); // узнаю ширину картинки

                // разбираю путь до картинки, удаляю первый элемент (папку 'storage'), новый путь начинается с папки copies:
                $explode_path = explode("\\", $path);
                unset($explode_path[0]);
                $current_path = 'copies';

                // создаю директорию (имя директории = имя загруженного файла картинки) в папке 'copies', плюс вложенные папки:
                foreach ($explode_path as $part) {
                    $new_current_path = $current_path . '/' . $part;
        
                    if(!is_dir($new_current_path)) {
                        File::makeDirectory($new_current_path, 0777, true);
                    }
        
                    $current_path = $new_current_path;
                }
                
                // разбираю путь до только что созданной директории для копирования:
                $explode_current_path = explode('/', $current_path);
                $explode_current_path_file = explode('.', $explode_current_path[array_key_last($explode_current_path)]);
                $name = $explode_current_path_file[0];
                if(!$name) {
                    $name = 'copy_file';
                }
                $ext = $explode_current_path_file[array_key_last($explode_current_path_file)];

                // сохраняю файл в папке copies с оптимизированным размером файла, записываю путь в массив для добавления в таблицу:
                $image->save($current_path . '/' . $name . '.' . $ext, quality: 65);
                $forImagesTable['copy_main'] = $current_path . '/' . $name . '.' . $ext;
                    
                if($height > 400 && $width > 400) {
                    // проверяю и меняю размеры исходной картинки и делаю копии с разрешениями 2400,1600,1200,800,400px:
                    if($height > $width) {
                        if($width > 2400) {
                            $image->scale(width: 2400);
                            $image->toWebp()->save($current_path . '/' . $name . '__2400px.' . 'webp');
                            $forImagesTable['copy_2400'] = $current_path . '/' . $name . '__2400px.' . 'webp';
                        }
                        if($width > 1600) {
                            $image->scale(width: 1600);
                            $image->toWebp()->save($current_path . '/' . $name . '__1600px.' . 'webp');
                            $forImagesTable['copy_1600'] = $current_path . '/' . $name . '__1600px.' . 'webp';
                        }
                        if($width > 1200) {
                            $image->scale(width: 1200);
                            $image->toWebp()->save($current_path . '/' . $name . '__1200px.' . 'webp');
                            $forImagesTable['copy_1200'] = $current_path . '/' . $name . '__1200px.' . 'webp';
                        }
                        if($width > 800) {
                            $image->scale(width: 800);
                            $image->toWebp()->save($current_path . '/' . $name . '__800px.' . 'webp');
                            $forImagesTable['copy_800'] = $current_path . '/' . $name . '__800px.' . 'webp';
                        }
                        $image->scale(width: 400);
                        $image->toWebp()->save($current_path . '/' . $name . '__400px.' . 'webp');
                        $forImagesTable['copy_400'] = $current_path . '/' . $name . '__400px.' . 'webp';
                    } else {
                        if($height > 2400) {
                            $image->scale(height: 2400);
                            $image->toWebp()->save($current_path . '/' . $name . '__2400px.' . 'webp');
                            $forImagesTable['copy_2400'] = $current_path . '/' . $name . '__2400px.' . 'webp';
                        }
                        if($height > 1600) {
                            $image->scale(height: 1600);
                            $image->toWebp()->save($current_path . '/' . $name . '__1600px.' . 'webp');
                            $forImagesTable['copy_1600'] = $current_path . '/' . $name . '__1600px.' . 'webp';
                        }
                        if($height > 1200) {
                            $image->scale(height: 1200);
                            $image->toWebp()->save($current_path . '/' . $name . '__1200px.' . 'webp');
                            $forImagesTable['copy_1200'] = $current_path . '/' . $name . '__1200px.' . 'webp';
                        }
                        if($height > 800) {
                            $image->scale(height: 800);
                            $image->toWebp()->save($current_path . '/' . $name . '__800px.' . 'webp');
                            $forImagesTable['copy_800'] = $current_path . '/' . $name . '__800px.' . 'webp';
                        }
                        $image->scale(height: 400);
                        $image->toWebp()->save($current_path . '/' . $name . '__400px.' . 'webp');
                        $forImagesTable['copy_400'] = $current_path . '/' . $name . '__400px.' . 'webp';
                    }    
                }

                $new_product->images()->create($forImagesTable);
            }
        }

        if($request->sizes) {
            $sizesArr = json_decode($request->sizes);
            foreach ($sizesArr as $pair) {
                $new_product->sizes()->create([
                    'proportion' => $pair->size,
                    'cost' => $pair->cost,
                ]);
            }
        }

        return redirect()->back()->withSuccess('Продукт ' . $new_product->name . ' был успешно добавлен');
    }

    /**
     * Display the specified resource. 
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $sort = Order::find(1);

        $categories = Category::orderBy($sort->by, $sort->method)->get();

        $product->categories = $product->categories()->get();
        $product->images = $product->images()->get();
        $product->sizes = $product->sizes()->get();

        return view('admin.product.edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, Product $product)
    {
        if($request->created_at) {
            $validated = $request->validate([
                'created_at' => 'nullable|date_format:Y-m-d\\TH:i:s|after:1990-01-01T01:01:01|before:2037-12-31T23:59:59',
            ]);
    
            $product->created_at = $validated['created_at'];
            $product->save();
    
            return redirect()->back()->withSuccess('Продукт был успешно обновлен');
        } else {
            $repeat = Product::where('name', $request['name'])->first();

            if ($repeat && $product->id != $repeat->id) {
                return redirect()->back()->withError('Продукт с названием "' . $repeat->name . '" уже есть');
            }

            $validated = $request->validate([
                'name' => 'required|max:255',
            ]);

            $product->name = $validated['name'];
            $product->slug = Str::slug($validated['name']);
            $product->description = $request->description;
            $product->materials = $request->materials;
            $product->save();

            if($request->category_id) {
                $product->categories()->sync(explode(",", $request->category_id));
            }

            if($request->image_path) {
                // create image manager with desired driver
                $manager = new ImageManager(new Driver());

                // прохожу по массиву путей картинок из базы данных для проверки папок картинок на предмет удаления:
                foreach ($product->images as $image) {
                    $is_dir_del = true; // нужно ли удалять папку
                    $exist_image = $manager->read($image['copy_main']);

                    foreach (explode("#%?&", $request->image_path) as $path) {
                        $add_image = $manager->read($path);

                        // проверяю, нужно ли удалять папку с картинками (сравниваю осн. копию картинки из БД с картинкой из запроса из админки):
                        if($image['main_path'] == $path
                            && $exist_image->width() == $add_image->width()
                            && $exist_image->height() == $add_image->height()
                        ) $is_dir_del = false; // если есть совпадение, папку не удаляю
                    }

                    
                    if($is_dir_del) {
                        $explode_image_path = explode("\\", $image['main_path']);
                        $explode_image_path[0] = 'copies';

                        $img_repeat = Image::where('main_path', $image['main_path'])->get();

                        if(count($img_repeat) < 2) {
                            File::deleteDirectory(implode('/', $explode_image_path));
                        };
                    }
                }

                $product->images()->delete(); // удаляю все связанные с продуктом пути картинок из БД

                foreach (explode("#%?&", $request->image_path) as $path) {
                    $forImagesTable = array("main_path"=>$path); //объявляю массив для последующей загрузки данных в таблицу images
    
                    // разбираю путь до картинки, удаляю первый элемент (папку 'storage'), новый путь начинается с папки copies:
                    $explode_path = explode("\\", $path);
                    unset($explode_path[0]);
                    $current_path = 'copies';

                    $is_dir = true; // существует ли директория с картинками (если да, не нужно создавать её и файлы заново)
    
                    // создаю директорию (имя директории = имя загруженного файла картинки) в папке 'copies', плюс вложенные папки:
                    foreach ($explode_path as $part) {
                        $new_current_path = $current_path . '/' . $part;
            
                        if(!is_dir($new_current_path)) {
                            File::makeDirectory($new_current_path, 0777, true);
                            $is_dir = false; // директории не существовало, поэтому нужно будет создавать все файлы в ней
                        }
            
                        $current_path = $new_current_path;
                    }
                    
                    // разбираю путь до только что созданной (или уже имеющейся) директории:
                    $explode_current_path = explode('/', $current_path);
                    $explode_current_path_file = explode('.', $explode_current_path[array_key_last($explode_current_path)]);
                    $name = $explode_current_path_file[0];
                    if(!$name) {
                        $name = 'copy_file';
                    }
                    $ext = $explode_current_path_file[array_key_last($explode_current_path_file)];
    
                    $image = $manager->read($path); //получаю исходную загруженную из админки картинку
                    $height = $image->height(); // узнаю высоту картинки
                    $width = $image->width(); // узнаю ширину картинки

                    // сохраняю файл в папке copies с оптимизированным размером файла, записываю путь в массив для добавления в таблицу:
                    if(!$is_dir) $image->save($current_path . '/' . $name . '.' . $ext, quality: 65);
                    $forImagesTable['copy_main'] = $current_path . '/' . $name . '.' . $ext;
                        
                    if($height > 400 && $width > 400) {
                        // проверяю и меняю размеры исходной картинки и делаю копии с разрешениями 2400,1600,1200,800,400px:
                        if($height > $width) {
                            if($width > 2400) {
                                if(!$is_dir) {
                                    $image->scale(width: 2400);
                                    $image->toWebp()->save($current_path . '/' . $name . '__2400px.' . 'webp');
                                }
                                $forImagesTable['copy_2400'] = $current_path . '/' . $name . '__2400px.' . 'webp';
                            }
                            if($width > 1600) {
                                if(!$is_dir) {
                                    $image->scale(width: 1600);
                                    $image->toWebp()->save($current_path . '/' . $name . '__1600px.' . 'webp');
                                }
                                $forImagesTable['copy_1600'] = $current_path . '/' . $name . '__1600px.' . 'webp';
                            }
                            if($width > 1200) {
                                if(!$is_dir) {
                                    $image->scale(width: 1200);
                                    $image->toWebp()->save($current_path . '/' . $name . '__1200px.' . 'webp');
                                }
                                $forImagesTable['copy_1200'] = $current_path . '/' . $name . '__1200px.' . 'webp';
                            }
                            if($width > 800) {
                                if(!$is_dir) {
                                    $image->scale(width: 800);
                                    $image->toWebp()->save($current_path . '/' . $name . '__800px.' . 'webp');
                                }
                                $forImagesTable['copy_800'] = $current_path . '/' . $name . '__800px.' . 'webp';
                            }
                            if(!$is_dir) {
                                $image->scale(width: 400);
                                $image->toWebp()->save($current_path . '/' . $name . '__400px.' . 'webp');
                            }
                            $forImagesTable['copy_400'] = $current_path . '/' . $name . '__400px.' . 'webp';
                        } else {
                            if($height > 2400) {
                                if(!$is_dir) {
                                    $image->scale(height: 2400);
                                    $image->toWebp()->save($current_path . '/' . $name . '__2400px.' . 'webp');
                                }
                                $forImagesTable['copy_2400'] = $current_path . '/' . $name . '__2400px.' . 'webp';
                            }
                            if($height > 1600) {
                                if(!$is_dir) {
                                    $image->scale(height: 1600);
                                    $image->toWebp()->save($current_path . '/' . $name . '__1600px.' . 'webp');
                                }
                                $forImagesTable['copy_1600'] = $current_path . '/' . $name . '__1600px.' . 'webp';
                            }
                            if($height > 1200) {
                                if(!$is_dir) {
                                    $image->scale(height: 1200);
                                    $image->toWebp()->save($current_path . '/' . $name . '__1200px.' . 'webp');
                                }
                                $forImagesTable['copy_1200'] = $current_path . '/' . $name . '__1200px.' . 'webp';
                            }
                            if($height > 800) {
                                if(!$is_dir) {
                                    $image->scale(height: 800);
                                    $image->toWebp()->save($current_path . '/' . $name . '__800px.' . 'webp');
                                }
                                $forImagesTable['copy_800'] = $current_path . '/' . $name . '__800px.' . 'webp';
                            }
                            if(!$is_dir) {
                                $image->scale(height: 400);
                                $image->toWebp()->save($current_path . '/' . $name . '__400px.' . 'webp');
                            }
                            $forImagesTable['copy_400'] = $current_path . '/' . $name . '__400px.' . 'webp';
                        }    
                    }
    
                    $product->images()->create($forImagesTable);
                }
                
                // foreach (explode("#%?&", $request->image_path) as $path) {
                //     $image = $manager->read($path); //получаю исходную загруженную из админки картинку
                //     // dump($image->exif('EXIF.DateTimeOriginal'));
                // }
            }

            if($request->is_change == "on") {
                $product->sizes()->delete();

                if($request->sizes) {
                    $sizesArr = json_decode($request->sizes);
                    foreach ($sizesArr as $pair) {
                        $product->sizes()->create([
                            'proportion' => $pair->size,
                            'cost' => $pair->cost,
                        ]);
                    }
                }
            }

            return redirect()->back()->withSuccess('Продукт был успешно обновлен');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()->withSuccess('Продукт был успешно удален');
    }
}
