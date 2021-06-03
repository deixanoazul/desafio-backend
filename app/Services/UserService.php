<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService {
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
     * Create a user.
     *
     * @param string[] $attributes
     */
    public function create (array $attributes) {
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
     */
    public function delete (string $userId) {
        $this->repository->delete($userId);
    }
}
