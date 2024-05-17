<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v2/yandex'], function () {
    Route::group(['prefix' => 'schedule'], function () {
        Route::get('get', \App\Modules\Yandex\YandexSchedule\Controllers\ScheduleController::class);
        Route::get('settings/get', \App\Modules\Yandex\YandexSchedule\Controllers\GetScheduleSettingsController::class);
        Route::post('settings/update', \App\Modules\Yandex\YandexSchedule\Controllers\UpdateScheduleSettingsController::class);
    });
    Route::get('map/get-steads', App\Modules\Yandex\YandexMap\Controllers\MapController::class);
});