<?php

use App\Http\Controllers\Api\AuthenticateController;
use App\Http\Controllers\Api\LogoutApiSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function() {
    Route::post('login', AuthenticateController::class)->name('api.login');
    Route::post('logout', LogoutApiSessionController::class)->name('api.logout')->middleware('auth:sanctum');
});
