<?php

use App\Http\Controllers\Api\V1\ClientController;
use App\Http\Controllers\Api\V1\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'login']);

Route::group(['as' => 'api', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('clients', ClientController::class);
});
