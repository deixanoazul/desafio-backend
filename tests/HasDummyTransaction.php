<?php

namespace Tests;

use App\Models\Transaction;
use Illuminate\Support\Collection;

trait HasDummyTransaction {
    /**
     * Make dummy transaction.
     *
     * @return \App\Models\Transaction
     */
    public function makeDummyTransaction (): Transaction {
        return factory(Transaction::class)->make();
    }

    /**
     * Make dummy transactions.
     *
     * @param int $times
     * @return \Illuminate\Support\Collection
     */
    public function makeDummyTransactions (int $times): Collection {
        return factory(Transaction::class, $times)->make();
    }

    /**
     * Create dummy transaction to specified user id.
     *
     * @param string $userId
     * @return \App\Models\Transaction
     */
    public function createDummyTransactionTo (string $userId): Transaction {
        $transaction = $this->makeDummyTransaction();

        $transaction->user()->associate($userId)->save();

        return $transaction;
    }

    /**
     * Create dummy transactions to specified user id.
     *
     * @param string $userId
     * @param int $times
     * @return \Illuminate\Support\Collection
     */
    public function createDummyTransactionsTo (int $times, string $userId): Collection {
        return $this->makeDummyTransactions($times)
            ->each(function (Transaction $transaction) use ($userId) {
                $transaction->user()->associate($userId)->save();
            });
    }
}
