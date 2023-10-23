<?php

use Application\Http\Controllers\Errors\GetErrorsElasticsearchController;
use Illuminate\Support\Facades\Route;

Route::prefix('errors')->name('.errors')->group(function () {
    Route::get('/', GetErrorsElasticsearchController::class)->name('.get.all');
});
