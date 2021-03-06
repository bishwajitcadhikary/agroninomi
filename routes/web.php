<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->middleware(["auth"]);

Auth::routes(['register' => false]);

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::group(['middleware' => 'auth'], function (){
    Route::group(['prefix' => 'users'], function (){
        Route::resource('admins', \App\Http\Controllers\AdminController::class)->except('show');
        Route::resource('clients', \App\Http\Controllers\ClientController::class)->except('show');
    });

    Route::resource('apps', \App\Http\Controllers\AppController::class)->except('show');
    Route::get('pages/search', [\App\Http\Controllers\PageController::class, 'search'])->name('pages.search');
    Route::resource('pages', \App\Http\Controllers\PageController::class)->except('show','edit','update');
});
