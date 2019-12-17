<?php

namespace App\GraphQL\Enum;

use Rebing\GraphQL\Support\Type as GraphQLType;

class OrderTypeEnum extends GraphQLType {
    protected $enumObject = true;

    protected $attributes = [
        'name' => 'OrderTypeEnum',
        'description' => 'How to Order',
        'values' => [
            'ASC' => 'asc',
            'DESC' => 'desc',
        ],
    ];
}