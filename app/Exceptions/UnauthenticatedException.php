<?php

namespace App\Exceptions;

class UnauthenticatedException extends StatusCodeException {
    /**
     * The response status code.
     *
     * @var int
     */
    protected $statusCode = 401;
}
