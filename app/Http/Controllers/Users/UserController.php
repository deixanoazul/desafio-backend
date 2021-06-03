<?php

namespace App\Http\Controllers\Users;

use App\Services\UserService;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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

    public function index (): AnonymousResourceCollection {
        $users = $this->service->all();

        return UserResource::collection($users);
    }

    public function show (string $userId): UserResource {
        $user = $this->service->find($userId);

        return UserResource::make($user);
    }

    public function destroy (string $userId) {
        $this->service->delete($userId);
    }
}
