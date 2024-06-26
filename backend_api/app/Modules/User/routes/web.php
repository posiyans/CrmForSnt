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

Route::get('/api/v2/password-reset', [\App\Modules\Auth\Controllers\ResetPasswordController::class, 'reset']);
Route::get('/api/v2/logout', [\App\Modules\Auth\Controllers\LogoutController::class, 'logout']);

