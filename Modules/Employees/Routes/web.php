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
    Route::get('/', [\Modules\Employees\Http\Controllers\EmployeesController::class, 'index'])->name('index');
    Route::get('/show/{id}', [\Modules\Employees\Http\Controllers\EmployeesController::class, 'show'])->name('show');
    Route::get('/list_worker/{id}/{month?}/{start_day?}/{end_day?}', [\Modules\Employees\Http\Controllers\EmployeesController::class, 'list_worker'])->name('list_worker');
    Route::get('/upload/', [\Modules\Employees\Http\Livewire\Show\Tabs\Receipts\Add::class, 'upload'])->name('upload');
    Route::get('/phpinfo', [\Modules\Employees\Http\Controllers\EmployeesController::class, 'phpinfo'])->name('phpinfo');
    Route::get('/rules', [\Modules\Employees\Http\Controllers\EmployeesController::class, 'rules'])->name('rules');
    Route::get('/commissions', [\Modules\Employees\Http\Controllers\EmployeesController::class, 'commissions'])->name('commissions');

    Route::get('/check_comission/{id}', [\Modules\Employees\Http\Controllers\EmployeesController::class, 'check_comission'])->name('check_comission');
    Route::get('/script_comission', [\Modules\Employees\Http\Controllers\EmployeesController::class, 'script_comission'])->name('script_comission');
    Route::get('/guia', [\Modules\Employees\Http\Controllers\EmployeesController::class, 'guia'])->name('guia');
});

Route::prefix('/profile')->name('employees.')->group(function () {
    Route::get('/', [\Modules\Employees\Http\Controllers\EmployeesController::class, 'profile'])->name('profile');

    //    Route::prefix('/app')->name('app.')->group(function () {
    //        Route::get('/', [\Modules\Employees\Http\Controllers\EmployeesAppController::class, 'index'])->name('index');
    //    });
});
Route::prefix('/employees_docs')->name('employees.')->group(function () {
    Route::get('/', [\Modules\Employees\Http\Controllers\EmployeesController::class, 'docs'])->name('docs');
    Route::get('/show/{id}', [\Modules\Employees\Http\Controllers\EmployeesController::class, 'show'])->name('show');
    //    Route::prefix('/app')->name('app.')->group(function () {
    //        Route::get('/', [\Modules\Employees\Http\Controllers\EmployeesAppController::class, 'index'])->name('index');
    //    });
});
