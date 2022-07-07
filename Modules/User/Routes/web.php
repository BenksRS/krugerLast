<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Auth\LoginController;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('index');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
