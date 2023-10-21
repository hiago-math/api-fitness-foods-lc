<?php

use Application\Http\Controllers\Products\GetAllProductsController;
use Application\Http\Controllers\Products\GetProductByCodeController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('/', GetAllProductsController::class);
    Route::get('/{code}', GetProductByCodeController::class);
});
