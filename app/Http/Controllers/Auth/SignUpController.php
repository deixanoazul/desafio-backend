<?php

namespace App\Http\Controllers\Auth;

use App\Services\UserService;

use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpRequest;

class SignUpController extends Controller {
    /**
     * The auth service.
     *
     * @var \App\Services\AuthService
     */
    private $service;

    public function __construct (UserService $service) {
        $this->service = $service;
    }

    /**
     * Handle the sign up request.
     *
     * @param \App\Http\Requests\Auth\SignUpRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function __invoke (SignUpRequest $request): UserResource {
        $attributes = $request->validated();

        $user = $this->service->create($attributes);

        return UserResource::make($user);
    }
}
