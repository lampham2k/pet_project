<?php

use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\CollaboratorController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ManufacturerController as AdminManufacturerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.master');
})->name('welcome');


Route::group([
    'as' => 'manufacturers.',
    'prefix' => 'manufacturers/',
], function () {
    Route::get('/', [AdminManufacturerController::class, 'index'])->name('index');
    Route::get('/create', [AdminManufacturerController::class, 'create'])->name('create');
    Route::post('/store', [AdminManufacturerController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [AdminManufacturerController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [AdminManufacturerController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [AdminManufacturerController::class, 'delete'])->name('delete');
});

Route::group([
    'as' => 'products.',
    'prefix' => 'products/',
], function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/store', [ProductController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('delete');
});

Route::group([
    'as' => 'users.',
    'prefix' => 'users/',
], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
});

Route::group([
    'as' => 'collaborators.',
    'prefix' => 'collaborators/',
], function () {
    Route::get('/', [CollaboratorController::class, 'index'])->name('index');
    Route::get('/create', [CollaboratorController::class, 'create'])->name('create');
    Route::post('/store', [CollaboratorController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [CollaboratorController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [CollaboratorController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [CollaboratorController::class, 'destroy'])->name('delete');
    Route::get('/marketing/{id}', [CollaboratorController::class, 'marketing'])->name('marketing');
});

Route::group([
    'as' => 'discounts.',
    'prefix' => 'discounts/',
], function () {
    Route::get('/', [DiscountController::class, 'index'])->name('index');
    Route::get('/create', [DiscountController::class, 'create'])->name('create');
    Route::post('/store', [DiscountController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [DiscountController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [DiscountController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [DiscountController::class, 'destroy'])->name('delete');
    Route::get('/product/{id}', [DiscountController::class, 'product'])->name('product');
    Route::post('/products', [DiscountController::class, 'products'])->name('products');
    Route::delete('/product_delete/{productId}/{discountId}', [DiscountController::class, 'productDelete'])->name('product_delete');
});

Route::group([
    'as' => 'orders.',
    'prefix' => 'orders/',
], function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/product/{id}', [OrderController::class, 'product'])->name('product');
    Route::get('/accept/{id}', [OrderController::class, 'accept'])->name('accept');
    Route::get('/cancel/{id}', [OrderController::class, 'cancel'])->name('cancel');
});

Route::group([
    'as' => 'chart.',
    'prefix' => 'chart/',
], function () {
    Route::get('/', [ChartController::class, 'index'])->name('index');
    Route::get('/statistical', [ChartController::class, 'statistical'])->name('statistical');
});
