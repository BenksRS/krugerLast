<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\{DashboardController};



Route::prefix('dashboard')->name('dashboard.')->group(function () {
//
    // Referrals
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/list/{type}', [DashboardController::class, 'list'])->name('list');
});
