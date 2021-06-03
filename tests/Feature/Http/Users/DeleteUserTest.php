<?php

namespace Tests\Feature\Http\Users;

use Tests\TestCase;
use Tests\HasDummyUser;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteUserTest extends TestCase {
    use DatabaseMigrations,
        HasDummyUser;

    /**
     * Test if delete user responds with 200 status code.
     */
    public function testDeleteUserRespondsWithOk () {
        $user = $this->createDummyUser();

        $this->deleteJson("/api/users/$user->id")->assertOk();
    }

    /**
     * Test if delete user responds with 404 status code.
     */
    public function testDeleteUserRespondsWithNotFound () {
        $this->deleteJson("/api/users/this-user-does-not-exists")->assertNotFound();
    }

    /**
     * Test if delete user can destroy row in database.
     */
    public function testDeleteUserCanDestroyRowInDatabase () {
        $user = $this->createDummyUser();

        $this->deleteJson("/api/users/$user->id");

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
