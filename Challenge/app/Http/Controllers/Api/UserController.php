<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
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
        try {
            $user = User::findOrFail($id);

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
}
