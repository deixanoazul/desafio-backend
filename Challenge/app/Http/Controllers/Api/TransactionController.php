<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

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
        return TransactionResource::collection(Transaction::where('user_id', $user_id)->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user_id;
     * @return \Illuminate\Http\Response
     */
    public function listTransactionsWithUserInformations($user_id)
    {
        return TransactionResource::collection(Transaction::with('user')->where('user_id', $user_id)->paginate(5));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
