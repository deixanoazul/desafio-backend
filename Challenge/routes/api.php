<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::prefix('users')->group(function() {
        Route::post('/', [UserController::class, 'store']);
    });
});