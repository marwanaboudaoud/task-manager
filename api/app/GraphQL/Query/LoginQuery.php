<?php

namespace App\GraphQL\Query;

use App\Src\models\authModel\AuthModel;
use App\Src\repositories\userRepositories\UserDbRepository;
use App\Src\services\authService\AuthService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class LoginQuery extends Query
{

    protected $attributes = [
        'name'  => 'Login',
    ];

    public function type()
    {
        return GraphQL::type('auth');
    }

    public function args()
    {
        return [
            'email'    => [
                'name' => 'email',
                'type' => Type::string(),
            ],
            'password'    => [
                'name' => 'password',
                'type' => Type::string(),
            ],
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Please enter your password',
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        $authModel = new AuthModel();
        $authModel->setEmail($args['email']);
        $authModel->setPassword($args['password']);

        $service = new AuthService(
            new UserDbRepository()
        );

        $result = $service->login($authModel);

        if ($result instanceof \Throwable) {
            return $result;
        }

        return $result;
    }
}