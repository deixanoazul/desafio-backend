<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class NotFoundException extends Exception implements HttpExceptionInterface {
    public function getStatusCode (): int {
        return 404;
    }

    public function getHeaders (): array {
        return [];
    }
}
