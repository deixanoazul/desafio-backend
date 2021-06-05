<?php


namespace App\Repositories\Eloquent;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthRepository extends AbstractRepository
{
    protected $model = User::class;

    public function authenticate ($request): array
    {
//        dd($request['email']);
        try {
            $user = $this->model->where('email', $request['email'])->first();;
//            dd($user);

            if (! $user || ! Hash::check($request['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
            $token = $user->createToken($request['email'])->plainTextToken;

            return ['user' => $user, 'token' => $token];
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
