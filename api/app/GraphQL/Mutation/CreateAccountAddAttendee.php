<?php

namespace App\GraphQL\Mutation;

use App\Note;
use App\Src\models\authModel\AuthModel;
use App\Src\services\mailService\MailService;

use App\User;
use App\MeetingList;

use Exception;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;

class CreateAccountAddAttendee extends Mutation
{
    protected $attributes =[
        'name' => 'CreateAccountAddAttendee',
    ];

    public function type()
    {
        return GraphQL::type('meetingList');
    }

    public function args()
    {
        return [
            'token' => [
                'name' => 'token',
                'type' => Type::string(),
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string()
            ],
            'first_name' => [
                'name' => 'first_name',
                'type' => Type::string()
            ],
            'last_name' => [
                'name' => 'last_name',
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
        $values = decrypt($args['token']);

        try{
            if ($args['email'] !== $values->email){
                throw new \Exception('Email not the same');
            }
        }
        catch (\Exception $e){
            return $e;
        }

        $authModel = new AuthModel();
        $authModel->setFirstName($args['first_name'] ?? '');
        $authModel->setLastName($args['last_name'] ?? '');
        $authModel->setEmail($args['email']);
        $authModel->setPassword($args['password']);
        $authModel->setPasswordRepeat($args['password_repeat']);

        $user = User::where('email', $authModel->getEmail())->first();

        try {
            if (!$user) {
                throw new Exception('user not found');
            }
        }
        catch (Exception $e){
            return $e;
        }

        try{
            $meetingList = MeetingList::findOrFail($values->meeting_id);
        }
        catch(ModelNotFoundException $e){
            return $e;
        }

        try {
            $user->first_name = $authModel->getFirstName();
            $user->last_name = $authModel->getLastName();
            $user->password = Hash::make($authModel->getPassword());
            $user->name = $authModel->getFullName();

            $user->save();
        }
        catch (Exception $e) {
            return $e;
        }

        $meetingList->attendees()->syncWithoutDetaching($user);

        $mailService = new MailService();

        return $mailService->sendAddExistingAttendeeMail($meetingList, $user);
    }
}