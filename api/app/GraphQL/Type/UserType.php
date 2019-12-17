<?php

namespace App\GraphQL\Type;


use App\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'User',
        'description'   => 'A user',
        'model'         => User::class
    ];

    public function fields()
    {
        return [
            'id' => [
                'type'          => Type::nonNull(Type::int()),
                'description'   => 'The id of the user',
            ],
            'first_name' => [
                'type'          => Type::string(),
                'description'   => 'The first name of the user',
            ],
            'last_name' => [
                'type'          => Type::string(),
                'description'   => 'The last name of the user',
            ],
            'email' => [
                'type'          => Type::string(),
                'description'   => 'The email of the user',
            ],
            'meetingLists' => [
                'type'          => Type::listOf(GraphQL::type('meetingList')),
                'description'   => 'List of all the meeting the user attends',
            ],
            'meetingList' => [
                'type'          => Type::listOf(GraphQL::type('meetingList')),
                'description'   => 'List of all the meeting the user created',
            ],
            'tasks' => [
                'type'          => Type::listOf(GraphQL::type('task')),
                'description'   => 'List of all the tasks the user is assigned to',
            ],
            'note' => [
                'type'          => GraphQL::type('note'),
                'description'   => 'The note of the user',
            ],
        ];
    }
}