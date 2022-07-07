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


Route::prefix('/schedulling')->name('schedulling.')->group(function () {

    // Assignments
    Route::get('/', [\Modules\Scheduling\Http\Controllers\SchedulingController::class, 'index'])->name('index');

});