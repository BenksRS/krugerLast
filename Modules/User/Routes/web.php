<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Auth\LoginController;
use Modules\User\Http\Controllers\SickLeaveController;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('index');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::prefix('sick-leave')->name('sick-leave.')->group(function () {
    Route::get('/', [SickLeaveController::class, 'index'])->name('index');
});