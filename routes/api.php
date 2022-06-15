<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix("v1")->group(function () {
    Route::prefix("/classroom")->middleware('utemAuth')->group(function () {
        Route::post("/getin", function () {
            return [
                "classroom" => "M2-302",
                "subject" => "INFB8090",
                "entrance" => "2022-06-15T03:31:15.807Z",
            ];
        });

        Route::post("/getout", function () {
            return [
                "classroom" => "M2-302",
                "subject" => "INFB8090",
                "entrance" => "2022-06-15T03:31:15.807Z",
                "leaving" => "2022-06-15T03:31:15.807Z",
            ];
        });

        Route::get("/attendances", function () {
            return [
                    "classroom" => "M2-302",
                    "subject" => "INFB8090",
                    "entrance" => "2022-06-15T01:19:55.984Z",
                    "leaving" => "2022-06-15T01:19:55.984Z",
            ];
        });
    });

    Route::prefix('authentication')->group(function () {
        Route::get('/login', function () {
            return [
                "classroom" => "M2-302",
                "subject" => "INFB8090",
                "entrance" => "2022-06-15T03:35:01.907Z",
                "leaving" => "2022-06-15T03:35:01.907Z",
                "email" => "ssalazar@utem.cl",
            ];
        });

        Route::get('/result', function () {
            return [
                "classroom" => "M2-302",
                "subject" => "INFB8090",
                "entrance" => "2022-06-15T03:35:01.907Z",
                "leaving" => "2022-06-15T03:35:01.907Z",
                "email" => "ssalazar@utem.cl",
            ];
        });
    });
});
