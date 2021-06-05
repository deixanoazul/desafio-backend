<?php

namespace Http\Transactions;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\HasDummyUser;
use Tests\HasDummyTransaction;

class ShowTransactionTest extends TestCase {
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

        $this->user = $this->createDummyUser();
    }

    /**
     * Test if show transaction responds with 200 status code.
     */
    public function testShowTransactionRespondsWithOk () {
        $transaction = $this->createDummyTransactionTo($this->user->id);

        $this->getJson("/api/transactions/{$transaction->id}")
            ->assertOk();
    }

    /**
     * Test if show transaction responds with valid structure.
     */
    public function testShowTransactionRespondsWithValidStructure () {
        $transaction = $this->createDummyTransactionTo($this->user->id);

        $this->getJson("/api/transactions/{$transaction->id}")
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'type',
                    'amount',
                    'user_id',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
}
