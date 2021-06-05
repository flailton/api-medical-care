<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\{TokenExpiredException, TokenInvalidException, JWTException};

class JWTAuthorizationRoute extends BaseMiddleware
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
        } catch (TokenInvalidException | TokenExpiredException | JWTException | Exception $ex) {
            switch ($ex) {
                case $ex instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException:
                    return response()->json(['errors' => ['O Token informado está inválido']], 401);
                case $ex instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException:
                    return response()->json(['errors' => ['O Token está expirado']], 401);
                case $ex instanceof \Tymon\JWTAuth\Exceptions\JWTException:
                    return response()->json(['errors' => ['O token não foi identificado!']], 401);
                default:
                    return response()->json(['errors' => ['O Token não foi informado']], 401);
            }
        }

        return $next($request);
    }
}
