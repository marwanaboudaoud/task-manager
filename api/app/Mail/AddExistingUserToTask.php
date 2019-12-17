<?php

namespace App\Mail;

use App\Task;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddExistingUserToTask extends Mailable
{
    use Queueable, SerializesModels;

    public $taskName;
    public $userName;

    /**
     * Create a new message instance.
     *
     * AddExistingUserToTask constructor.
     * @param Task $task
     * @param User $user
     */
    public function __construct(Task $task, User $user)
    {
        $this->taskName = $task->title;
        $this->userName = $user->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.addExistingUserToTask');
    }
}
