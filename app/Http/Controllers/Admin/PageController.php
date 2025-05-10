<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PageMain;

use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PageController extends Controller
{
    public function main_edit()
    {
        $info = PageMain::find(1);

        return view('admin.page.main', [
            'info' => $info
        ]);
    }

    public function main_update(Request $request)
    {
        $info = PageMain::find(1);

        $info->author_name = $request->author_name;
        $info->slogan = $request->slogan;

        if($request->main_image_path) {
            // удаляю имеющуюся папку с файлами
            $explode_image_path = explode("\\", $info->main_path);
            $explode_image_path[0] = 'copies';
            File::deleteDirectory(implode('/', $explode_image_path));

            // удаляю все данные о путях к картинке и копиям из таблицы бд
            $info->main_path = NULL;
            $info->copy_main = NULL;
            $info->copy_2400 = NULL;
            $info->copy_1600 = NULL;
            $info->copy_1200 = NULL;
            $info->copy_800 = NULL;

            // create image manager with desired driver
            $manager = new ImageManager(new Driver());

            $info->main_path = $request->main_image_path; //записываю в таблицу бд исходный путь загружаемой картинки

            $image = $manager->read($request->main_image_path); //получаю исходную загруженную из админки картинку
            $height = $image->height(); // узнаю высоту картинки
            $width = $image->width(); // узнаю ширину картинки

            // разбираю путь до картинки, удаляю первый элемент (папку 'storage'), новый путь начинается с папки copies:
            $explode_path = explode("\\", $request->main_image_path);
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
            $info->copy_main = $current_path . '/' . $name . '.' . $ext; //записываю в таблицу бд копию загружаемой картинки
            
            if($height > 800 && $width > 800) {
                // проверяю и меняю размеры исходной картинки и делаю копии с разрешениями 2400,1600,1200,800px:
                if($height > $width) {
                    if($width > 2400) {
                        $image->scale(width: 2400);
                        $image->toWebp()->save($current_path . '/' . $name . '__2400px.' . 'webp');
                        $info->copy_2400 = $current_path . '/' . $name . '__2400px.' . 'webp';
                    }
                    if($width > 1600) {
                        $image->scale(width: 1600);
                        $image->toWebp()->save($current_path . '/' . $name . '__1600px.' . 'webp');
                        $info->copy_1600 = $current_path . '/' . $name . '__1600px.' . 'webp';
                    }
                    if($width > 1200) {
                        $image->scale(width: 1200);
                        $image->toWebp()->save($current_path . '/' . $name . '__1200px.' . 'webp');
                        $info->copy_1200 = $current_path . '/' . $name . '__1200px.' . 'webp';
                    }
                    $image->scale(width: 800);
                    $image->toWebp()->save($current_path . '/' . $name . '__800px.' . 'webp');
                    $info->copy_800 = $current_path . '/' . $name . '__800px.' . 'webp';
                } else {
                    if($height > 2400) {
                        $image->scale(height: 2400);
                        $image->toWebp()->save($current_path . '/' . $name . '__2400px.' . 'webp');
                        $info->copy_2400 = $current_path . '/' . $name . '__2400px.' . 'webp';
                    }
                    if($height > 1600) {
                        $image->scale(height: 1600);
                        $image->toWebp()->save($current_path . '/' . $name . '__1600px.' . 'webp');
                        $info->copy_1600 = $current_path . '/' . $name . '__1600px.' . 'webp';
                    }
                    if($height > 1200) {
                        $image->scale(height: 1200);
                        $image->toWebp()->save($current_path . '/' . $name . '__1200px.' . 'webp');
                        $info->copy_1200 = $current_path . '/' . $name . '__1200px.' . 'webp';
                    }
                    $image->scale(height: 800);
                    $image->toWebp()->save($current_path . '/' . $name . '__800px.' . 'webp');
                    $info->copy_800 = $current_path . '/' . $name . '__800px.' . 'webp';
                }    
            }
        }

        $info->save();

        return redirect()->back()->withSuccess('Страница была успешно обновлена');
    }

    public function about_edit()
    {
        return 'Здесь пока ничего нет';
    }

    public function about_update(Request $request)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        //
    }
}
