<?php

namespace App\Exceptions\Auth;

use App\Exceptions\UnauthenticatedException;

class InvalidCredentialsException extends UnauthenticatedException {
    public $message = "Invalid credentials";
}
