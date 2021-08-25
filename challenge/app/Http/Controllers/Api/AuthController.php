<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Repositories\Eloquent\AuthRepository;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @var AuthRepository
     */
    private $auth;

    public function __construct(AuthRepository $auth)
    {
        $this->auth = $auth;
    }

    public function postAuth(AuthRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $request->only(['email', 'password']);
            $result = $this->auth->authenticate($data);

            return response()->json(['status' => 'success', $result], 200);

        } catch (ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => 'Wrong credentials'], 401);
        }
    }
}
