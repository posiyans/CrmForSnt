<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v2/advanced-options'], function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/', \App\Modules\AdvancedOptions\Controllers\AddAdvancedOptionsController::class);
        Route::get('/', \App\Modules\AdvancedOptions\Controllers\GetAdvancedOptionsController::class);
        Route::post('/value/{options}', \App\Modules\AdvancedOptions\Controllers\CreateAdvancedOptionsValueController::class);
        Route::put('/value/{option}', \App\Modules\AdvancedOptions\Controllers\UpdateAdvancedOptionsValueController::class);
    });
});
