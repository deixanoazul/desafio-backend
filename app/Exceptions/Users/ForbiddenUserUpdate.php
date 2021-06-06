<?php

namespace App\Exceptions\Users;

use App\Exceptions\ForbiddenException;

class ForbiddenUserUpdate extends ForbiddenException {
    /**
     * The exception message.
     *
     * @var string
     */
    protected $message = 'Forbidden user update';
}
