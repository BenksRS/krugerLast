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


Route::prefix('/gdrive')->name('gdrive.')->group(function () {

    // Assignments
    Route::get('/', [\Modules\Gdrive\Http\Controllers\GdriveController::class, 'index'])->name('index');
    Route::get('/adjust_gdrive/', [\Modules\Gdrive\Http\Controllers\GdriveController::class, 'adjust_gdrive'])->name('adjust_gdrive');
    Route::get('/adjust_images/{id}', [\Modules\Gdrive\Http\Controllers\GdriveController::class, 'adjust_images'])->name('adjust_images');
    Route::get('/queue_dir/', [\Modules\Gdrive\Http\Controllers\GdriveController::class, 'queue_dir'])->name('queue_dir');
    Route::get('/queue_files/', [\Modules\Gdrive\Http\Controllers\GdriveController::class, 'queue_files'])->name('queue_files');
    Route::get('/create/{id}', [\Modules\Gdrive\Http\Controllers\GdriveController::class, 'create'])->name('create');
    Route::get('/image/{id}', [\Modules\Gdrive\Http\Controllers\GdriveController::class, 'image'])->name('image');
    Route::get('/pdfs/{id}', [\Modules\Gdrive\Http\Controllers\GdriveController::class, 'pdfs'])->name('pdfbefore');
    Route::get('/pdfs_auth/{id}', [\Modules\Gdrive\Http\Controllers\GdriveController::class, 'pdfs_auth'])->name('pdfs_auth');


});

Route::prefix('/scripts')->name('scripts.')->group(function () {
//    Route::get('/{id}', [\Modules\Gdrive\Http\Controllers\GdriveController::class, 'scripts'])->name('index');
    Route::get('/marketing_rep/', [\Modules\Gdrive\Http\Controllers\GdriveController::class, 'marketing_rep'])->name('marketing_rep');
});