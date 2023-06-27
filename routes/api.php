<?php

use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//manufacturer
Route::get('manufacturers/api/search', [ManufacturerController::class, 'search'])->name('manufacturers.api.search');

//product
Route::get('products/api/search', [ProductController::class, 'search'])->name('products.api.search');

//user
Route::get('users/api/search', [UserController::class, 'search'])->name('users.api.search');
Route::get('users/api/inforUserDetail/{id}', [UserController::class, 'inforUserDetail'])->name('users.api.inforUserDetail');

//collaborator
Route::get('collaborators', [CollaboratorController::class, 'index'])->name('collaborators.api.index');
Route::get('users/api/inforCollaboratorDetail/{id}', [CollaboratorController::class, 'inforCollaboratorDetail'])->name('collaborators.api.inforCollaboratorDetail');

//discount
Route::get('discounts', [DiscountController::class, 'products'])->name('discounts.api.products');

//orders
Route::get('orders', [OrderController::class, 'orders'])->name('orders.api.search');
