<?php

namespace App\Http\Controllers\Auth;

use App\Services\AuthService;
use App\Http\Controllers\Controller;

class SignOutController extends Controller {
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
     * Handle the sign out request.
     */
    public function __invoke () {
        $this->service->signOut();
    }
}
