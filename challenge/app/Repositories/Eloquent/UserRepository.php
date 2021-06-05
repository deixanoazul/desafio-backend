<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\CreatingUserFailedException;
use App\Models\Transactions\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends AbstractRepository
{
    protected $model = User::class;

    protected  $wallet = Wallet::class;

    /**
     * @throws CreatingUserFailedException
     * @throws \Exception
     */
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
}
