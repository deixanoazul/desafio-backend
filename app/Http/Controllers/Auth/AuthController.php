<?php

namespace App\Http\Controllers\Auth;

use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Resources\TokenResource;
use App\Http\Requests\Auth\SignInRequest;

class AuthController extends Controller {
    /**
     * The auth service.
     *
     * @var \App\Services\AuthService
     */
    private $services;


    public function __construct (AuthService $services) {
        $this->services = $services;

        $this->middleware('auth')->only(['signOut']);
    }

    /**
     * Handle the sign in request.
     *
     * @param \App\Http\Requests\Auth\SignInRequest $request
     * @return \App\Http\Resources\TokenResource
     * @throws \App\Exceptions\Auth\InvalidCredentialsException
     */
    public function signIn (SignInRequest $request): TokenResource {
        $token = $this->services->signIn(
            $request->validated()
        );

        return TokenResource::make($token);
    }

    /**
     * Handle the sign out request.
     */
    public function signOut () {
        $this->services->signOut();
    }
}
