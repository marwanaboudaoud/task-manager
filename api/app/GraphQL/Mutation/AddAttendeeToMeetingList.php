<?php

namespace App\GraphQL\Mutation;

use App\MeetingList;
use App\Src\services\mailService\MailService;
use App\User;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class AddAttendeeToMeetingList extends Mutation
{

    protected $attributes = [
        'name' => 'AddAttendeeToMeetingList',
    ];

    public function type()
    {
        return GraphQL::type('meetingList');
    }

    public function args()
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::string()
            ],
            'meeting_id' => [
                'name' => 'meeting_id',
                'type' => Type::int()
            ],
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'meeting_id' => ['required'],
            'email' => ['required', 'email'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'meeting_id.required' => 'Please enter the meeting id',
            'email.required' => 'Please enter the email',
            'email.email' => 'Please enter a valid email',
        ];
    }

    public function resolve($root, $args)
    {
        try{
            $meetingList = MeetingList::findOrFail($args['meeting_id']);
        }
        catch(ModelNotFoundException $e){
            return $e;
        }

        $user = User::where('email', $args['email'])->first();

        $mailService = new MailService();
        
        if(!$user) {
            $user = new User();
            $user->email = $args['email'];
            $user->save();

            return $mailService->sendAddNonExistingAttendeeMail($meetingList, $user);
        }

        $meetingList->attendees()->syncWithoutDetaching($user);

        return $mailService->sendAddExistingAttendeeMail($meetingList, $user);
    }
}