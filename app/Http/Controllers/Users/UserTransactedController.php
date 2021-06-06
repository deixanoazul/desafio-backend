<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserTransactedResource;
use App\Services\TransactionService;
use App\Services\UserService;

class UserTransactedController extends Controller {
    /**
     * The user service.
     *
     * @var \App\Services\UserService
     */
    private $users;

    /**
     * The transaction service.
     *
     * @var \App\Services\TransactionService
     */
    private $transactions;

    public function __construct (
        UserService $users,
        TransactionService $transactions
    ) {
        $this->users = $users;
        $this->transactions = $transactions;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke (string $userId): UserTransactedResource {
        $user = $this->users->find($userId);
        $transacted = $this->transactions->getTotalTransactedByUserId($userId);

        return UserTransactedResource::make($transacted)
            ->additional([
                'user' => UserResource::make($user),
            ]);
    }
}
