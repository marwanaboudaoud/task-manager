<?php

namespace App\GraphQL\Enum;

use Rebing\GraphQL\Support\Type as GraphQLType;

class TaskTypeEnum extends GraphQLType {

    protected $enumObject = true;

    protected $attributes = [
        'name' => 'TaskOrderEnum',
        'description' => 'How to order Tasks',
        'values' => [
            'TITLE' => 'title',
            'ASSIGNEE' => 'assignee',
            'DEADLINE' => 'deadline',
            'COMPLETE' => 'is_completed',
        ],
    ];
}