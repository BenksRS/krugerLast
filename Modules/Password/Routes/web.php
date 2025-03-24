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

use Illuminate\Support\Facades\Route;
use Modules\Password\Http\Controllers\PasswordController;

Route::prefix('password')->name('password.')->group(function() {
    Route::get('/', [PasswordController::class, 'index'])->name('index');
    Route::get('/admin',[PasswordController::class, 'admin'])->name('admin');
});