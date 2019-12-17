<?php

namespace App\GraphQL\Mutation;

use App\Task;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class DeleteTask extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteTask'
    ];

    public function type()
    {
        return Type::string();
    }

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int()
            ]
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'id' => ['required', 'integer'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'id.required' => 'Please provide the task id',
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        $task = Task::find($args['id']);

        if($task){
            $task->delete();

            return "success";
        }

        return "Task not found";
    }
}