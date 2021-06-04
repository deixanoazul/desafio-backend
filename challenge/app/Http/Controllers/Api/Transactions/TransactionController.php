<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Repositories\Contracts\TransactionRepositoryInterface;

class TransactionController extends Controller
{
    private $transaction;

    public function __construct(TransactionRepositoryInterface $transaction)
    {
        $this->transaction = $transaction;

    }

    public function postTransaction (TransactionRequest $request)
    {
        $transaction = $request->only(['wallet_id', 'amount', 'type']);

        try {

        } catch (\Exception $e){

        }
    }
}
