<?php

namespace App\GraphQL\Type;

use App\Task;
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TaskType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Task',
        'description'   => 'task',
        'model'         => Task::class
    ];

    public function fields()
    {
        return [
            'id' => [
                'type'          => Type::nonNull(Type::int()),
                'description'   => 'The id of the task',
            ],
            'title' => [
                'type'          => Type::string(),
                'description'   => 'The title of the task',
            ],
            'description' => [
                'type'          => Type::string(),
                'description'   => 'The description of the task',
            ],
            'deadline' => [
                'type'          => Type::string(),
                'description'   => 'The deadline of the task',
            ],
            'assignee' => [
                'type'          => GraphQL::type('user'),
                'description'   => 'The assigned user for this task',
            ],
            'category' => [
                'type'          => GraphQL::type('category'),
                'description'   => 'The category of this task',
            ],
            'is_completed' => [
                'type'          => Type::boolean(),
                'description'   => 'Variable to check if the task is completed',
            ],
            'created_at' => [
                'type'          => Type::string(),
                'description'   => 'The created at timestamp of the task',
            ],
            'updated_at' => [
                'type'          => Type::string(),
                'description'   => 'The updated at timestamp of the task',
            ],
        ];
    }

    public function resolveDeadlineField($root, $args)
    {
        if (!$root->deadline){
            return null;
        }
        $deadline = new Carbon($root->deadline);

        return $deadline->format('d-m-Y H:i:s');
    }

    public function resolveCreatedAtField($root, $args)
    {
        return $root->created_at->format('d-m-Y H:i:s');
    }

    public function resolveUpdatedAtField($root, $args)
    {
        return $root->updated_at->format('d-m-Y H:i:s');
    }

    public function resolveTitleField($root, $args)
    {
        return decrypt($root->title);
    }

    public function resolveDescriptionField($root, $args)
    {
        return decrypt($root->description);
    }
}