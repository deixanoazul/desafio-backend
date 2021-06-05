<?php

namespace App\Exceptions\Users;

use App\Exceptions\ForbiddenException;

class UserHasBalanceException extends ForbiddenException {
    /**
     * The exception message.
     *
     * @var string
     */
    protected $message = 'User has balance';
}
