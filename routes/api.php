<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UtemAuthController;
use App\Htpp\Controllers\AttendanceController;

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

Route::prefix("v1")->group(function () {
    Route::prefix("/classroom")
    ->middleware('utemAuth')
    ->controller(UtemAuthController::class)
    ->group(function () {
        Route::post("/getin", 'getin');

        Route::post("/getout", 'getout');

        Route::get("/attendances", 'attendances');
    });

    Route::prefix('authentication')
    ->controller(UtemAuthController::class)
    ->group(function () {
        Route::get('/login', 'login');

        Route::get('/result', 'result');
    });
});
