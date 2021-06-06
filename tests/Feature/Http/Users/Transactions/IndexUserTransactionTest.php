<?php

namespace Tests\Feature\Http\Users\Transactions;

use Tests\TestCase;
use Tests\HasDummyUser;
use Tests\HasDummyTransaction;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class IndexUserTransactionTest extends TestCase {
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
     * Test if index transactions responds with 200 status code.
     */
    public function testIndexUserTransactionsRespondsWithOk () {
        $this->getJson("/api/users/{$this->user->id}/transactions")
            ->assertOk();
    }

    /**
     * Test if index transactions responds with all transactions.
     */
    public function testIndexUserTransactionsRespondsWithAllTransactions () {
        $this->createDummyTransactionsTo(10, $this->user->id);

        $this->getJson("/api/users/{$this->user->id}/transactions")
            ->assertJsonCount(10, 'data');
    }

    /**
     * Test if index transactions responds with valid structure.
     */
    public function testIndexUserTransactionsRespondsWithValidStructure () {
        $this->createDummyTransactionsTo(10, $this->user->id);

        $this->getJson("/api/users/{$this->user->id}/transactions")
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'type',
                        'amount',
                        'user_id',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }

    /**
     * Test if index transactions responds with additional user info.
     */
    public function testIndexUserTransactionsRespondsWithAdditionalUserInfo () {
        $this->createDummyTransactionsTo(10, $this->user->id);

        $this->getJson("/api/users/{$this->user->id}/transactions")
            ->assertJsonStructure([
                'user'
            ]);
    }
}
