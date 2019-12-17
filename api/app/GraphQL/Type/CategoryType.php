<?php

namespace App\GraphQL\Type;

use App\Category;
use App\Task;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CategoryType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Category',
        'description'   => 'Category type',
        'model'         => Category::class
    ];

    public function fields()
    {
        return [
            'id' => [
                'type'          => Type::string(),
                'description'   => 'The id of the category',
            ],
            'name' => [
                'type'          => Type::string(),
                'description'   => 'The name of the category',
            ],
            'slug' => [
                'type'          => Type::string(),
                'description'   => 'The slug of the category',
            ],
            'order' => [
                'type'          => Type::int(),
                'description'   => 'category order',
            ],
            'tasks' => [
                'args' => [
                    'orderBy' => [
                        'type' => GraphQL::type('TaskTypeEnum')
                    ],
                    'orderType' => [
                        'type' => GraphQL::type('OrderTypeEnum')
                    ],
                ],
                'type'          => Type::listOf(GraphQL::type('task')),
                'description'   => 'List of Tasks within the category',
            ],
            'meetingList' => [
                'type'          => GraphQL::type('meetingList'),
                'description'   => 'The meeting of this category',
            ]
        ];
    }

    public function resolveTasksField($root, $args)
    {
        if (isset($args['orderBy'])){
            $orderType = $args['orderType'] ?? 'ASC';

            return Task::select('*')->where('category_id', $root->id)->orderBy('is_completed', 'ASC')->orderBy($args['orderBy'], $orderType)->get();
        }

        return Task::select('*')->where('category_id', $root->id)->orderBy('is_completed', 'ASC')->orderBy('deadline', 'ASC')->orderBy('title', 'ASC')->get();
    }
}