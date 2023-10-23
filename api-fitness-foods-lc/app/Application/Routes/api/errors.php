<?php

use Application\Http\Controllers\Logs\GetLogsElasticsearchController;
use Illuminate\Support\Facades\Route;

Route::prefix('logs')->name('.logs')->group(function () {
    Route::get('/', GetLogsElasticsearchController::class)->name('.get.logs');
});
