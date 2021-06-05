<?php

namespace App\Repositories;

use App\Models\User;
use App\Exceptions\Users\UserNotFoundException;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository {
    /**
     * The number of users per page.
     */
    const PER_PAGE = 15;

    /**
     * Create a user.
     *
     * @param array $attributes
     * @return \App\Models\User
     */
    public function create (array $attributes): User {
        return User::create($attributes);
    }

    /**
     * Get all users sorted by creation date with pagination.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all (): LengthAwarePaginator {
        return User::latest()
            ->paginate(UserRepository::PER_PAGE);
    }

    /**
     * Find user by id.
     *
     * @param string $userId
     * @return \App\Models\User
     */
    public function find (string $userId): User {
        return User::findOrFail($userId);
    }

    /**
     * Update user by id with specified attributes.
     *
     * @param array $attributes
     * @param string $userId
     * @return \App\Models\User
     */
    public function updateById (array $attributes, string $userId): User {
        $user = User::findOrFail($userId);

        $user->update($attributes);

        return $user;
    }

    /**
     * Delete user by id.
     *
     * @param string $userId
     * @throws \App\Exceptions\Users\UserNotFoundException
     */
    public function deleteById (string $userId): void {
        $deleted = User::where('id', $userId)->delete();

        if ($deleted === 0) {
            throw new UserNotFoundException();
        }
    }

    /**
     * Get user balance by id.
     *
     * @param string $userId
     * @return mixed
     */
    public function getBalanceById (string $userId) {
        return User::where('id', $userId)->value('balance');
    }
}
