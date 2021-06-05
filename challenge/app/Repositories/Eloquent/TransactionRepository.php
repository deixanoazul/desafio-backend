<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\PaymentDeniedException;
use App\Models\Transactions\Transaction;
use App\Models\Transactions\Wallet;
use Illuminate\Support\Facades\DB;

class TransactionRepository extends AbstractRepository
{
    protected $model = Transaction::class;

    protected $wallet = Wallet::class;

    /**
     * @throws PaymentDeniedException
     */
    public function handle(array $data)
    {
        if (!$this->userCanPayTheAmount($data)) {
            throw new PaymentDeniedException ('User does not have enough money for this transaction', 401);
        }

        if (isset($data['id']) && !empty($data['id'])) {
            $transactions = $this->listAllTransactionsFromAUser($data['id']);

            $user = $this->getProfileOfWalletOwner($data['id']);

            return ['user' => $user, 'transactions' => $transactions];
        }
        return $this->makeTransaction($data);

    }

    /**
     * @throws \Exception
     */
    private function makeTransaction($data)
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

    private function userCanPayTheAmount($data)
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

    private function listAllTransactionsFromAUser($id)
    {
        $transactions = DB::table('wallet_transactions')
            ->where('wallet_id', '=', $id)
            ->get();

        return $transactions;

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
}
