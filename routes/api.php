<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Users\UserController;

use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\SignOutController;

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

Route::post('/sign-in', SignInController::class);
Route::post('/sign-up', SignUpController::class);
Route::post('/sign-out', SignOutController::class)->middleware('auth');

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{userId}', [UserController::class, 'show']);
Route::delete('/users/{userId}', [UserController::class, 'destroy']);
