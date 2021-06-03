<?php

namespace Tests;

use App\Models\User;

trait HasDummyUser {
    public function createDummyUser (array $attributes = []) {
        return factory(User::class)->create($attributes);
    }

    public function createDummyUsers (int $times) {
        return factory(User::class, $times)->create();
    }
}
