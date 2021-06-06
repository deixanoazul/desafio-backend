<?php

namespace Http\Users;

use Tests\TestCase;
use Tests\HasDummyUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateUserTest extends TestCase {
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

        $this->user = $this->actingAsDummyUser();
    }

    /**
     * Get dummy update payload.
     *
     * @return array
     */
    protected function getDummyUpdatePayload (): array {
        return [
            'name' => 'Richard Roe',
            'balance' => 1000,
        ];
    }

    /**
     * Test if update user responds with ok.
     */
    public function testUpdateUserRespondsWithOk () {
        $this->patchJson("/api/users/{$this->user->id}")
            ->assertOk();
    }

    /**
     * Test if update user responds with forbidden if try to update another user.
     */
    public function testUpdateUserRespondsWithForbiddenIfTryToUpdateAnotherUser () {
        $another = $this->createDummyUser();

        $this->patchJson("/api/users/{$another->id}")
            ->assertForbidden();
    }

    /**
     * Test if update user responds with updated attributes.
     */
    public function testUpdateUserRespondsWithUpdatedAttributes () {
        $payload = $this->getDummyUpdatePayload();

        $this->patchJson("/api/users/{$this->user->id}", $payload)
            ->assertJson([
                'data' => [
                    'name' => $payload['name'],
                    'balance' => $payload['balance'],
                ]
            ]);
    }
}
