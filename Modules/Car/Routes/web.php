<?php

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

Route::prefix('/cars')->name('cars.')->group(function () {

    Route::get('/', [\Modules\Car\Http\Controllers\CarController::class, 'index'])->name('index');
    Route::get('/show/{id}', [\Modules\Car\Http\Controllers\CarController::class, 'show'])->name('show');

});
