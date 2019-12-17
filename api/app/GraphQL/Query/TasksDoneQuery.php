<?php

namespace App\GraphQL\Query;

use App\MeetingList;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class TasksDoneQuery extends Query{

    protected $attributes = [
        'name'  => 'Tasks',
    ];

    public function type()
    {
        return Type::int();
    }

    public function args()
    {
        return [
            'meeting_list_id'    => [
                'name' => 'meeting_list_id',
                'type' => Type::int(),
            ],
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'meeting_list_id' => ['required', 'integer'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'meeting_list_id.required' => 'Please enter the meeting id',
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        $tasks = MeetingList::find($args['meeting_list_id'])->categories
            ->sum(function ($category){
                return $category->tasks->sum('is_completed');
            });

        return $tasks;
    }

}