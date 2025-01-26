<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PurchaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Produtos
Route::apiResource('products', ProductController::class);

// Compras (autenticado)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('purchases', PurchaseController::class);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

//Comprar Disponiveis
Route::get('products/available', [ProductController::class, 'availableProducts']);

//TODO:
// Autenticação Sanctum
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);