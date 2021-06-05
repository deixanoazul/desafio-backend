<?php

namespace App\Services;

use App\Repositories\TransactionRepository;

class TransactionService {
    /**
     * The transaction repository.
     *
     * @var \App\Repositories\TransactionRepository
     */
    private $repository;

    public function __construct (TransactionRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Get all transactions.
     */
    public function all () {
        return $this->repository->all();
    }

    /**
     * Get all transactions by user id.
     *
     * @param string $userId
     */
    public function getByUserId (string $userId) {
        return $this->repository->getByUserId($userId);
    }

    /**
     * Create a transaction associating to user id.
     *
     * @param array $attributes
     * @param string $userId
     */
    public function create (array $attributes, string $userId) {
        return $this->repository->create($attributes, $userId);
    }

    /**
     * Get a transaction by id.
     *
     * @param string $transactionId
     * @return mixed
     */
    public function find (string $transactionId) {
        return $this->repository->find($transactionId);
    }

    /**
     * Delete a transaction.
     *
     * @param string $transactionId
     * @throws \App\Exceptions\Transactions\TransactionNotFoundException
     */
    public function delete (string $transactionId) {
        $this->repository->deleteById($transactionId);
    }

    /**
     * Get total transacted by user id.
     *
     * @param string $userId
     * @return int
     */
    public function getTotalTransactedByUserId (string $userId): int {
        return $this->repository->sumAmountByUserId($userId);
    }
}
