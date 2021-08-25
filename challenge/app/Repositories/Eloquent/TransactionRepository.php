<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\PaymentDeniedException;
use App\Exceptions\TransactionDoesNotExistException;
use App\Models\Transactions\Transaction;
use App\Models\Transactions\Wallet;
use Illuminate\Support\Facades\DB;

class TransactionRepository extends AbstractRepository
{
    protected $model = Transaction::class;

    protected $wallet = Wallet::class;

    /**
     * @throws PaymentDeniedException
     * @throws \Exception
     */
    public function handle(array $data)
    {
        if (!$this->userCanPayTheAmount($data)) {
            throw new PaymentDeniedException ('User does not have enough money for this transaction', 401);
        }

        if (isset($data['action']) && $data['action'] == 3) {
            if ($this->transactionDoesNotExist($data['transaction_id'])) {
                throw new TransactionDoesNotExistException('This debt transaction does not exist', 401);
            }
            return $this->doChargeback($data);
        }

        if (isset($data['id']) && !empty($data['id'])) {
            $transactions = $this->paginateById($data['id'], 5);

            $user = $this->getProfileOfWalletOwner($data['id']);

            return ['user' => $user, 'transactions' => $transactions];
        }
        return $this->makeTransaction($data);

    }

    /**
     * @throws \Exception
     */
    private function makeTransaction($data): array
    {
//        dd($data);
        $payload = [
            'wallet_id' => $data['wallet_id'],
            'amount' => $data['amount'],
            'action' => $data['action']
        ];
//        dd($payload['wallet_id']);

        DB::beginTransaction();
        try {
            if ($payload['action'] == 1) {
                $this->doDebit($payload);
            } elseif ($payload['action'] == 2) {
                $this->doCredit($payload);
            }
            DB::commit();

            $this->create($payload);

            return $this->setReturnData($payload);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }

    private function userCanPayTheAmount($data): bool
    {
        if (isset($data['action']) && $data['action'] == 1) {
            $wallet = $this->findWallet($data['wallet_id']);
            if ($wallet->balance < $data['amount']) {
                return false;
            }
            return true;
        }
        return true;
    }

    private function doDebit($payload)
    {
        $wallet = $this->findWallet($payload['wallet_id']);

        try {
            $newBalance = $wallet->balance - $payload['amount'];

            DB::table('wallets')
                ->where('id', '=', $wallet->id)
                ->update(['balance' => $newBalance]);

            return true;

        } catch (\Exception $e) {
            throw $e;
        }

    }

    private function doCredit(array $payload)
    {
        $wallet = $this->findWallet($payload['wallet_id']);

        try {
            $newBalance = $wallet->balance + $payload['amount'];

            DB::table('wallets')
                ->where('id', '=', $wallet->id)
                ->update(['balance' => $newBalance]);
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function doChargeback(array $payload)
    {
        try {
            $transaction = $this->find($payload['transaction_id']);

            $wallet = $this->findWallet($payload['wallet_id']);

            $newBalance = $wallet->balance + $transaction->amount;

            DB::table('wallets')
                ->where('id', '=', $wallet->id)
                ->update(['balance' => $newBalance]);

            $payload = [
                'wallet_id' => $wallet->id,
                'amount' => $transaction->amount,
                'action' => 3
            ];

            return $this->create($payload);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function setReturnData(array $payload): array
    {
        if ($payload['action'] == 1) {
            $type = 'Debit';
        } else {
            $type = 'Credit';
        }
        return [
            'wallet_id' => $payload['wallet_id'],
            'amount' => $payload['amount'],
            'action' => $payload['action'],
            'type' => $type
        ];
    }

    private function getProfileOfWalletOwner($id)
    {
        $wallet = DB::table('wallets')
            ->where('id', '=', $id)
            ->first();

        $user = DB::table('users')
            ->where('id', '=', $wallet->user_id)
            ->first();
        return $user;
    }

    private function transactionDoesNotExist($id): bool
    {
        $transaction = $this->find($id);

//        dd($transaction);

        if (!$transaction or $transaction->action != 'debit') {
            return true;
        }
        return false;
    }
}
