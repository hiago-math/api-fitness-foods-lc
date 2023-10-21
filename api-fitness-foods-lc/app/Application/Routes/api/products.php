<?php

use App\Application\Http\Controllers\Products\DeleteProductByCodeController;
use Application\Http\Controllers\Products\GetAllProductsController;
use Application\Http\Controllers\Products\GetProductByCodeController;
use Application\Http\Controllers\Products\UpdateProductByCodeController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('/', GetAllProductsController::class);
    Route::get('/{code}', GetProductByCodeController::class);
    Route::put('/{code}', UpdateProductByCodeController::class);
    Route::delete('/{code}', DeleteProductByCodeController::class);
});
