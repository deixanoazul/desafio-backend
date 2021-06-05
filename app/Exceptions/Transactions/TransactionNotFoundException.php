<?php

namespace App\Exceptions\Transactions;

use App\Exceptions\NotFoundException;

class TransactionNotFoundException extends NotFoundException {
    /**
     * The exception message.
     *
     * @var string
     */
    protected $message = 'Transaction not found!';
}
