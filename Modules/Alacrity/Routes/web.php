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

Route::prefix('alacrity')->group(function() {


    Route::get('/', 'AlacrityController@index');
    Route::get('/getAll/', 'AlacrityController@getAll');
    Route::get('/acceptJob/', 'AlacrityController@acceptJob');
    Route::get('/updateCC/', 'AlacrityController@updateCC');
    Route::get('/search/', 'AlacrityController@search');
    Route::get('/postCC/', 'AlacrityController@postCC');
    Route::get('/queue_jobs/', 'AlacrityController@queue_jobs');
    Route::get('/alert/', 'AlacrityController@alert');


});
