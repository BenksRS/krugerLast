<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->namespace('AuthManager')->group(function () {
    Route::post('token', 'AuthController@token')->name('token');
});

Route::prefix('employees')->name('employees.')->namespace('Employee')->group(function () {
    Route::get('login', 'AuthController@teste')->name('login');
});


Route::prefix('jobs')->name('jobs.')->namespace('Job')->group(function () {
    Route::get('/', 'JobController@index')->name('index');
});
