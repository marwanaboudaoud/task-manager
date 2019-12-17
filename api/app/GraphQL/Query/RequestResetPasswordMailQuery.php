<?php

namespace App\GraphQL\Query;

use App\Src\services\mailService\MailService;
use App\User;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class RequestResetPasswordMailQuery extends Query
{
    protected $attributes = [
        'name' => 'Password reset mail'
    ];


    public function type()
    {
        return GraphQL::type('user');
    }

    public function args()
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
            ],
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        try{
            $user = User::where('email', $args['email'])->firstOrFail();
        }catch (ModelNotFoundException $e){
            return $e;
        }

        $service = new MailService();

        return $service->sendRequestPasswordResetMail($user);
    }
}