<?php

namespace App\Exceptions;

class NotFoundException extends StatusCodeException {
    /**
     * The response status code.
     *
     * @var int
     */
    protected $statusCode = 404;
}
