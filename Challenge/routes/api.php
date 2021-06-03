<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::prefix('users')->group(function() {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
        Route::put('/{id}', [UserController::class, 'changeOpeningAmount']);

        Route::get('/{id}/transactions', [TransactionController::class, 'index']);
        Route::get('/{id}/transactions-with-infos', [TransactionController::class, 'listTransactionsWithUserInformations']);
        Route::get('/{id}/transactions-sum', [TransactionController::class, 'sumAllUserTransactions']);
        Route::delete('/{user_id}/transactions/{transaction_id}', [TransactionController::class, 'destroy']);
    });
});