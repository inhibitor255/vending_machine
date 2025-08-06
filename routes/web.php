<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\User\UserTransactionController;

Route::resource('products', ProductController::class);
Route::get('products/{product}/purchase', [ProductController::class, 'purchaseView'])->name('products.purchaseView');
Route::post('products/{product}/purchase', [ProductController::class, 'purchase'])->name('products.purchase');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('transactions', TransactionController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('my-transactions', [UserTransactionController::class, 'index'])->name('user.transactions.index');
    Route::get('my-transactions/{transaction}', [UserTransactionController::class, 'show'])->name('user.transactions.show');
});
