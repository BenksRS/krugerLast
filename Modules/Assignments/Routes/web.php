<?php

use Illuminate\Support\Facades\Route;
use Modules\Assignments\Http\Controllers\AssignmentsController;

Route::prefix('/assignments')->name('assignments.')->group(function () {

	// Assignments
	Route::get('/', [AssignmentsController::class, 'index'])->name('index');
	Route::get('/open', [AssignmentsController::class, 'open'])->name('open');
	Route::get('/new', [AssignmentsController::class, 'new'])->name('new');
	Route::get('/show/{id}', [AssignmentsController::class, 'show'])->name('show');
	Route::get('/list', [AssignmentsController::class, 'list'])->name('list');
    Route::get('/pdfauth/{id}/{page}', [AssignmentsController::class, 'pdfauth'])->name('pdfauth');

});
