<?php

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

Route::namespace('Api')->name('users.')->group(function () {

    Route::post('users', [UserController::class, 'store'])
        ->name('create');
    Route::get('users/{id}', [UserController::class, 'show'])
        ->name('show');
    Route::get('users/', [UserController::class, 'index'])
        ->name('list');
    Route::put('users/{id}', [UserController::class, 'update'])
        ->name('update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])
        ->name('delete');
});

Route::namespace('Api')->prefix('transactions')->name('transactions.')->group(function () {
    Route::post('/', [TransactionController::class, 'postTransaction'])
        ->name('post');
    Route::get('/{id}', [TransactionController::class, 'getTransactions'])
        ->name('get');
    Route::delete('{id}', [TransactionController::class, 'destroy'])
        ->name('delete');
});
