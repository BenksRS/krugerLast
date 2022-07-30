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

use Illuminate\Support\Facades\Route;
use Modules\Referrals\Http\Controllers\{AuthorizationController, TypeController, ReferralController};

//    Route::get('testlive', [Live::class])->name('testlive');

//Route::get('table', \Modules\Core\Http\Livewire\Pages\TablePage::class)->name('table');

//Route::get('table', \Modules\Referrals\Http\Livewire\Pages\ShowReferrals::class)->name('table');



Route::prefix('referrals')->name('referrals.')->group(function () {
//
	// Referrals
	Route::get('/', [ReferralController::class, 'index'])->name('index');
    Route::get('/new', [ReferralController::class, 'new'])->name('new');
	Route::get('/show/{id}', [ReferralController::class, 'show'])->name('show');
    Route::post('/ref_auth_sync', [ReferralController::class, 'ref_auth_sync'])->name('ref_auth_sync');
    Route::post('/bloco_update', [ReferralController::class, 'bloco_update'])->name('bloco_update');



//    Route::get('/', \Modules\Core\Http\Livewire\Pages\HomePage::class)->name('home');


	// Referral Types
	Route::prefix('types')->name('types.')->group(function () {
		Route::get('/', [TypeController::class, 'index'])->name('index');
		Route::get('/show/{id}', [TypeController::class, 'show'])->name('show');
	});
	// Referral Authorizathions
	Route::prefix('authorizations')->name('authorizations.')->group(function () {
		Route::get('/', [AuthorizationController::class, 'index'])->name('index');
		Route::get('/show/{id}', [AuthorizationController::class, 'show'])->name('show');
		Route::get('/new/{id}', [AuthorizationController::class, 'auth_new'])->name('new');
	});
});



