<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;

Route::view('/', 'dashboard')->name('dashboard');

Route::resource('product', ProductController::class);
Route::resource('material', MaterialController::class);

