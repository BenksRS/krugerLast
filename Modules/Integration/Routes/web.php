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

Route::prefix('integration')->group(function() {
    Route::get('/', 'IntegrationController@index');
    Route::get('/users/', 'IntegrationController@users');
    Route::get('/gallery/', 'IntegrationController@gallery');
    Route::get('/signature/', 'IntegrationController@signature');
    Route::get('/reports/', 'IntegrationController@reports');
    Route::get('/jobs/', 'IntegrationController@jobs');
});
