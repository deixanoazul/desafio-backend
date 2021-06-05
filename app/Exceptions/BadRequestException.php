<?php

namespace App\Exceptions;

class BadRequestException extends StatusCodeException {
    /**
     * The response status code.
     *
     * @var int
     */
    protected $statusCode = 400;
}
