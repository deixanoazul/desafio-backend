<?php

namespace App\Http\Controllers\Auth;

use App\Services\AuthService;

use App\Http\Controllers\Controller;
use App\Http\Resources\TokenResource;
use App\Http\Requests\Auth\SignInRequest;

class SignInController extends Controller {
    /**
     * The auth service.
     *
     * @var \App\Services\AuthService
     */
    private $service;

    public function __construct (AuthService $service) {
        $this->service = $service;
    }

    /**
     * Handle the sign in request.
     *
     * @param \App\Http\Requests\Auth\SignInRequest $request
     * @return \App\Http\Resources\TokenResource
     * @throws \App\Exceptions\Auth\InvalidCredentialsException
     */
    public function __invoke (SignInRequest $request): TokenResource {
        $credentials = $request->validated();

        $token = $this->service->signIn($credentials);

        return TokenResource::make($token);
    }
}
