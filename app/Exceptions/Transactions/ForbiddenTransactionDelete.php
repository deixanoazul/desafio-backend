<?php

namespace App\Exceptions\Transactions;

use App\Exceptions\ForbiddenException;

class ForbiddenTransactionDelete extends ForbiddenException {
    /**
     * The exception message.
     *
     * @var string
     */
    protected $message = 'Forbidden to delete this transaction';
}
