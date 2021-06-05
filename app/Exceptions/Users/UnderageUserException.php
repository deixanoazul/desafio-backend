<?php

namespace App\Exceptions\Users;

use App\Exceptions\BadRequestException;

class UnderageUserException extends BadRequestException {
    /**
     * The exception message.
     *
     * @var string
     */
    protected $message = 'Unable to create an underage user';
}
