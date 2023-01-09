<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewTemplateController;
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
    return view('layouts.front-layout', ['title' => 'Homepage | Urban Adventure']);
});
Route::get('/test', function () {
    return Product::popular();
});

Route::controller(ViewTemplateController::class)->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.admin.main-dashboard', ['title' => 'Dashboard | Urban Adventure']);
    })->name('dashboard')->middleware('auth');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/dashboard/categories', 'allCategory')->name('manage_category.all')->middleware('can:isAdmin');
    Route::get('/dashboard/category/create', 'createCategory')->name('manage_category.create')->middleware('can:isAdmin');
    Route::post('/dashboard/category/create', 'storeCategory')->name('manage_category.store')->middleware('can:isAdmin');
    Route::get('/dashboard/category/{category:id}', 'detailCategory')->name('manage_category.detail')->middleware('can:isAdmin');
    Route::get('/dashboard/category/{category:id}/update', 'updateCategory')->name('manage_category.update')->middleware('can:isAdmin');
    Route::patch('/dashboard/category/{category:id}', 'patchCategory')->name('manage_category.patch')->middleware('can:isAdmin');
    Route::delete('/dashboard/category/{category:id}/delete', 'deleteCategory')->name('manage_category.delete')->middleware('can:isAdmin');
});
Route::controller(OrderController::class)->group(function () {
    Route::get('/dashboard/orders', 'allOrder')->name('manage_order.all');
    Route::get('/dashboard/order/create', 'createOrder')->name('manage_order.create');
});
Route::controller(ProductController::class)->group(function () {
    Route::get('/dashboard/products', 'allProduct')->name('manage_product.all')->middleware('can:isAdmin');
    Route::get('/dashboard/product/create', 'createProduct')->name('manage_product.create')->middleware('can:isAdmin');
    Route::post('/dashboard/product/create', 'storeProduct')->name('manage_product.store')->middleware('can:isAdmin');
    Route::get('/dashboard/product/{product}', 'detailProduct')->name('manage_product.detail')->middleware('can:isAdmin');
    Route::get('/dashboard/product/{product}/update', 'updateProduct')->name('manage_product.update')->middleware('can:isAdmin');
    Route::patch('/dashboard/product/{product}', 'patchProduct')->name('manage_product.patch')->middleware('can:isAdmin');
    Route::delete('/dashboard/product/{product}', 'deleteProduct')->name('manage_product.delete')->middleware('can:isAdmin');
});
Route::controller(UserController::class)->group(function () {
    Route::get('/dashboard/users', 'allUser')->name('manage_user.all')->middleware('can:isAdmin');
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'attemptLogin')->name('attempt_login');
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'attemptRegister')->name('attempt_register');
    Route::get('/logout', 'logout')->name('logout');
    Route::delete('/dashboard/user/{user}', 'deleteUser')->name('manage_user.delete')->middleware('can:isAdmin');
});
Route::controller(CartController::class)->group(function () {
    Route::get('/dashboard/carts', 'allCart')->name('manage_cart.all');
});