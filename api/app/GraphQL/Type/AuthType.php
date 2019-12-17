<?php

namespace App\GraphQL\Type;

use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class AuthType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Auth',
        'description'   => 'Authentication type',
    ];

    public function fields()
    {
        return [
            'token' => [
                'type'          => Type::string(),
                'description'   => 'The token of the logged in user',
            ],
            'token_type' => [
                'type'          => Type::string(),
                'description'   => 'The token type',
            ],
            'expires_in' => [
                'type'          => Type::string(),
                'description'   => 'The expiration date/time of the token',
            ],
            'user' => [
                'type'          => GraphQL::type('user'),
                'description'   => 'The logged in user'
            ]
        ];
    }

    public function resolveExpiresInField($root, $args)
    {
        if (!$root->expires_in){
            return null;
        }

        $expiresIn = new Carbon($root->expires_in);

        return $expiresIn->format('d-m-Y H:i:s');
    }
}