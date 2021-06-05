<?php

namespace Tests\Feature\Http\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StoreUserTest extends TestCase {
    use DatabaseMigrations;

    /**
     * Get dummy user payload.
     *
     * @return string[]
     */
    protected function getDummyUserPayload (): array {
        return [
            'name' => 'John Doe',
            'email' => 'johndoe@example.org',
            'cpf' => '000.000.000-00',
            'birthdate' => '1980-01-01',
            'balance' => 0,
            'password' => 'secret123',
        ];
    }

    /**
     * Get underage dummy user payload.
     *
     * @return string[]
     */
    protected function getUnderageDummyUserPayload (): array {
        return [
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.org',
            'cpf' => '000.000.000-00',
            'birthdate' => '2005-01-01',
            'balance' => 0,
            'password' => 'secret321',
        ];
    }

    /**
     * Test if store user responds with 201 status code.
     */
    public function testStoreUserRespondsWithCreated () {
        $this->postJson('/api/users', $this->getDummyUserPayload())
            ->assertCreated();
    }

    /**
     * Test if store user creates an user with attributes.
     */
    public function testStoreUserCreatesUserWithAttributes () {
        $payload = $this->getDummyUserPayload();

        $this->postJson('/api/users', $payload);

        $this->assertDatabaseHas('users', [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'cpf' => $payload['cpf'],
            'birthdate' => $payload['birthdate'],
            'balance' => $payload['balance'],
        ]);
    }

    /**
     * Test if store user responds with forbidden if user is underage.
     */
    public function testStoreUserRespondsWithForbiddenIfUserIsUnderage () {
        $this->postJson('/api/users', $this->getUnderageDummyUserPayload())
            ->assertForbidden();
    }
}
