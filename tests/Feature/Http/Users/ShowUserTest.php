<?php

namespace Tests\Feature\Http\Users;

use Tests\TestCase;
use Tests\HasDummyUser;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShowUserTest extends TestCase {
    use DatabaseMigrations,
        HasDummyUser;

    /**
     * The dummy user.
     *
     * @var \App\Models\User
     */
    private $user;

    public function setUp (): void {
        parent::setUp();

        $this->user = $this->createDummyUser();
    }

    /**
     * Test if show user responds with 200 status code.
     */
    public function testShowUserRespondsWithOk () {
        $this->getJson("/api/users/{$this->user->id}")
            ->assertOk();
    }

    /**
     * Test if show user responds with attributes.
     */
    public function testShowUserRespondsWithAttributes () {
        $this->getJson("/api/users/{$this->user->id}")
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'cpf',
                    'email',
                    'birthdate',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
}
