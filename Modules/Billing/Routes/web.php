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

Route::prefix('billing')->name('billing.')->group(function() {
    Route::get('/', 'BillingController@index');

    // Disparo manual de teste do Validation Engine via URL (mesmo comportamento do
    // artisan billing:generate-plan, sem precisar de acesso ao shell do container).
    Route::match(['get', 'post'], '/test/{assignment}', [\Modules\Billing\Http\Controllers\BillingTestController::class, 'generatePlan'])
        ->name('test_generate_plan');
});
