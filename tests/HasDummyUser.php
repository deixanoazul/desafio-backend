<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Collection;

trait HasDummyUser {
    /**
     * Create dummy user.
     *
     * @param array $attributes
     * @return \App\Models\User
     */
    public function createDummyUser (array $attributes = []): User {
        return factory(User::class)->create($attributes);
    }

    /**
     * Create dummy user without balance.
     *
     * @param array $attributes
     * @return \App\Models\User
     */
    public function createDummyUserWithoutBalance (array $attributes = []): User {
        return factory(User::class)
            ->state('without-balance')
            ->create($attributes);
    }

    /**
     * Create dummy users.
     *
     * @param int $times
     * @return \Illuminate\Support\Collection
     */
    public function createDummyUsers (int $times): Collection {
        return factory(User::class, $times)->create();
    }
}
