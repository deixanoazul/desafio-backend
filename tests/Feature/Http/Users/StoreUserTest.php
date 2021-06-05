<?php

namespace Tests\Feature\Http\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StoreUserTest extends TestCase {
    use DatabaseMigrations;

    /**
     * The dummy attributes.
     *
     * @var string[]
     */
    private $payload;

    public function setUp (): void {
        parent::setUp();

        $this->payload = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.org',
            'cpf' => '000.000.000-00',
            'birthdate' => '01/01/1980',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ];
    }

    /**
     * Test if store user responds with 201 status code.
     */
    public function testStoreUserRespondsWithCreated () {
        $this->postJson('/api/users', $this->payload)
            ->assertCreated();
    }

    /**
     * Test if store user creates an user with attributes.
     */
    public function testStoreUserCreatesUserWithAttributes () {
        $this->postJson('/api/users', $this->payload);

        $this->assertDatabaseHas('users', [
            'name' => $this->payload['name'],
            'email' => $this->payload['email'],
            'cpf' => $this->payload['cpf'],
            'birthdate' => $this->payload['birthdate'],
        ]);
    }
}
