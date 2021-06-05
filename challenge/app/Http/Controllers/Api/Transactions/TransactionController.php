<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Exceptions\PaymentDeniedException;
use App\Exceptions\TransactionDoesNotExistException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChargebackRequest;
use App\Http\Requests\TransactionRequest;
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
        if (!$request->checkAmountValidity($request->amount)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid amount'], 422);
        }
        $data = $request->only(['amount', 'action']);
        $data['wallet_id'] = $id;

        $data['amount'] = $this->changeCurrencyFormat($data['amount']);
        try {
            $result = $this->transaction->handle($data);

            return response()->json(
                    ['message' => $result['type'].' transaction performed successfully',
                        'data' => $result
                    ], 201);
        } catch (PaymentDeniedException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getTransactions($id)
    {
        $data = $this->transaction->handle($data = ['id' => $id]);

        return response()->json($data);
    }

    public function postChargeBack(ChargebackRequest $request)
    {
        $data = $request->only(['transaction_id', 'wallet_id', 'details']);
//        dd($data);
        $data['action'] = 3;

        try {
            $result = $this->transaction->handle($data);

            return response()->json(
                ['message' => 'Chargeback performed successfully',
                    'data' => $result
                ], 201);
        } catch (TransactionDoesNotExistException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }
    }

    public  function destroy($id)
    {
        try {
            $transaction = $this->transaction->findOrFail($id);

            $transaction->delete();
            return response()->json(['msg' => 'Transaction deleted successfully'], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }
    }

    private function changeCurrencyFormat($amount)
    {
        $amount = str_replace('.', '',$amount);
        $amount = str_replace(',', '.',$amount);

        return number_format($amount, 2, '.', '');
    }
}
