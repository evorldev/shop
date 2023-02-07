<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome', [
        'products' => Product::with(['brand', 'categories'])->get(),
        'brands' => Brand::with(['products', 'products.categories'])->get(),
        'categories' => Category::with(['products', 'products.brand'])->get(),
    ]);
})->name('home');
