<?php


namespace App\Repositories\Eloquent;


use App\Models\Transactions\Wallet;
use App\Repositories\Contracts\TransactionRepositoryInterface;

class WalletRepository extends AbstractRepository
{
    protected $model = Wallet::class;

    public function handle($data)
    {
        if ($data['action'] = 1) {
            $this->runDebit($data);
        }
        if ($data['action'] = 2) {
            $this->runCredit($data);
        }
        if ($data['action'] = 3) {
            $this->runChargeback($data);
        }
    }

    private function runDebit($data)
    {
        $wallet = $this::findOrFail($data['wallet_id']);
        $currentBalance = $wallet->balance;
        $newBalance = $currentBalance - $data['amount'];

        dd($newBalance);
    }

    private function runCredit($data)
    {

    }

    private function runChargeback($data)
    {

    }
}
