<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

Route::resource('product', ProductController::class)->except(['create', 'edit']);
// Route::get('/fetch', [ProductController::class, 'fetch']);
// Route::get('/product1', [ProductController::class, 'index1']);


Route::get('/', function () {
    return view('main');
});
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
