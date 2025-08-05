<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\AuthController;

// Public route for getting a token
Route::post('/v1/login', [AuthController::class, 'login']);

// Group all protected routes under Sanctum's middleware
Route::middleware('auth:sanctum')->prefix('v1')->name('api.')->group(function () {

    // This single line creates routes for:
    // GET /products, GET /products/{id}, POST /products,
    // PUT /products/{id}, DELETE /products/{id}
    Route::apiResource('products', ProductController::class);

    // Route to revoke the token
    Route::post('/logout', [AuthController::class, 'logout']);
});
