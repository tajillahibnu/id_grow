<?php

namespace App\Application\Auth\UseCase;

use Tymon\JWTAuth\Facades\JWTAuth;

class GetAuthenticatedUser
{
    public function execute()
    {
        return JWTAuth::parseToken()->authenticate();
    }
}
