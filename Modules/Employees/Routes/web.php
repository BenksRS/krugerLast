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

Route::prefix('/employees')->name('employees.')->group(function () {
    Route::get('/', [\Modules\Employees\Http\Controllers\EmployeesController::class, 'index'])->name('index');
    Route::get('/show/{id}', [\Modules\Employees\Http\Controllers\EmployeesController::class, 'show'])->name('show');
    Route::get('/upload/', [\Modules\Employees\Http\Livewire\Show\Tabs\Receipts\Add::class, 'upload'])->name('upload');
    Route::get('/phpinfo', [\Modules\Employees\Http\Controllers\EmployeesController::class, 'phpinfo'])->name('phpinfo');

});
