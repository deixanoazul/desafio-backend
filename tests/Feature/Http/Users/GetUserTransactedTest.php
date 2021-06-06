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
     * Get dummy transaction payload with amount.
     *
     * @param int $amount
     * @return array
     */
    protected function getDummyTransactionPayloadWithAmount (int $amount): array {
        return [
            'amount' => $amount,
            'type' => 'debit',
        ];
    }

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
     * Test if user transacted responds with updated value after transaction is created.
     */
    public function testUserTransactedRespondsWithUpdatedValueAfterTransactionIsCreated () {
        $user = $this->createDummyUser();
        $payload = $this->getDummyTransactionPayloadWithAmount(1000);

        $this->getJson("/api/users/{$user->id}/transacted")
            ->assertJsonPath('data.transacted', 0);

        $this->postJson("/api/users/{$user->id}/transactions", $payload);

        $this->getJson("/api/users/{$user->id}/transacted")
            ->assertJsonPath('data.transacted', 1000);
    }

    /**
     * Test if user transacted responds with updated value after transaction is deleted.
     */
    public function testUserTransactedRespondsWithUpdatedValueAfterTransactionIsDeleted () {
        $user = $this->createDummyUser();
        $payload = $this->getDummyTransactionPayloadWithAmount(1000);

        $transactionId = $this->postJson("/api/users/{$user->id}/transactions", $payload)
            ->json('data.id');

        $this->getJson("/api/users/{$user->id}/transacted")
            ->assertJsonPath('data.transacted', 1000);

        $this->deleteJson("/api/transactions/{$transactionId}");

        $this->getJson("/api/users/{$user->id}/transacted")
            ->assertJsonPath('data.transacted', 0);
    }

    /**
     * Test if user transacted responds with additional user info.
     */
    public function testUserTransactedRespondsWithAdditionalUserInfo () {
        $user = $this->createDummyUser();

        $this->getJson("/api/users/{$user->id}/transacted")
            ->assertJsonStructure([
                'user'
            ]);
    }
}
