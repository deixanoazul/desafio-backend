<?php

namespace Tests\Feature\Http\Users\Transactions;

use Tests\TestCase;
use Tests\HasDummyUser;
use Tests\HasDummyTransaction;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class StoreUserTransactionTest extends TestCase {
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

        $this->user =  $this->createDummyUser();
    }

    /**
     * Test if store transaction responds with 201 status code.
     */
    public function testStoreUserTransactionRespondsWithCreated () {
        $this->actingAs($this->user);

        $transaction = $this->makeDummyTransaction()->toArray();

        $this->postJson("/api/users/{$this->user->id}/transactions", $transaction)
            ->assertCreated();
    }

    /**
     * Test if store transaction responds with valid structure.
     */
    public function testStoreUserTransactionRespondsWithValidStructure () {
        $this->actingAs($this->user);

        $transaction = $this->makeDummyTransaction()->toArray();

        $this->postJson("/api/users/{$this->user->id}/transactions", $transaction)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'type',
                    'amount',
                    'user_id',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }
}
