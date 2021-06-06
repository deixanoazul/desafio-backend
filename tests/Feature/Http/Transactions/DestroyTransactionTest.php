<?php

namespace Tests\Feature\Http\Transactions;

use Tests\TestCase;
use Tests\HasDummyUser;
use Tests\HasDummyTransaction;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class DestroyTransactionTest extends TestCase {
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
     * Test if destroy transaction responds with 200 status code if it exists.
     */
    public function testDestroyTransactionRespondsWithOk () {
        $transaction = $this->createDummyTransactionTo($this->user->id);

        $this->deleteJson("/api/transactions/$transaction->id")
            ->assertOk();
    }

    /**
     * Test if destroy transaction responds with forbidden if try to destroy another user's transaction.
     */
    public function testDestroyTransactionRespondsWithForbidden () {
        $another = $this->createDummyUser();

        $transaction = $this->createDummyTransactionTo($another->id);

        $this->deleteJson("/api/transactions/$transaction->id")
            ->assertForbidden();
    }

    /**
     * test if destroy transaction removes it from database.
     */
    public function testDestroyTransactionRemovesItFromDatabase () {
        $transaction = $this->createDummyTransactionTo($this->user->id);

        $this->deleteJson("/api/transactions/$transaction->id");

        $this->assertDatabaseMissing('transactions', [
            'id' => $transaction->id,
        ]);
    }
}
