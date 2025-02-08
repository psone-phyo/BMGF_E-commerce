<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentHistoryController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/dashboard/get', [DashboardController::class, 'get']);

Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'get']);
    Route::get('/get/{id}', [ProductController::class, 'details']);
    Route::post('/create', [ProductController::class, 'store']);
    Route::post('/image/upload', [ProductController::class, 'storeImage']);
    Route::put('/update/{id}', [ProductController::class, 'update']);
    Route::delete('/delete/{id}', [ProductController::class, 'delete']);
});

Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'get']);
    Route::get('/get/{id}', [CategoryController::class, 'details']);
    Route::post('/create', [CategoryController::class, 'store']);
    Route::put('/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/delete/{id}', [CategoryController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('order')->group(function () {
    Route::post('/create', [OrderController::class, 'store']);
    Route::get('/', [PaymentHistoryController::class, 'orderlist']);
    Route::post('/checkout', [PaymentHistoryController::class, 'checkout']);
});

require __DIR__.'/auth.php';
