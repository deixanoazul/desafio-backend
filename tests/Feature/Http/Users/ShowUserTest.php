<?php

namespace Tests\Feature\Http\Users;

use Tests\TestCase;
use Tests\HasDummyUser;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShowUserTest extends TestCase {
    use DatabaseMigrations,
        HasDummyUser;

    private $user;

    public function setUp (): void {
        parent::setUp();

        $this->user = $this->createDummyUser();
    }

    public function testShowUserRespondsWithOk () {
        $this->getJson("/api/users/{$this->user->id}")->assertOk();
    }

    public function testShowUserRespondsWithValidStructure () {
        $this->getJson("/api/users/{$this->user->id}")->assertJsonStructure([
            'data' => [
                'name',
                'cpf',
                'email',
                'birthdate',
            ]
        ]);
    }
}
