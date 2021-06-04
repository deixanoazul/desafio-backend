<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $user_id;
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        return TransactionResource::collection(Transaction::with('user')->where('user_id', $user_id)->paginate(5));
    }

    /**
     *  Store a transaction associating an user.
     *  
     *  @param \App\Http\Requests\TransactionStoreRequest $request;
     */
    function store(TransactionStoreRequest $request, $user_id)
    {
        try {
            $data = $request->validated();

            $data['user_id'] = $user_id;

            $transaction = Transaction::create($data);

            return new TransactionResource($transaction);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return ApiResponse::errorMessage($e->getMessage(), $e->getCode());
            } else {
                return ApiResponse::errorMessage('Houve um erro ao registrar esta operação. Contate a administração para investigar o problema.', 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $transaction_id)
    {
        try {
            $transaction = Transaction::where('user_id', $user_id)->where('id', $transaction_id)->first();

            if ($transaction == null) {
                return ApiResponse::errorMessage('Usuário ou transação não encontrada', 404);
            }

            $transaction->delete();

            return ApiResponse::successMessage('Essa operação foi deletada com sucesso!', 204);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return ApiResponse::errorMessage($e->getMessage(), $e->getCode());
            } else {
                return ApiResponse::errorMessage('Houve um erro ao deletar esta operação. Contate a administração para investigar o problema.', 500);
            }
        }
    }

    /**
     *  Sum all user transactions.
     * 
     *  @param  int  $id;
     *  @return \Illuminate\Http\Response
     */
    public function sumAllUserTransactions($id)
    {
        $result = DB::table('transactions')->where('user_id', $id)->selectRaw("
            SUM(CASE type WHEN 'credit' THEN amount WHEN 'chargeback' THEN amount WHEN 'debt' THEN amount * -1 END) as total"
        )->first();

        return response()->json(['data' => ['total' => $result->total]], 200);
    }
}
