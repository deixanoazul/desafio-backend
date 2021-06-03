<?php

namespace Tests\Feature\Http\Auth;

use Tests\TestCase;
use Tests\HasDummyUser;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class SignInTest extends TestCase {
    use DatabaseMigrations,
        HasDummyUser;

    /**
     * The dummy email.
     *
     * @var string
     */
    private $email;

    /**
     * The dummy password.
     * @var string
     */
    private $password;

    public function setUp (): void {
        parent::setUp();

        $this->email = 'foo@bar.org';
        $this->password = 'secret123';
    }

    /**
     * Test if sign in responds with 200 status code if user exists.
     */
    public function testSignInRespondsWithOk () {
        $this->createDummyUser([
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $response = $this->postJson('/api/sign-in', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $response->assertOk();
    }

    /**
     * Test if sign in responds with 401 status code if user doesn't exist.
     */
    public function testSignInRespondsWithUnauthorized () {
        $response = $this->postJson('/api/sign-in', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $response->assertUnauthorized();
    }

    /**
     * Test if sign in authenticates a user with valid credentials.
     */
    public function testSignInAuthenticates () {
        $user = $this->createDummyUser([
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $this->postJson('/api/sign-in', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $this->assertAuthenticatedAs($user);
    }
}
