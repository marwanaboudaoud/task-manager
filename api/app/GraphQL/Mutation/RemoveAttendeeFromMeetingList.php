<?php

namespace App\GraphQL\Mutation;

use App\MeetingList;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;

class RemoveAttendeeFromMeetingList extends Mutation
{
    protected $attributes = [
        'name' => 'RemoveAttendeeFromMeetingList',
    ];

    public function type()
    {
        return GraphQL::type('meetingList');
    }

    public function args()
    {
        return [
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::int()
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
            'user_id' => ['required'],
        ];
    }

    public function validationErrorMessages($args = [])
    {
        return [
            'meeting_id.required' => 'Please enter the meeting id',
            'user_id.required' => 'Please enter the user id',
        ];
    }

    public function resolve($root, $args)
    {
        try{
            $meetingList = MeetingList::findOrFail($args['meeting_id']);
            $user = User::findOrFail($args['user_id']);
        }
        catch(ModelNotFoundException $e){
            return $e;
        }

        $attendees = $meetingList->attendees()->get();

        try{
            if (!$attendees->contains($user)) {
                throw new \Exception('User is not in this meeting');
            }

            if ($attendees->count() <= 1) {
                throw new \Exception('Meeting cannot be empty');
            }
        }
        catch(\Exception $e){
            return $e;
        }

        $meetingList->attendees()->detach($user);

        return $meetingList;
    }
}