<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\CreatingUserFailedException;
use App\Exceptions\DeleteException;
use App\Models\Transactions\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository extends AbstractRepository
{
    protected $model = User::class;

    protected  $wallet = Wallet::class;

    public function createUser($data)
    {
//        dd($data['cpf']);
        DB::beginTransaction();
        try {
            $data['password'] = bcrypt($data['password']);
            $user = $this->create($data);

            $user->wallet()->create();
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteUser(int $id)
    {
        $user = $this->model->find($id);

        $wallet = DB::table('wallets')
            ->where('user_id', $id)
            ->first();

//        dd($wallet->id);

        $transactions = DB::table('wallet_transactions')
            ->where('wallet_id','=', $wallet->id)
            ->first();
//        dd($transactions);
        if (!is_null($transactions)) {
            throw new DeleteException('Users with transactions cannot be deleted.', 422);
        }
        $user->delete();

        return true;
    }
}
