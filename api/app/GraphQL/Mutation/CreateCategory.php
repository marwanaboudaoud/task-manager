<?php

namespace App\GraphQL\Mutation;

use App\Category;
use App\MeetingList;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class CreateCategory extends Mutation
{
    protected $attributes = [
        'name' => 'CreateCategory',
    ];

    public function type()
    {
        return GraphQL::type('category');
    }

    public function args()
    {
        return [
            'name' => [
                'name' => 'name',
                'type' => Type::string()
            ],
            'meeting_list_id' => [
                'name' => 'meeting_list_id',
                'type' => Type::int()
            ],

        ];
    }

    public function rules(array $args = [])
    {
        return [
            'name' => ['required', 'string'],
            'meeting_list_id' => ['required', 'integer'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'name.required' => 'Please enter a category name',
            'meeting_list_id.required' => 'Please enter a meeting',
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        $meetingList = MeetingList::find($args['meeting_list_id']);

        $category = new Category();

        $category->name = $args['name'];
        $category->meetingList()->associate($meetingList);

        $slug = $meetingList->id . '-' . strtolower(str_replace(' ', '-', $args['name']));

        if(Category::where('slug', $slug)->count() > 0){
            abort(403, 'Category already exists');
        }

        $category->slug = $slug;

        $category->save();

        return $category;
    }
}
