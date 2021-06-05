<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CreatingUserFailedException;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index ()
    {
        try {
            $users = $this->user->orderBy('created_at', 'desc')->paginate(1);

            return new UserCollection($users);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->all();

        try {
            $user = $this->user->createUser($data);
            $user = new UserResource($user);

            return response()->json([
                'data' => ['message' => 'User created successfully!', 'user' => $user]
            ], 201);

        } catch (CreatingUserFailedException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->user->findOrFail($id);

            $user = new UserResource($user);
            return response()->json(['data' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->all();

        //verifying if the password field has been set
        if ($request->has('password') && $request->get('password')) {
            //validating password
            Validator::make($data, [
                'password' => 'required|confirmed'
            ])->validate();

            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        try {
            $user = $this->user->findOrFail(Auth::user()->id);
            $user->update($data);

            $user = new UserResource($user);

            return response()->json(['data' => [
                'message' => 'User updated successfully!',
                'user' => $user]
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(): JsonResponse
    {
        try {
            $user = $this->user->findOrFail(Auth::user()->id);
            $user->delete();
            return response()->json(['msg' => 'User deleted successfully'], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }
    }
}
