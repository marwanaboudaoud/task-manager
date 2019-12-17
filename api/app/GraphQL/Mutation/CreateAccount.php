<?php

namespace App\GraphQL\Mutation;

use App\Note;
use App\Src\models\authModel\AuthModel;
use App\Src\services\mailService\MailService;
use App\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class CreateAccount extends Mutation
{

    protected $attributes = [
        'name' => 'CreateUser',
    ];

    public function type()
    {
        return GraphQL::type('user');
    }

    public function args()
    {
        return [
            'first_name' => [
                'name' => 'first_name',
                'type' => Type::string()
            ],
            'last_name' => [
                'name' => 'last_name',
                'type' => Type::string()
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string()
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string()
            ],
            'password_repeat' => [
                'name' => 'password_repeat',
                'type' => Type::string()
            ]
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'first_name' => ['string'],
            'last_name' => ['string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'password_repeat' => ['required', 'string'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Please enter your password',
            'password_repeat.required' => 'Please enter your password a second time',
        ];
    }

    public function resolve($root, $args)
    {
        $authModel = new AuthModel();
        $authModel->setFirstName($args['first_name'] ?? '');
        $authModel->setLastName($args['last_name'] ?? '');
        $authModel->setEmail($args['email'] ?? '');
        $authModel->setPassword($args['password'] ?? '');
        $authModel->setPasswordRepeat($args['password_repeat'] ?? '');

        try {
            if (User::where('email', $authModel->getEmail())->first()) {
                throw new Exception('Email already taken');
            }
        }
        catch (Exception $e){
            return $e;
        }

        try{
            $user = new User();
            $user->first_name = $authModel->getFirstName();
            $user->last_name = $authModel->getLastName();
            $user->name = $authModel->getFullName();
            $user->email = $authModel->getEmail();
            $user->password = Hash::make($authModel->getPassword());

            $user->save();
        }
        catch (\Exception $e){
            return $e;
        }

        $mailingService = new MailService();
        $mailingService->sendRegisterMail($user);

        return $user;
    }
}