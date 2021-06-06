<?php

namespace App\Services;

use App\Exceptions\Auth\InvalidCredentialsException;

use Illuminate\Contracts\Auth\Factory as Auth;

class AuthService {
    /**
     * The auth factory.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    private $auth;

    public function __construct (Auth $auth) {
        $this->auth = $auth;
    }

    /**
     * Sign user into the application if credentials are valid.
     *
     * @throws \App\Exceptions\Auth\InvalidCredentialsException
     */
    public function signIn (array $credentials): ?string {
        $token = $this->auth->guard()->attempt($credentials);

        if ($token == null) {
            throw new InvalidCredentialsException();
        }

        return $token;
    }

    /**
     * Sign user out of the application.
     */
    public function signOut () {
        $this->auth->guard()->logout();
    }
}
