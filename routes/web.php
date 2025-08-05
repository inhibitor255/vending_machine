<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

use App\Http\Controllers\ProductController;

Route::resource('products', ProductController::class);
Route::post('products/{product}/purchase', [ProductController::class, 'purchase'])->name('products.purchase');
