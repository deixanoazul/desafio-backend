<?php

namespace App\Http\Controllers\Transactions;

use App\Services\TransactionService;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionController extends Controller {
    /**
     * @var \App\Services\TransactionService
     */
    private $service;

    public function __construct (TransactionService $service) {
        $this->service = $service;

        $this->middleware('auth')->only(['destroy']);
    }

    /**
     * Show all transactions.
     *
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index (): ResourceCollection {
        $transactions = $this->service->all();

        return TransactionResource::collection($transactions);
    }

    /**
     * Show a transaction by id.
     *
     * @param string $transactionId
     * @return \App\Http\Resources\TransactionResource
     */
    public function show (string $transactionId): TransactionResource {
        $transaction = $this->service->find($transactionId);

        return TransactionResource::make($transaction);
    }

    /**
     * Destroy a transaction by id.
     *
     * @param string $transactionId
     */
    public function destroy (string $transactionId) {
        $this->service->delete($transactionId);
    }
}
