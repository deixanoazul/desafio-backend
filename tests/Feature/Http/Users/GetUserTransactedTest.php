<?php

namespace Http\Users;

use Tests\TestCase;
use Tests\HasDummyUser;
use Tests\HasDummyTransaction;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class GetUserTransactedTest extends TestCase {
    use DatabaseMigrations,
        HasDummyUser,
        HasDummyTransaction;

    /**
     * Test if user transacted responds with 200 status code.
     */
    public function testUserTransactedRespondsWithOk () {
        $user = $this->createDummyUser();

        $this->getJson("/api/users/$user->id/transacted")
            ->assertOk();
    }

    /**
     * Test if user transacted responds total transacted by user.
     */
    public function testUserTransactedRespondsWithTotalTransactedByUser () {
        $user = $this->createDummyUser();

        $transactions = $this->createDummyTransactionsTo(10, $user->id);

        $this->getJson("/api/users/$user->id/transacted")
            ->assertJson([
                'data' => [
                    'transacted' => $transactions->sum('amount'),
                ]
            ]);
    }

    /**
     * Test if user transacted responds with additional user info.
     */
    public function testUserTransactedRespondsWithAdditionalUserInfo () {
        $user = $this->createDummyUser();

        $this->getJson("/api/users/$user->id/transacted")
            ->assertJsonStructure([
                'user'
            ]);
    }
}
