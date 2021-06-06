<?php

namespace App\Exceptions;

class ForbiddenException extends StatusCodeException {
    /**
     * The response status code.
     *
     * @var int
     */
    protected $statusCode = 403;
}
