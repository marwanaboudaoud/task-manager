<?php

namespace App\Mail;

use App\MeetingList;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddExistingUserToMeetingList extends Mailable
{
    use Queueable, SerializesModels;

    public $name;

    /**
     * Create a new message instance.
     *
     * @param MeetingList $meetingList
     */
    public function __construct(MeetingList $meetingList)
    {
        $this->name = $meetingList->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.addExistingUserToMeetingList');
    }
}
