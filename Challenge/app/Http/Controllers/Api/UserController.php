<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeOpeningAmountRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::query()->orderBy('id', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        try {
            $data = $request->validated();
    
            $data['password'] = Hash::make($request->password);
    
            $user = User::create($data);
    
            return new UserResource($user);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return ApiResponse::errorMessage($e->getMessage(), $e->getCode());
            } else {
                return ApiResponse::errorMessage('Houve um erro ao cadastrar o usuário! Contate a administração para investigar o problema.', 500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $transactions_count = $user->transactions()->count();
        $opening_amount = $user->opening_amount;

        if ($transactions_count > 0) {
            return ApiResponse::errorMessage('O usuário possui transações em sua conta. Não é possível removê-lo do sistema!', 405);
        } elseif ($opening_amount > 0 || $opening_amount != null) {
            return ApiResponse::errorMessage('O usuário possui saldo em sua conta. Não é possível removê-lo do sistema!', 405);
        }

        try {
            $user->delete();
            
            return ApiResponse::successMessage('O usuário foi removido com sucesso!', 204);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return ApiResponse::errorMessage($e->getMessage(), $e->getCode());
            } else {
                return ApiResponse::errorMessage('Houve um erro ao remover o usuário! Contate a administração para investigar o problema.', 500);
            }
        }
    }

    /**
     *  Change the opening amount from an user.
     * 
     *  @param \App\Http\Requests\ChangeOpeningAmountRequest $request;
     *  @param  int  $id;
     *  @return \Illuminate\Http\Response
     */
    public function changeOpeningAmount(ChangeOpeningAmountRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $new_amount = $request->validated();

            $user->update($new_amount);

            return new UserResource($user);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return ApiResponse::errorMessage($e->getMessage(), $e->getCode());
            } else {
                return ApiResponse::errorMessage('Houve um erro ao atualizar o saldo inicial do usuario. Contate a administração para investigar o problema.', 500);
            }
        }
    }
}
