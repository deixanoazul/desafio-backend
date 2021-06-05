<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Exceptions\Users\UnderageUserException;

use Illuminate\Support\Carbon;

class UserService {
    /**
     * The minimum age allowed to create an user.
     */
    const MINIMUM_AGE = 21;

    /**
     * The user repository.
     *
     * @var \App\Repositories\UserRepository
     */
    private $repository;

    public function __construct (UserRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Check if user is underage by its birthdate.
     *
     * @param string $birthdate
     * @return mixed
     */
    protected function isUnderage (string $birthdate): bool {
        $birthdate = Carbon::parse($birthdate);

        return $birthdate->age < UserService::MINIMUM_AGE;
    }

    /**
     * Assert can create user with specified attributes.
     *
     * @throws \App\Exceptions\Users\UnderageUserException
     */
    protected function assertCanCreate (array $attributes) {
        $birthdate = $attributes['birthdate'];

        if ($this->isUnderage($birthdate)) {
            throw new UnderageUserException();
        }
    }

    /**
     * Create a user.
     *
     * @param string[] $attributes
     * @throws \App\Exceptions\Users\UnderageUserException
     */
    public function create (array $attributes) {
        $this->assertCanCreate($attributes);

        return $this->repository->create($attributes);
    }

    /**
     * Get all users.
     */
    public function all () {
        return $this->repository->all();
    }

    /**
     * Find user by id.
     *
     * @param string $userId
     */
    public function find (string $userId) {
        return $this->repository->find($userId);
    }

    /**
     * Delete user by id.
     *
     * @param string $userId
     * @throws \App\Exceptions\Users\UserNotFoundException
     */
    public function delete (string $userId): void {
        $this->repository->deleteById($userId);
    }
}
