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

Route::prefix('reports')->name('reports.')->group(function() {
    Route::get('/', 'ReportsController@index')->name('index');
		Route::get('/tags', 'ReportsController@tags')->name('tags');
        Route::get('/mkt', 'ReportsController@mkt')->name('mkt');
		Route::get('/nadal', 'ReportsController@nadal')->name('nadal');
});
