<?php

namespace App\GraphQL\Type;

use App\Src\services\JWTService\JWTService;
use App\Task;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class MyTaskType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'MyTask',
        'description'   => 'My tasks',
    ];

    public function fields()
    {
        return [
            'id' => [
                'type'          => Type::nonNull(Type::int()),
                'description'   => 'The id of the meeting list',
            ],
            'name' => [
                'type'          => Type::string(),
                'description'   => 'The name of the meeting list',
            ],
            'tasks' => [
                'type'          => Type::listOf(GraphQL::type('task')),
                'description'   => 'All my tasks'
            ]
        ];
    }

    public function resolveTasksField($root, $args)
    {
        $jwtService = new JWTService();
        $token = $jwtService->getToken();
        $decryptToken = $jwtService->decryptToken($token);

        return Task::select('tasks.*')
            ->join('categories', 'tasks.category_id', '=', 'categories.id')
            ->join('meeting_lists', 'categories.meeting_list_id', '=', 'meeting_lists.id')
            ->where('meeting_lists.id', $root->id)
            ->where('tasks.user_id', $decryptToken['sub'])
            ->get();
    }
}