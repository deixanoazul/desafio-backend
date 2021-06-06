<?php

namespace App\Exceptions\Transactions;

use App\Exceptions\ForbiddenException;

class ForbiddenTransactionCreate extends ForbiddenException {
    /**
     * The exception message.
     *
     * @var string
     */
    protected $message = 'Forbidden to create this transaction';
}
