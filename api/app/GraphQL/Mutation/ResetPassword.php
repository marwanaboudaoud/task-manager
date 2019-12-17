<?php

namespace App\GraphQL\Mutation;

use App\Src\models\authModel\AuthResetModel;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class ResetPassword extends Mutation
{

    protected $attributes = [
        'name' => 'ResetPassword',
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
                'type' => Type::string()
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string()
            ],
            'password_repeat' => [
                'name' => 'password_repeat',
                'type' => Type::string()
            ],
            'reset_token' => [
                'name' => 'reset_token',
                'type' => Type::string()
            ]
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'password_repeat' => ['required', 'string'],
            'reset_token' => ['required', 'string'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Please enter your password',
            'password_repeat.required' => 'Please enter your password a second time',
            'reset_token.required' => 'Please enter the reset token.',
        ];
    }

    public function resolve($root, $args)
    {
        $authModel = new AuthResetModel();
        $authModel->setEmail($args['email']);
        $authModel->setPassword($args['password']);
        $authModel->setPasswordRepeat($args['password_repeat']);
        $authModel->setResetToken($args['reset_token']);

        $check = $this->checkResetToken($authModel);

        if ($check instanceof \Throwable){
            return $check;
        }

        try{
            $user = User::where('email', $authModel->getEmail())->first();
            $user->password = Hash::make($authModel->getPassword());
            $user->update();
        }
        catch (\Exception $e){
            return $e;
        }

        return $user;
    }

    /**
     * @param AuthResetModel $authResetModel
     * @return bool|Exception
     */
    public function checkResetToken(AuthResetModel $authResetModel)
    {
        $token = DB::table('password_resets')
            ->where('email', '=', $authResetModel->getEmail())
            ->where('token', '=', $authResetModel->getResetToken())
            ->where('created_at', '>', Carbon::now()->subHours(1))
            ->first();

        try{
            if (!$token){
                throw new Exception('Deze link is verlopen of bestaat niet');
            }

            DB::table('password_resets')
                ->where('email', '=', $authResetModel->getEmail())
                ->where('token', $authResetModel->getResetToken())
                ->delete();

            return true;
        }
        catch (\Exception $e){
            return $e;
        }
    }
}