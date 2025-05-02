<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Middleware\AdminPanelMiddleware;


Route::get('/', [App\Http\Controllers\IndexController::class, 'index']);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);


Route::group(['name' => 'admin', 'prefix' => 'admin_panel'], function () {
    Route::get('login', [App\Http\Controllers\Admin\AdminController::class, 'getLogin'])->name('login');
    Route::post('login', [App\Http\Controllers\Admin\AdminController::class, 'postLogin']);
    Route::post('logout', [App\Http\Controllers\Admin\AdminController::class, 'postLogout'])->name('logout');
    
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminPanelController::class, 'index'])->name('homeAdmin');

        Route::resource('category', App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('product', App\Http\Controllers\Admin\ProductController::class);

        // Route::resource('page', App\Http\Controllers\Admin\PageController::class);

        Route::group(['name' => 'page', 'prefix' => 'page'], function () {
            Route::get('main', [App\Http\Controllers\Admin\PageController::class, 'main_edit'])->name('pageMainEdit');
            Route::patch('main/update', [App\Http\Controllers\Admin\PageController::class, 'main_update'])->name('pageMainUpdate');

            Route::get('about', [App\Http\Controllers\Admin\PageController::class, 'about_edit'])->name('pageAboutEdit');
            Route::patch('about/update', [App\Http\Controllers\Admin\PageController::class, 'about_update'])->name('pageAboutUpdate');
            
        });

    });
});

// Route::get('/elfinder/popup', 'Barryvdh\Elfinder\ElfinderController@showPopup');
