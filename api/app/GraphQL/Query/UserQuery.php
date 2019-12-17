<?php

namespace App\GraphQL\Query;

use App\Src\services\JWTService\JWTService;

use App\User;

use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;


class UserQuery extends Query {

    protected $attributes = [
        'name'  => 'Users',
    ];

    public function type()
    {
        return GraphQL::type('user');
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        $jwtService = new JWTService();
        $token = $jwtService->getToken();
        $decryptToken = $jwtService->decryptToken($token);

        return User::find($decryptToken['sub']);
    }
}