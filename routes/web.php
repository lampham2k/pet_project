<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Redirect;

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


Route::get('/test', [TestController::class, 'test'])->name('test');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/registering', [AuthController::class, 'registering'])->name('registering');
Route::post('/processLogin', [AuthController::class, 'processLogin'])->name('processLogin');

Route::get('/', function () {
    return view('layout.master');
})->name('welcome');

Route::get('/auth/redirect/{provider}', function ($provider) {
    return Socialite::driver($provider)->redirect();
})->name('auth.redirect');

Route::get('/auth/callback/{provider}', [AuthController::class, 'callback'])->name('auth.callback');


Route::get('/language/{locale}', function ($locale) {
    if (!in_array($locale, config('app.locales'))) {
        $locale = config('app.fallack_locale');
    }

    return redirect()->back()->withCookie(cookie('locale', $locale, 6000));
})->name('language');
