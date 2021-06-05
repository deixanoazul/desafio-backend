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

        $this->user = $this->createDummyUser();
    }

    /**
     * Test if destroy transaction responds with 200 status code if it exists.
     */
    public function testDestroyTransactionRespondsWithOk () {
        $transaction = $this->createDummyTransactionTo($this->user->id);

        $response = $this->deleteJson("/api/transactions/$transaction->id");

        $response->dump();

        $response->assertOk();
    }

    /**
     * Test if destroy transaction responds with 404 status code if it does not exist.
     */
    public function testDestroyTransactionRespondsWithNotFound () {
        $response = $this->deleteJson("/api/transactions/transaction-doesnt-exist");

        $response->assertNotFound();
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
