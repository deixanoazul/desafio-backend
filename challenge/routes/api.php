<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Transactions\TransactionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//users endpoints
Route::namespace('Api')->name('users.')->group(function () {

    Route::post('users', [UserController::class, 'store'])
        ->name('create');
    Route::get('users/{id}', [UserController::class, 'show'])
        ->name('show')->middleware('auth:sanctum');
    Route::get('users/', [UserController::class, 'index'])
        ->name('list')->middleware('auth:sanctum');
    Route::put('users/{id}', [UserController::class, 'update'])
        ->name('update')->middleware('auth:sanctum');
    Route::delete('users/delete-account', [UserController::class, 'destroy'])
        ->name('delete')->middleware('auth:sanctum');
});

Route::namespace('Api')->name('auth.')->group(function () {
    Route::post('auth/', [AuthController::class, 'postAuth'])
        ->name('login');
});

//transactions endpoint
Route::namespace('Api')->prefix('transactions')->middleware('auth:sanctum')
    ->name('transactions.')->group(function () {

        Route::post('/', [TransactionController::class, 'postTransaction'])
            ->name('post');
        Route::post('/{id}/chargeback', [TransactionController::class, 'postChargeBack'])
            ->name('post_chargeback');
        Route::get('/', [TransactionController::class, 'getTransactions'])
            ->name('get');
        Route::delete('/{id}', [TransactionController::class, 'destroy'])
            ->name('delete');
    });
