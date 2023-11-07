<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Closure;
use JWTAuth; // JWTAuth ni ishlatishni unutmang
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTRoleAuth extends BaseMiddleware
{
    public function handle($request, Closure $next, $role = null)
    {
        try {
            $token_role = $this->auth->parseToken()->getClaim('role');
        } catch (JWTException $e) {
            return response()->json(['error' => 'unauthorized.'], 401);
        }
        if ($token_role != $role) {
            return response()->json(['error' => 'Permission denied'], 403);
        }
        return $next($request);
    }
}
