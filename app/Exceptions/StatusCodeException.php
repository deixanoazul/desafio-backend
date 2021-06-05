<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class StatusCodeException extends Exception implements HttpExceptionInterface {
    /**
     * The response status code.
     *
     * @var int
     */
    protected $statusCode;

    /**
     * The response headers.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * The exception message.
     *
     * @var string
     */
    protected $message;

    public function getHeaders (): array {
        return $this->headers;
    }

    public function getStatusCode (): int {
        return $this->statusCode;
    }
}
