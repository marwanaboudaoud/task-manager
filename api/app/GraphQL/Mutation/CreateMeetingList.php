<?php

namespace App\GraphQL\Mutation;

use App\Category;
use App\MeetingList;
use App\Src\services\JWTService\JWTService;
use App\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class CreateMeetingList extends Mutation
{
    protected $attributes = [
        'name' => 'CreateMeetingList',
    ];

    public function type()
    {
        return GraphQL::type('meetingList');
    }

    public function args()
    {
        return [
            'name' => [
                'name' => 'name',
                'type' => Type::string()
            ],
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'name.required' => 'Please enter a name',
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        $jwtService = new JWTService();

        $token = $jwtService->getToken();
        $decryptToken = $jwtService->decryptToken($token);
        $user = User::find($decryptToken['sub']);

        $meetingList = new MeetingList();
        $meetingList->name = $args['name'];
        $meetingList->creator()->associate($user);

        $meetingList->save();

        $categories = [
            "Prioriteiten",
            "Spreekpunten",
            "Overige"
        ];
        $order = 1;
        foreach ($categories as $categoryName){

            $category = new Category();
            $category->name = $categoryName;
            $category->order = $order;
            $category->slug = $meetingList->id . '-' . strtolower(str_replace(' ', '-', $categoryName));
            $category->meetingList()->associate($meetingList);
            $category->save();

            $order++;
        }



        return $meetingList;
    }
}