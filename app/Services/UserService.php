<?php

namespace App\Services;

use App\Exceptions\Users\ForbiddenUserUpdate;
use App\Exceptions\Users\UserHasBalanceException;
use App\Exceptions\Users\UserHasTransactionException;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Exceptions\Users\UnderageUserException;

use Illuminate\Support\Carbon;

class UserService {
    /**
     * The minimum age allowed to create an user.
     */
    const MINIMUM_AGE = 21;


    /**
     * The auth service.
     *
     * @var \App\Services\AuthService
     */
    private $auth;

    /**
     * The user repository.
     *
     * @var \App\Repositories\UserRepository
     */
    private $users;

    /**
     * The transaction repository.
     *
     * @var
     */
    private $transactions;

    public function __construct (
        AuthService $auth,
        UserRepository $users,
        TransactionRepository $transactions
    ) {
        $this->auth = $auth;
        $this->users = $users;
        $this->transactions = $transactions;
    }

    /**
     * Check if user is underage by its birthdate.
     *
     * @param string $birthdate
     * @return mixed
     */
    private function isUnderage (string $birthdate): bool {
        $birthdate = Carbon::parse($birthdate);

        return $birthdate->age < UserService::MINIMUM_AGE;
    }

    /**
     * @throws \App\Exceptions\Users\UserHasBalanceException
     * @throws \App\Exceptions\Users\UserHasTransactionException
     */
    private function assertCanDelete (string $userId): void {
        if ($this->hasBalanceById($userId)) {
            throw new UserHasBalanceException();
        }

        if ($this->hasTransactionById($userId)) {
            throw new UserHasTransactionException();
        }
    }

    /**
     * Assert can create user with specified attributes.
     *
     * @throws \App\Exceptions\Users\UnderageUserException
     */
    private function assertCanCreate (array $attributes): void {
        $birthdate = $attributes['birthdate'];

        if ($this->isUnderage($birthdate)) {
            throw new UnderageUserException();
        }
    }

    /**
     * Assert can update user.
     *
     * @param string $userId
     * @throws \App\Exceptions\Users\ForbiddenUserUpdate
     */
    private function assertCanUpdate (string $userId): void {
        if (!$this->auth->isCurrentUserId($userId)) {
            throw new ForbiddenUserUpdate();
        }
    }

    /**
     * Check if user has balance.
     *
     * @param string $userId
     * @return bool
     */
    private function hasBalanceById (string $userId): bool {
        return $this->users->getBalanceById($userId) > 0;
    }

    private function hasTransactionById (string $userId): bool {
        return $this->transactions->existsByUserId($userId);
    }

    /**
     * Create a user.
     *
     * @param string[] $attributes
     * @throws \App\Exceptions\Users\UnderageUserException
     */
    public function create (array $attributes) {
        $this->assertCanCreate($attributes);

        return $this->users->create($attributes);
    }

    /**
     * Get all users.
     */
    public function all () {
        return $this->users->all();
    }

    /**
     * Find user by id.
     *
     * @param string $userId
     */
    public function find (string $userId) {
        return $this->users->find($userId);
    }

    /**
     * Update user by id.
     *
     * @param array $attributes
     * @param string $userId
     * @return mixed
     */
    public function update (array $attributes, string $userId) {
        $this->assertCanUpdate($userId);

        return $this->users->updateById($attributes, $userId);
    }

    /**
     * Delete user by id.
     *
     * @param string $userId
     * @throws \App\Exceptions\Users\UserHasBalanceException
     * @throws \App\Exceptions\Users\UserHasTransactionException
     */
    public function delete (string $userId): void {
        $this->assertCanDelete($userId);

        $this->users->deleteById($userId);
    }
}
