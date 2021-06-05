<?php

namespace App\Exceptions\Users;

use App\Exceptions\NotFoundException;

class UserNotFoundException extends NotFoundException {
    /**
     * The exception message.
     *
     * @var string
     */
    protected $message = 'User not found!';
}
