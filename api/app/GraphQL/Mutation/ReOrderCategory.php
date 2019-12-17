<?php

namespace App\GraphQL\Mutation;

use App\Category;
use App\MeetingList;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class ReOrderCategory extends Mutation
{
    protected $attributes = [
        'name' => 'ReOrderCategory'
    ];

    public function type()
    {
        return GraphQL::type('meetingList');
    }

    public function args()
    {
        return [
            'meeting_id' => [
                'name' => 'meeting_id',
                'type' => Type::int()
            ],
            'category_ids' => [
                'name' => 'category_ids',
                'type' => Type::string()
            ]
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'meeting_id' => ['required', 'integer'],
            'category_ids' => ['required', 'string'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'meeting_id.required' => 'Please provide the meeting id',
            'category_ids.required' => 'Please provide the category ids comma seperated',
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {

        $categories = explode(",",$args['category_ids']);

        for ($x = 0; $x < count($categories); $x++) {

            $category = Category::find($categories[$x]);

            $category->order = $x + 1;
            $category->save();
        }

        $meeting = MeetingList::find($args['meeting_id']);
        return $meeting;
    }
}