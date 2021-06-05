<?php

namespace Http\Transactions;

use App\Models\User;

use Tests\TestCase;
use Tests\HasDummyUser;
use Tests\HasDummyTransaction;

use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTransactionTest extends TestCase {
    use RefreshDatabase,
        HasDummyUser,
        HasDummyTransaction;

    protected function setUp (): void {
        parent::setUp();

        $this->createDummyUsers(5)->each(function (User $user) {
            $this->createDummyTransactionsTo(3, $user->id);
        });
    }

    /**
     * Test if index transaction responds with 200 status code.
     */
    public function testIndexTransactionRespondsWithOk () {
        $this->getJson('/api/transactions')
            ->assertOk();
    }

    /**
     * Test if index transaction responds with all transactions.
     */
    public function testIndexTransactionRespondsWithAllTransactions () {
        $this->getJson('/api/transactions')
            ->assertJsonCount(5 * 3, 'data');
    }

    /**
     * Test if index transaction responds with valid structure.
     */
    public function testIndexTransactionRespondsWithValidStructure () {
        $this->getJson('/api/transactions')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'type',
                        'amount',
                        'user_id',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }
}
