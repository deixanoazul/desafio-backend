<?php

namespace App\Http\Middleware;

use App\Api\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\{TokenExpiredException, TokenInvalidException};

class apiProtectedRoute extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $exception) {
            if ($exception instanceof TokenInvalidException){
                return response()->json(['data' => ['status' => 'O token de autorização é inválido!']], 401);
            }else if ($exception instanceof TokenExpiredException){
                return response()->json(['data' => ['status' => 'O token de autorização expirou.']], 401);
            }else{
                return response()->json(['data' => ['status' => 'O token de autorização não foi encontrado.']], 401);
            }
        }
        
        return $next($request);
    }
}