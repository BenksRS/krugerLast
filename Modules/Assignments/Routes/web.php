<?php

use Illuminate\Support\Facades\Route;
use Modules\Assignments\Http\Controllers\AssignmentsController;

Route::prefix('/assignments')->name('assignments.')->group(function () {

	// Assignments
	Route::get('/', [AssignmentsController::class, 'index'])->name('index');
	Route::get('/gdrive', [AssignmentsController::class, 'gdrive'])->name('gdrive');
	Route::get('/open', [AssignmentsController::class, 'open'])->name('open');
	Route::get('/new', [AssignmentsController::class, 'new'])->name('new');
	Route::get('/show/{id}', [AssignmentsController::class, 'show'])->name('show');
	Route::get('/list', [AssignmentsController::class, 'list'])->name('list');
    Route::get('/pdfauth/{id}/{page}', [AssignmentsController::class, 'pdfauth'])->name('pdfauth');
    Route::get('/pdfgallerylabel/{id}', [AssignmentsController::class, 'pdfgallerylabel'])->name('pdfgallerylabel');
    Route::get('/pdfgallery/{id}', [AssignmentsController::class, 'pdfgallery'])->name('pdfgallery');
    Route::get('/pdfgallerybefore/{id}', [AssignmentsController::class, 'pdfgallerybefore'])->name('pdfgallerybefore');
    Route::get('/pdfgalleryafter/{id}', [AssignmentsController::class, 'pdfgalleryafter'])->name('pdfgalleryafter');


});
