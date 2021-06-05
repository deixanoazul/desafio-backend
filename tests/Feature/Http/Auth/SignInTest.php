<?php

namespace Tests\Feature\Http\Auth;

use Tests\TestCase;
use Tests\HasDummyUser;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class SignInTest extends TestCase {
    use DatabaseMigrations,
        HasDummyUser;

    /**
     * The dummy credentials.
     *
     * @var string
     */
    private $credentials;

    public function setUp (): void {
        parent::setUp();

        $this->credentials = [
            'email' => 'foo@bar.org',
            'password' => 'secret123',
        ];
    }

    /**
     * Test if sign in responds with 200 status code if user exists.
     */
    public function testSignInRespondsWithOk () {
        $this->createDummyUser($this->credentials);

        $this->postJson('/api/sign-in', $this->credentials)
            ->assertOk();
    }

    /**
     * Test if sign in responds with 401 status code if user doesn't exist.
     */
    public function testSignInRespondsWithUnauthorized () {
        $this->postJson('/api/sign-in', $this->credentials)
            ->assertUnauthorized();
    }

    /**
     * Test if sign in authenticates a user with valid credentials.
     */
    public function testSignInAuthenticates () {
        $user = $this->createDummyUser($this->credentials);

        $this->postJson('/api/sign-in', $this->credentials);

        $this->assertAuthenticatedAs($user);
    }
}
