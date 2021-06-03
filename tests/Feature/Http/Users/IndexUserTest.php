<?php

namespace Tests\Feature\Http\Users;

use Tests\TestCase;
use Tests\HasDummyUser;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class IndexUserTest extends TestCase {
    use DatabaseMigrations,
        HasDummyUser;

    /**
     * Test if index users responds successfully.
     */
    public function testIndexUsersRespondsWithOk () {
        $response = $this->getJson('/api/users');

        $response->assertOk();
    }

    /**
     * Test if index users responds with all users.
     */
    public function testIndexUsersRespondsWithAllUsers () {
        $this->createDummyUsers(10);

        $response = $this->getJson('/api/users');

        $response->assertJsonCount(10, 'data');
    }

    /**
     * Test if index users responds with valid structure.
     */
    public function testIndexUsersRespondsWithValidStructure () {
        $this->createDummyUsers(3);

        $response = $this->getJson('/api/users');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'name',
                    'cpf',
                    'email',
                    'birthdate',
                ]
            ]
        ]);
    }
}
