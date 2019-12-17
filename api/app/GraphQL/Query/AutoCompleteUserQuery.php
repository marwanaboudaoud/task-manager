<?php

namespace App\GraphQL\Query;

use App\Src\mappings\userModelMapping\UserModelMapping;
use App\Src\repositories\userRepositories\UserDbRepository;
use App\Src\services\userServices\UserService;

use App\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

use Rebing\GraphQL\Support\SelectFields;


class AutoCompleteUserQuery extends Query {

    protected $attributes = [
        'name'  => 'Users',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('user'));
    }

    public function args()
    {
        return [
            'q' => [
                'name' => 'q',
                'type' => Type::string(),
            ],
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'q' => ['required', 'string'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'q.required' => 'Please enter a name/email',
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {

        $string = $args['q'];

        return User::where('first_name', 'LIKE', '%' . $string . '%')
            ->orWhere('last_name', 'LIKE', '%' . $string . '%')
            ->orWhere('email', 'LIKE', '%' . $string . '%')
            ->get();
    }
}