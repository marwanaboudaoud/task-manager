<?php

namespace App\GraphQL\Query;

use App\MeetingList;
use App\Src\services\JWTService\JWTService;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

use Rebing\GraphQL\Support\SelectFields;


class MyTasksQuery extends Query{

    protected $attributes = [
        'name'  => 'MyTasks',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('myTask'));
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        $jwtService = new JWTService();
        $token = $jwtService->getToken();
        $decryptToken = $jwtService->decryptToken($token);

        $meetingList = MeetingList::select('meeting_lists.*')
            ->join('categories', 'categories.meeting_list_id', '=', 'meeting_lists.id')
            ->join('tasks', 'tasks.category_id', '=', 'categories.id')
            ->where("tasks.user_id", $decryptToken['sub'])
            ->distinct()
            ->get();

        return $meetingList;
    }
}