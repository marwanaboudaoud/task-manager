<?php

namespace App\GraphQL\Query;

use App\MeetingList;

use App\Src\services\JWTService\JWTService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

use Rebing\GraphQL\Support\SelectFields;


class MeetingListsQuery extends Query{

    protected $attributes = [
        'name'  => 'MeetingLists',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('meetingList'));
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        $jwtService = new JWTService();
        $token = $jwtService->getToken();
        $decryptToken = $jwtService->decryptToken($token);

        $userId = $decryptToken['sub'];

        $meetingList = MeetingList::where("creator_id", $userId)->orWhereHas('attendees', function($q) use($userId) {
            $q->where('id', $userId);
        })->get();

        return $meetingList;
    }
}