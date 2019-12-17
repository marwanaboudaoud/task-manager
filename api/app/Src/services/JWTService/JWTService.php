<?php

namespace App\Src\services\JWTService;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Token;

class JWTService
{
    /**
     * @return mixed
     */
    public function getToken()
    {
        return JWTAuth::getToken();
    }

    /**
     * @param Token $token
     * @return mixed
     */
    public function decryptToken(Token $token)
    {
        return JWTAuth::getPayLoad($token)->toArray();
    }
}