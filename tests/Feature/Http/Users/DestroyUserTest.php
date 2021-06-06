<?php

namespace Tests\Feature\Http\Users;

use Tests\TestCase;
use App\Models\User;
use Tests\HasDummyUser;
use Tests\HasDummyTransaction;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class DestroyUserTest extends TestCase {
    use DatabaseMigrations,
        HasDummyUser,
        HasDummyTransaction;

    /**
     * Create a dummy user and make it current user.
     *
     * @param int $balance
     * @return \App\Models\User
     */
    protected function actingAsDummyUserWithBalance (int $balance): User {
        return $this->actingAsDummyUser([
            'balance' => $balance,
        ]);
    }

    /**
     * Create a dummy user without balance and make it current user.
     *
     * @return \App\Models\User
     */
    protected function actingAsDummyUserWithoutBalance (): User {
        return $this->actingAsDummyUserWithBalance(0);
    }

    /**
     * Test if destroy user responds with 200 status code.
     */
    public function testDestroyUserRespondsWithOk () {
        $user = $this->actingAsDummyUserWithoutBalance();

        $this->deleteJson("/api/users/{$user->id}")
            ->assertOk();
    }

    /**
     * Test if destroy user responds with forbidden if try to delete another user.
     */
    public function testDestroyUserRespondsWithForbiddenIfTryToDeleteAnotherUser () {
        $this->actingAsDummyUserWithoutBalance();

        $another = $this->createDummyUser();

        $this->deleteJson("/api/users/{$another->id}")
            ->assertForbidden();
    }

    /**
     * Test if destroy user removes it from database.
     */
    public function testDestroyUserRemovesItFromDatabase () {
        $user = $this->actingAsDummyUserWithoutBalance();

        $this->deleteJson("/api/users/{$user->id}");

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    /**
     * Test if destroy user responds with forbidden if user has transactions.
     */
    public function testDestroyUserRespondsWithForbiddenIfUserHasTransactions () {
        $user = $this->actingAsDummyUserWithoutBalance();

        $this->createDummyTransactionsTo(5, $user->id);

        $this->deleteJson("/api/users/$user->id")
            ->assertForbidden();
    }

    /**
     * Test if destroy user responds with forbidden if user has balance.
     */
    public function testDestroyUserRespondsWithForbiddenIfUserHasBalance () {
        $user = $this->actingAsDummyUserWithBalance(1000);

        $this->deleteJson("/api/users/$user->id")
            ->assertForbidden();
    }
}
