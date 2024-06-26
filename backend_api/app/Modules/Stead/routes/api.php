<?php
//define('__ROOT__', dirname(__FILE__));
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['prefix' => 'v2/stead'], function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('create', \App\Modules\Stead\Controllers\CreateSteadController::class);
        Route::post('update/{stead}', \App\Modules\Stead\Controllers\UpdateSteadInfoController::class);
        Route::get('get-files/{stead}', \App\Modules\Stead\Controllers\GetFilesForSteadController::class);
        Route::post('update-proportion', \App\Modules\Stead\Controllers\UpdateSteadOwnerProportionController::class);
        Route::get('/get-kadastr-info', \App\Modules\Stead\Controllers\GetKadastrInfoController::class);
        Route::get('/get-my-steads', \App\Modules\Stead\Controllers\GetMySteadsController::class);
    });
    Route::get('/list', [\App\Modules\Stead\Controllers\GetSteadListController::class, 'index']);
    Route::get('/info', [\App\Modules\Stead\Controllers\GetSteadInfoController::class, 'index']);
    Route::get('/get-list-for-owner', \App\Modules\Stead\Controllers\GetListOfOwnerSteadController::class);
});