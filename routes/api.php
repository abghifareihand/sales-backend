<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\OutletController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function() {
    // Auth
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class,'profile']);
    Route::post('update-profile', [AuthController::class, 'updateProfile']);
    Route::post('update-password', [AuthController::class, 'updatePassword']);

    // Dashboard
    Route::get('dashboard', [DashboardController::class,'index']);
    Route::get('distributions', [DashboardController::class,'distributions']);

    // Product
    Route::get('products', [ProductController::class,'index']);
    Route::post('products/return-stock', [ProductController::class,'returnStock']);

    // Transaction
    Route::post('transactions', [TransactionController::class,'store']);
    Route::get('transactions', [TransactionController::class,'index']);

    // Outlet
    Route::get('outlets', [OutletController::class,'index']);
    Route::post('outlets', [OutletController::class,'store']);
});
