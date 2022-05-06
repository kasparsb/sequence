<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {

    Route::get('/number/formats', 'Api\NumberFormatsController@index');

    Route::get('/number/generate/{numberFormatId}/{count?}', 'Api\NumberFormatsController@generate');
});