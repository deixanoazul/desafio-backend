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
     * Create dummy users.
     *
     * @param int $times
     * @return \Illuminate\Support\Collection
     */
    public function createDummyUsers (int $times): Collection {
        return factory(User::class, $times)->create();
    }

    /**
     * Create an dummy user and make it current user.
     *
     * @param array $attributes
     * @return \App\Models\User
     */
    protected function actingAsDummyUser (array $attributes = []): User {
        $user = $this->createDummyUser($attributes);

        $this->actingAs($user);

        return $user;
    }
}
