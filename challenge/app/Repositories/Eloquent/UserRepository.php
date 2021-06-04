<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\CreatingUserFailedException;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends AbstractRepository
{
    protected $model = User::class;

    /**
     * @throws CreatingUserFailedException
     * @throws \Exception
     */
    public function createUser($data)
    {
//        dd($data['cpf']);
        DB::beginTransaction();
        try {
            $user = $this->create($data);

            $user->wallet()->create();
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
//            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
//            throw new CreatingUserFailedException('Could not create this user', 422);
        }
    }
}
