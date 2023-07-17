<?php

use \Modules\Profile\Http\Controllers\ProfileController;
use \Modules\Profile\Http\Controllers\Tabs\TimesheetController;

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

Route::prefix('/profile/app')->name('profile.app.')->group(function () {

    Route::get('/', [ProfileController::class, 'index'])->name('index');

    Route::prefix('/timesheet')->name('timesheet.')->group(function () {
        Route::get('/', [TimesheetController::class, 'index'])->name('index');
        Route::get('/show', [TimesheetController::class, 'show'])->name('show');
        Route::get('/build', [TimesheetController::class, 'build'])->name('build');
    });
});
