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
        $this->getJson("/api/users/{$this->user->id}/transacted")
            ->assertOk();
    }

    /**
     * Test if user transacted responds total transacted by user.
     */
    public function testUserTransactedRespondsWithTotalTransactedByUser () {
        $transactions = $this->createDummyTransactionsTo(10, $this->user->id);

        $transacted = $transactions->sum('amount');

        $this->getJson("/api/users/{$this->user->id}/transacted")
            ->assertJsonPath('data.transacted', $transacted);
    }

    /**
     * Test if user transacted responds with updated value after transaction is created.
     */
    public function testUserTransactedRespondsWithUpdatedValueAfterTransactionIsCreated () {
        $payload = $this->getDummyTransactionPayloadWithAmount(1000);

        $this->getJson("/api/users/{$this->user->id}/transacted")
            ->assertJsonPath('data.transacted', 0);

        $this->postJson("/api/users/{$this->user->id}/transactions", $payload);

        $this->getJson("/api/users/{$this->user->id}/transacted")
            ->assertJsonPath('data.transacted', 1000);
    }

    /**
     * Test if user transacted responds with updated value after transaction is deleted.
     */
    public function testUserTransactedRespondsWithUpdatedValueAfterTransactionIsDeleted () {
        $payload = $this->getDummyTransactionPayloadWithAmount(1000);

        $transactionId = $this->postJson("/api/users/{$this->user->id}/transactions", $payload)
            ->json('data.id');

        $this->getJson("/api/users/{$this->user->id}/transacted")
            ->assertJsonPath('data.transacted', 1000);

        $this->deleteJson("/api/transactions/{$transactionId}");

        $this->getJson("/api/users/{$this->user->id}/transacted")
            ->assertJsonPath('data.transacted', 0);
    }

    /**
     * Test if user transacted responds with additional user info.
     */
    public function testUserTransactedRespondsWithAdditionalUserInfo () {
        $this->getJson("/api/users/{$this->user->id}/transacted")
            ->assertJsonStructure([
                'user'
            ]);
    }
}
