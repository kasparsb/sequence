<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\NumberFormatsController;

Route::middleware('auth:api')->group(function () {

    Route::get('/number/formats', [NumberFormatsController::class, 'index']);

    Route::get('/number/generate/{numberFormatId}/{count?}', [NumberFormatsController::class, 'generate']);
});