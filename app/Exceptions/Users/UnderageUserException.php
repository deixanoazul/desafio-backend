<?php

namespace App\Exceptions\Users;

use App\Exceptions\ForbiddenException;

class UnderageUserException extends ForbiddenException {
    /**
     * The exception message.
     *
     * @var string
     */
    protected $message = 'Unable to create an underage user';
}
