<?php

namespace App\GraphQL\Type;

use App\Category;
use App\MeetingList;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class MeetingListType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'MeetingList',
        'description'   => 'meeting list',
        'model'         => MeetingList::class
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
            'creator' => [
                'type'          => GraphQL::type('user'),
                'description'   => 'The creator of the meeting list',
            ],
            'categories' => [
                'args' => [
                    'orderType' => [
                        'type' => GraphQL::type('OrderTypeEnum')
                    ],
                ],
                'type'          => Type::listOf(GraphQL::type('category')),
                'description'   => 'The categories of a meeting list',
            ],
            'attendees' => [
                'type'          => Type::listOf(GraphQL::type('user')),
                'description'   => 'All the attendees',
            ],
        ];
    }

    public function resolveCategoriesField($root, $args)
    {
        return Category::select('*')->where('meeting_list_id', $root->id)->orderBy('order','ASC')->get();
    }
}