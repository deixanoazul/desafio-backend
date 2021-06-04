<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Exceptions\PaymentDeniedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
//use App\Repositories\Contracts\TransactionRepositoryInterface;
//use App\Repositories\Contracts\WalletRepositoryInterface;
use App\Repositories\Eloquent\TransactionRepository;
use App\Repositories\Eloquent\WalletRepository;

class TransactionController extends Controller
{
    private $transaction;
    private $wallet;

    public function __construct(TransactionRepository $transaction, WalletRepository $wallet)
    {
        $this->transaction = $transaction;
        $this->wallet = $wallet;

    }

    public function postTransaction (TransactionRequest $request, int $id)
    {
        $data = $request->only(['wallet_id', 'amount', 'action']);

        $data['amount'] = $this->changeCurrencyFormat($data['amount']);

        try {
            $result = $this->transaction->handle($data);

            return response()->json(
                    ['message' => 'Transaction ['.$result['action'].'] performed successfully',
                        'data' => $result
                    ], 201);
        } catch (PaymentDeniedException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    private function changeCurrencyFormat($amount)
    {
        $amount = str_replace('.', '',$amount);
        $amount = str_replace(',', '.',$amount);
//        dd($amount);
        return number_format($amount, 2, '.', '');
    }
}
