<?php

namespace Tests\Feature\Http\Users;

use Tests\TestCase;
use Tests\HasDummyUser;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class IndexUserTest extends TestCase {
    use DatabaseMigrations,
        HasDummyUser;

    /**
     * Test if index users responds with 200 status code.
     */
    public function testIndexUsersRespondsWithOk () {
        $this->getJson('/api/users')
            ->assertOk();
    }

    /**
     * Test if index users responds with all users.
     */
    public function testIndexUsersRespondsWithAllUsers () {
        $this->createDummyUsers(10);

        $this->getJson('/api/users')
            ->assertJsonCount(10, 'data');
    }

    /**
     * Test if index users responds with valid structure.
     */
    public function testIndexUsersRespondsWithValidStructure () {
        $this->createDummyUsers(10);

        $this->getJson('/api/users')
            ->assertJsonStructure([
                'data' => [
                   '*' => [
                       'name',
                       'cpf',
                       'email',
                       'birthdate',
                       'created_at',
                       'updated_at',
                   ],
                ],
            ]);
    }
}
