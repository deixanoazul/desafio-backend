<?php

namespace App\Http\Controllers\Users;

use App\Services\UserService;

use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends Controller {
    /**
     * The user service.
     *
     * @var \App\Services\UserService
     */
    private $service;

    public function __construct (UserService $service) {
        $this->service = $service;
    }

    /**
     * Handle index users request.
     *
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index (): ResourceCollection {
        $users = $this->service->all();

        return UserResource::collection($users);
    }

    /**
     * Handle show user request.
     *
     * @param string $userId
     * @return \App\Http\Resources\UserResource
     */
    public function show (string $userId): UserResource {
        $user = $this->service->find($userId);

        return UserResource::make($user);
    }

    /**
     * Handle store user request.
     *
     * @param \App\Http\Requests\Users\StoreUserRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function store (StoreUserRequest $request): UserResource {
        $user = $this->service->create(
            $request->validated()
        );

        return UserResource::make($user);
    }

    public function update (UpdateUserRequest $request, string $userId): UserResource {
        $user = $this->service->update($request->validated(), $userId);

        return UserResource::make($user);
    }

    /**
     * Handle destroy user request.
     *
     * @param string $userId
     * @throws \App\Exceptions\Users\UserNotFoundException
     */
    public function destroy (string $userId): void {
        $this->service->delete($userId);
    }
}
