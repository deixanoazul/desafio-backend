<?php

namespace App\Repositories;

use App\Models\Transaction;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransactionRepository {
    /**
     * The cache time to live in seconds.
     */
    private const CACHE_TTL = 5;

    /**
     * The number of transactions per page.
     */
    private const PER_PAGE = 15;

    /**
     * Get user id from transaction.
     *
     * @param \App\Models\Transaction $transaction
     * @return string
     */
    private function getUserId (Transaction $transaction): string {
        return $transaction->user_id;
    }

    /**
     * Get cache time to live.
     *
     * @return int
     */
    private function getCacheTimeToLive (): int {
        return TransactionRepository::CACHE_TTL;
    }

    /**
     * Cache transaction query key.
     *
     * @param string $key
     * @param \Closure $callback
     * @return mixed
     */
    private function cache (string $key, Closure $callback) {
        return Cache::remember($key, $this->getCacheTimeToLive(), $callback);
    }

    /**
     * Forget cached transaction query.
     *
     * @param string $key
     */
    private function forget (string $key) {
        Cache::forget($key);
    }

    /**
     * Build sum amount by user id key.
     *
     * @param string $userId
     * @return string
     */
    private function buildSumAmountByUserIdKey (string $userId): string {
        return "users.{$userId}.transactions.amount";
    }

    /**
     * Forget sum amount by user id.
     *
     * @param string $userId
     */
    private function forgetSumAmountByUserId (string $userId) {
        $this->forget($this->buildSumAmountByUserIdKey($userId));
    }

    /**
     * Cache sum amount by user id.
     *
     * @param string $userId
     * @param \Closure $callback
     * @return mixed
     */
    private function cacheSumAmountByUserId (string $userId, Closure $callback) {
        return $this->cache($this->buildSumAmountByUserIdKey($userId), $callback);
    }

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

        $this->forgetSumAmountByUserId($userId);

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
     */
    public function deleteById (string $transactionId) {
        $transaction = Transaction::findOrFail($transactionId);

        $transaction->delete();

        $this->forgetSumAmountByUserId(
            $this->getUserId($transaction)
        );
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
     * Sum amount by user id without cache.
     *
     * @param string $userId
     * @return int
     */
    private function rawRumAmountByUserId (string $userId): int {
        return Transaction::where('user_id', $userId)->sum('amount');
    }

    /**
     * Sum amount by user id with cache.
     *
     * @param string $userId
     * @return int
     */
    public function sumAmountByUserId (string $userId): int {
        return $this->cacheSumAmountByUserId($userId, function () use ($userId) {
            return $this->rawRumAmountByUserId($userId);
        });
    }

    public function getTransactionOwnerId (string $transactionId): string {
        return Transaction::where('id', $transactionId)->value('user_id');
    }
}
