<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
    
    Route::group(['middleware' => 'jwt.auth'], function() {
 
        Route::group(['namespace' => 'Fruit', 'prefix' => 'fruits'], function () {
            Route::get('/', [App\Http\Controllers\Fruit\IndexController::class, 'index']);
        });
        
        Route::post('me', [App\Http\Controllers\AuthController::class, 'me']);
    });
});

Route::group(['namespace' => 'User', 'prefix' => 'users'], function () {
    Route::post('/', [App\Http\Controllers\User\StoreController::class, 'index']);
});

Route::get('/categories', [App\Http\Controllers\CategoryResourceController::class, 'index']);
Route::get('/category', [App\Http\Controllers\CategoryResourceController::class, 'index_single']);

Route::get('/products', [App\Http\Controllers\ProductResourceController::class, 'index']);
Route::get('/product', [App\Http\Controllers\ProductResourceController::class, 'index_single']);
