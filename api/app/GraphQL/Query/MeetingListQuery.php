<?php

namespace App\GraphQL\Query;

use App\MeetingList;
use App\Src\mappings\meetingListModelMapping\MeetingListModelMapping;
use App\Src\repositories\meetingListRepositories\MeetingListDbRepository;
use App\Src\services\meetingListService\MeetingListService;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

use Rebing\GraphQL\Support\SelectFields;


class MeetingListQuery extends Query{

    protected $attributes = [
        'name'  => 'MeetingLists',
    ];

    public function type()
    {
        return GraphQL::type('meetingList');
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
            'id.required' => 'Please enter the meeting id',
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        return MeetingList::find($args['id']);
    }
}