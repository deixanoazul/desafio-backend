<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Exceptions\Transactions\TransactionNotFoundException;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransactionRepository {
    /**
     * The number of transactions per page.
     */
    const PER_PAGE = 15;

    /**
     * Get all transactions with pagination.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all () {
        return Transaction::paginate(TransactionRepository::PER_PAGE);
    }

    /**
     * Get all transactions by user id with pagination.
     *
     * @param string $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getByUserId (string $userId): LengthAwarePaginator {
        return Transaction::where('user_id', $userId)
            ->paginate(TransactionRepository::PER_PAGE);
    }

    /**
     * Create a transaction associating to user id.
     *
     * @param array $attributes
     * @param string $userId
     * @return \App\Models\Transaction
     */
    public function create (array $attributes, string $userId): Transaction {
        $transaction = Transaction::make($attributes);

        $transaction->user()->associate($userId)->save();

        return $transaction;
    }

    /**
     * Get a transaction by id.
     *
     * @param string $transactionId
     * @return \App\Models\Transaction
     */
    public function find (string $transactionId): Transaction {
        return Transaction::findOrFail($transactionId);
    }

    /**
     * Delete a transaction by id.
     *
     * @throws \App\Exceptions\Transactions\TransactionNotFoundException
     */
    public function deleteById (string $transactionId) {
        $deleted = Transaction::where('id', $transactionId)->delete();

        if ($deleted === 0) {
            throw new TransactionNotFoundException();
        }
    }

    /**
     * Check if exists transactions by user id.
     *
     * @param string $userId
     * @return bool
     */
    public function existsByUserId (string $userId): bool {
        return Transaction::where('user_id', $userId)->exists();
    }

    /**
     * Sum transaction amounts by user id.
     *
     * @param string $userId
     * @return int
     */
    public function sumAmountByUserId (string $userId): int {
        return Transaction::where('user_id', $userId)->sum('amount');
    }
}
