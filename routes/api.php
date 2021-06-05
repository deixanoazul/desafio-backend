<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\UserTransactionController;
use App\Http\Controllers\Transactions\TransactionController;


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

Route::post('/sign-in', [AuthController::class, 'signIn']);
Route::post('/sign-out', [AuthController::class, 'signOut'])
    ->middleware('auth');

Route::apiResource('users', UserController::class)
    ->only(['index', 'show', 'store', 'destroy']);

Route::apiResource('users.transactions', UserTransactionController::class)
    ->only(['index', 'store']);

Route::apiResource('transactions', TransactionController::class)
    ->only(['index', 'show', 'destroy']);
