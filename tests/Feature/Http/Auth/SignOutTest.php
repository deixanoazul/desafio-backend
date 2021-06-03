<?php

namespace Tests\Feature\Http\Auth;

use Tests\TestCase;
use Tests\HasDummyUser;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SignOutTest extends TestCase {
    use DatabaseMigrations,
        HasDummyUser;

    public function setUp (): void {
        parent::setUp();
        
        Auth::login($this->createDummyUser());
    }

    /**
     * Test if sign out responds with 200 status code.
     */
    public function testSignOutRespondsWithOk () {
        $this->postJson('/api/sign-out')->assertOk();
    }

    /**
     * Test if sign out invalidates authentication.
     */
    public function testSignOutInvalidatesAuthentication () {
        $this->assertAuthenticated();

        $this->postJson('/api/sign-out');

        $this->assertGuest();
    }
}
