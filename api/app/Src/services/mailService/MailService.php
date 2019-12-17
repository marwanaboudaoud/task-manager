<?php

namespace App\Src\services\mailService;

use App\Mail\AddExistingUserToMeetingList;
use App\Mail\AddExistingUserToTask;
use App\Mail\AddNonExistingUserToMeetingList;
use App\Mail\AddNonExistingUserToTask;
use App\Mail\PasswordReset;
use App\Mail\RegisterUser;

use App\MeetingList;
use App\Task;
use App\User;

use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * @param User $user
     * @return User
     */
    public function sendRequestPasswordResetMail(User $user)
    {
        $token = app('auth.password.broker')->createToken($user);
        Mail::to($user->email)->send(new PasswordReset($token));

        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function sendRegisterMail(User $user)
    {
        Mail::to($user->email)->send(new RegisterUser($user));

        return $user;
    }

    /**
     * @param MeetingList $meetingList
     * @param User $user
     * @return MeetingList
     */
    public function sendAddExistingAttendeeMail(MeetingList $meetingList, User $user)
    {
        Mail::to($user->email)->send(new AddExistingUserToMeetingList($meetingList));

        return $meetingList;
    }

    /**
     * @param MeetingList $meetingList
     * @param User $user
     * @return MeetingList
     */
    public function sendAddNonExistingAttendeeMail(MeetingList $meetingList, User $user)
    {
        Mail::to($user->email)->send(new AddNonExistingUserToMeetingList($meetingList, $user));

        return $meetingList;
    }

    /**
     * @param Task $task
     * @param User $user
     * @return Task
     */
    public function sendAddNonExistingAssigneeMail(Task $task, User $user)
    {
        Mail::to($user->email)->send(new AddNonExistingUserToTask($task, $user));

        return $task;
    }

    public function sendAddExistingAssigneeMail(Task $task, User $user)
    {
        Mail::to($user->email)->send(new AddExistingUserToTask($task, $user));

        return $task;
    }
}