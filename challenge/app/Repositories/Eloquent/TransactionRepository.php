<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\PaymentDeniedException;
use App\Models\Transactions\Transaction;
use App\Models\Transactions\Wallet;
use App\Repositories\Contracts\TransactionRepositoryInterface;

class TransactionRepository extends AbstractRepository
{
    protected $model = Transaction::class;

    private $wallet = Wallet::class;

    /**
     * @throws PaymentDeniedException
     */
    public function handle(array $data)
    {
        if (!$this->userCanPayTheAmount($data)) {
            throw new PaymentDeniedException ('User does not have enough money for this transaction', 401);
        }
        return $this->makeTransaction($data);
    }

    private function makeTransaction($data)
    {
        $payload = [
            'wallet_id' => $data['wallet_id'],
            'amount' => $data['amount'],
            'action' => $data['action']
        ];

        return $this::create($payload);
    }

    private function userCanPayTheAmount($data): bool
    {
        if ($data['action'] = 1) {
            $wallet = $this->wallet::findOrFail($data['wallet_id']);

            if ($wallet->balance < $data['amount']) {
                return false;
            }
            return true;
        }
        return true;
    }
}

