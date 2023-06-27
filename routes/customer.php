<?php

use App\Http\Controllers\Customer\HomepageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomepageController::class, 'index'])->name('welcome');
Route::get('/products/{products}', [HomepageController::class, 'products'])->name('products');
Route::get('/product_discount', [HomepageController::class, 'productDiscount'])->name('product_discount');
Route::get('/product/{id}', [HomepageController::class, 'product'])->name('product');
Route::post('/addToCards', [HomepageController::class, 'addToCards'])->name('addToCards');
Route::get('/carts', [HomepageController::class, 'carts'])->name('carts');
Route::post('/update-quantity', [HomepageController::class, 'updateQuantity'])->name('update-quantity');
Route::post('/checkout', [HomepageController::class, 'checkout'])->name('checkout');
Route::post('/addNewAddress', [HomepageController::class, 'addNewAddress'])->name('addNewAddress');
Route::post('/editAddress', [HomepageController::class, 'editAddress'])->name('editAddress');
Route::post('/storeEditAddress', [HomepageController::class, 'storeEditAddress'])->name('storeEditAddress');
Route::post('/confirmDefaultAddress', [HomepageController::class, 'confirmDefaultAddress'])->name('confirmDefaultAddress');
Route::get('/place-order', [HomepageController::class, 'placeOrder'])->name('place-order');
Route::post('/cancelProduct', [HomepageController::class, 'cancelProduct'])->name('cancelProduct');
Route::post('/post-comment', [HomepageController::class, 'postComment'])->name('post-comment');
Route::post('/reply-comment', [HomepageController::class, 'replyComment'])->name('reply-comment');
