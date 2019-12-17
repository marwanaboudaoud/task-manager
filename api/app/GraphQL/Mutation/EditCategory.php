<?php

namespace App\GraphQL\Mutation;

use App\Category;
use App\MeetingList;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class EditCategory extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteTask'
    ];

    public function type()
    {
        return GraphQL::type('category');
    }

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int()
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::string()
            ]
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'id' => ['required', 'integer'],
            'name' => ['required', 'string'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'id.required' => 'Please provide the category id',
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        try{
            $category = Category::findOrFail($args['id']);
        }
        catch (ModelNotFoundException $e){
            abort(403, $e->getMessage());
        }

        $category->name = $args['name'];
        $category->slug = $category->meeting_list_id . '-' . strtolower(str_replace(' ', '-', $args['name']));

        if(Category::where('slug', $category->slug)->count() > 0){
            abort(403, 'Category already exists');
        }

        $category->save();

        return $category;
    }
}