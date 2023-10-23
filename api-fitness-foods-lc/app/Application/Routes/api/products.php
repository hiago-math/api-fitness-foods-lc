<?php

use App\Application\Http\Controllers\Products\DeleteProductByCodeController;
use Application\Http\Controllers\Products\GetAllProductsController;
use Application\Http\Controllers\Products\GetProductByCodeController;
use Application\Http\Controllers\Products\UpdateProductByCodeController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->name('.products')->group(function () {
    Route::get('/', GetAllProductsController::class)->name('.get.all');
    Route::get('{code}', GetProductByCodeController::class)->name('.get.by.code');
    Route::put('/{code}', UpdateProductByCodeController::class)->name('.updatebycode');
    Route::delete('/{code}', DeleteProductByCodeController::class)->name('.delete.by.code');
});
