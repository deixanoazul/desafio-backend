<?php

namespace App\Exceptions\Users;

use App\Exceptions\ForbiddenException;

class UserHasTransactionException extends ForbiddenException {
    /**
     * The exception message.
     *
     * @var string
     */
    protected $message = 'User has transaction';
}
