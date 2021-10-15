<?php

use App\Http\Controllers\Api as CONT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [CONT\V1\LoginController::class, 'login']);
Route::post('/register', [CONT\V1\RegisterController::class, 'register']);

Route::group(['as' => 'api', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/me', function (Request $request) {
        return $request->user();
    });
    Route::post('logout', [CONT\V1\LogoutController::class, 'logout'])->name('logout');

    Route::apiResource('apps', CONT\V1\AppController::class)->except('show');
    Route::apiResource('clients', CONT\V1\ClientController::class);
    Route::get('pages/search', [CONT\V1\PageController::class, 'search'])->name('pages.search');
    Route::apiResource('pages', CONT\V1\PageController::class);
});
