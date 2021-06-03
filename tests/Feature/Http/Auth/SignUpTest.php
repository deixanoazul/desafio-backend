<?php

namespace Tests\Feature\Http\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SignUpTest extends TestCase {
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
     * Test if sign up responds with 201 status code.
     */
    public function testSignUpRespondsWithCreated () {
        $this->postJson('/api/sign-up', $this->payload)->assertCreated();
    }

    /**
     * Test if sign up creates an user with attributes.
     */
    public function testSignUpCreatesUserWithAttributes () {
        $this->postJson('/api/sign-up', $this->payload);

        $this->assertDatabaseHas('users', [
            'name' => $this->payload['name'],
            'email' => $this->payload['email'],
            'cpf' => $this->payload['cpf'],
            'birthdate' => $this->payload['birthdate'],
        ]);
    }
}
