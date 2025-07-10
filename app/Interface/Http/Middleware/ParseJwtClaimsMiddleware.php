<?php

namespace App\Interface\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class ParseJwtClaimsMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $claims = JWTAuth::getPayload();
            $request->attributes->set('jwt_claims', $claims);

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid token'], 401);
        }
    }
}
