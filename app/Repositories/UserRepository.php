<?php

namespace App\Repositories;

use App\Models\User;
use App\Exceptions\Users\UserNotFoundException;

use Illuminate\Database\Eloquent\Collection;

class UserRepository {
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
     * Get all users sorted by creation date.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all (): Collection {
        return User::latest()->get();
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
     * Delete user by id.
     *
     * @param string $userId
     * @throws \App\Exceptions\Users\UserNotFoundException
     */
    public function delete (string $userId) {
        $deleted = User::where('id', $userId)->delete();

        if ($deleted === 0) {
            throw new UserNotFoundException();
        }
    }
}
