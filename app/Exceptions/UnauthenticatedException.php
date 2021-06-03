<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class UnauthenticatedException extends Exception implements HttpExceptionInterface {
    public function getStatusCode (): int {
        return 401;
    }

    public function getHeaders (): array {
        return [];
    }
}
