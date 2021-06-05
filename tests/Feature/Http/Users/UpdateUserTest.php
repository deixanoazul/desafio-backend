<?php

namespace Http\Users;

use Tests\TestCase;
use Tests\HasDummyUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateUserTest extends TestCase {
    use DatabaseMigrations,
        HasDummyUser;

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
        $user = $this->createDummyUser();

        $this->patchJson("/api/users/{$user->id}")
            ->assertOk();
    }

    /**
     * Test if update user responds with updated attributes.
     */
    public function testUpdateUserRespondsWithUpdatedAttributes () {
        $user = $this->createDummyUser();

        $payload = $this->getDummyUpdatePayload();

        $this->patchJson("/api/users/{$user->id}", $payload)
            ->assertJson([
                'data' => [
                    'name' => $payload['name'],
                    'balance' => $payload['balance'],
                ]
            ]);
    }
}
