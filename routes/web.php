<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/products',[\App\Http\Controllers\ProductController::class,'index'])->name('products.index');

Route::get('/listCartItems',[\App\Http\Controllers\ProductController::class,'listCartItems'])->name('listCartItems');

Route::get('/cartItemsPage',[\App\Http\Controllers\ProductController::class,'cartItemsPage'])->name('cartItemsPage');

Route::post('/item/delete/{id}',[\App\Http\Controllers\ProductController::class,'deleteItem'])->name('cartItem.delete');

Route::post('/item/update/{id}',[\App\Http\Controllers\ProductController::class,'updateQuantity'])->name('cartItem.updateQuantity');

Route::post('/addToCart',[\App\Http\Controllers\ProductController::class,'addToCart'])->name('add_to_cart');
