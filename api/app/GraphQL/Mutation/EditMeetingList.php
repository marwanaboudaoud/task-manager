<?php

namespace App\GraphQL\Mutation;

use App\MeetingList;
use App\Src\services\JWTService\JWTService;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class EditMeetingList extends Mutation
{
    protected $attributes = [
        'name' => 'EditMeetingList',
    ];

    public function type()
    {
        return GraphQL::type('meetingList');
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
            ],
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'id' => ['required','int'],
            'name' => ['string'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'id.required' => 'Please enter a ID',
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        $meetingList = MeetingList::find($args['id']);

        $meetingList->name = $args['name'] ?? $meetingList->name;
        $meetingList->save();

        return $meetingList;
    }
}