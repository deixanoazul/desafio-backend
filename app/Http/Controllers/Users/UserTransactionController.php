<?php

namespace App\Http\Controllers\Users;

use App\Services\UserService;
use App\Services\TransactionService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\Transactions\StoreTransactionRequest;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserTransactionController extends Controller {
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
     * List all transactions of the user.
     * The user information will be appended.
     *
     * @param string $userId
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index (string $userId): ResourceCollection {
        $user = $this->users->find($userId);
        $transactions = $this->transactions->getByUserId($userId);

        return TransactionResource::collection($transactions)
            ->additional([
                'user' => UserResource::make($user),
            ]);
    }

    /**
     * Store a transaction to the user.
     *
     * @param \App\Http\Requests\Transactions\StoreTransactionRequest $request
     * @param string $userId
     * @return \App\Http\Resources\TransactionResource
     */
    public function store (StoreTransactionRequest $request, string $userId): TransactionResource {
        $attributes = $request->validated();
        $transaction = $this->transactions->create($attributes, $userId);

        return TransactionResource::make($transaction);
    }
}
