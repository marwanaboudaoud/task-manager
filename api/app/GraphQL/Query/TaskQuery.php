<?php

namespace App\GraphQL\Query;

use App\Task;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

use Rebing\GraphQL\Support\SelectFields;

class TaskQuery extends Query{

    protected $attributes = [
        'name'  => 'Task',
    ];

    public function type()
    {
        return GraphQL::type('task');
    }

    public function args()
    {
        return [
            'id'    => [
                'name' => 'id',
                'type' => Type::int(),
            ],
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'id' => ['required'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'id.required' => 'Please enter the task id',
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        $task = Task::find($args['id']);
        return $task;
    }

}