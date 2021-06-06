<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use App\Exceptions\Transactions\ForbiddenTransactionCreate;
use App\Exceptions\Transactions\ForbiddenTransactionDelete;

class TransactionService {
    /**
     * The auth service.
     *
     * @var \App\Services\AuthService
     */
    private $auth;

    /**
     * The transaction repository.
     *
     * @var \App\Repositories\TransactionRepository
     */
    private $repository;

    public function __construct (
        AuthService $auth,
        TransactionRepository $repository
    ) {
        $this->auth = $auth;
        $this->repository = $repository;
    }

    /**
     * Check if current user owns the specified transaction.
     *
     * @param string $transactionId
     * @return bool
     */
    private function doesCurrentUserOwnTransaction (string $transactionId): bool {
        return $this->auth->isCurrentUserId(
            $this->repository->getTransactionOwnerId($transactionId)
        );
    }

    /**
     * Assert transaction can be created.
     *
     * @throws \App\Exceptions\Transactions\ForbiddenTransactionCreate
     */
    private function assertCanCreate (string $userId): void {
        if (!$this->auth->isCurrentUserId($userId)) {
            throw new ForbiddenTransactionCreate();
        }
    }

    /**
     * Assert transaction can be deleted.
     *
     * @throws \App\Exceptions\Transactions\ForbiddenTransactionDelete
     */
    private function assertCanDelete (string $transactionId): void {
        if (!$this->doesCurrentUserOwnTransaction($transactionId)) {
            throw new ForbiddenTransactionDelete();
        }
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
        $this->assertCanCreate($userId);

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
     * @throws \App\Exceptions\Transactions\ForbiddenTransactionDelete
     */
    public function delete (string $transactionId) {
        $this->assertCanDelete($transactionId);

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
