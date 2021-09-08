<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TransacaoController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List usuario
Route::get('usuario', [UsuarioController::class, 'index']);

// List single artigo
Route::get('usuario/{id}', [UsuarioController::class, 'show']);

// Create new usuario
Route::post('usuario', [UsuarioController::class, 'store']);

// Update usuario
Route::put('usuario/{id}', [UsuarioController::class, 'update']);

// Delete usuario
Route::delete('usuario/{id}', [UsuarioController::class,'destroy']);

//transacoes

// List transacao
Route::get('transacao', [TransacaoController::class, 'index']);

// List single transacao
Route::get('transacao/{id}', [TransacaoController::class, 'show']);

// Create new transacao
Route::post('transacao', [TransacaoController::class, 'store']);

// Update transacao
Route::put('transacao/{id}', [TransacaoController::class, 'update']);

// Delete artigo
Route::delete('transacao/{id}', [TransacaoController::class,'destroy']);
