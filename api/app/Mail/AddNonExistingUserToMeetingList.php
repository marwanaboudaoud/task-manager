<?php

namespace App\Mail;

use App\MeetingList;
use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddNonExistingUserToMeetingList extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $token;

    /**
     * Create a new message instance.
     *
     * @param MeetingList $meetingList
     * @param User $user
     */
    public function __construct(MeetingList $meetingList, User $user)
    {
        $this->name = $meetingList->name;

        $stdClass = new \stdClass();
        $stdClass->email = $user->email;
        $stdClass->meeting_id = $meetingList->id;

        $this->token = encrypt($stdClass);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.addNonExistingUserToMeetingList');
    }
}
