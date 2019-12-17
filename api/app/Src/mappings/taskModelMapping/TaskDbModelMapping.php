<?php

namespace App\Src\mappings\taskModelMapping;

use App\Src\mappings\categoryModelMapping\CategoryDbModelMapping;
use App\Src\mappings\meetingListModelMapping\MeetingListDbModelMapping;
use App\Src\mappings\userDbModelMappings\UserDbModelMapping;
use App\Src\models\taskModel\TaskModel;
use App\Task;
use Carbon\Carbon;

class TaskDbModelMapping
{
    /**
     * @param Task $task
     * @return TaskModel
     */
    public static function toTaskModelMapping(Task $task)
    {
        $taskModel = new TaskModel();
        $taskModel->setId($task->id);
        $taskModel->setTitle($task->title);
        $taskModel->setDescription($task->description ?? null);
        if ($task->deadline){
            $deadline = new Carbon($task->deadline);
            $deadline->format("d-m-Y H:m:s");

            $taskModel->setDeadline($deadline);
        }
        $taskModel->setAssignee($task->assignee ? UserDbModelMapping::toUserModelMapping($task->assignee) : null);
        $taskModel->setCategory(CategoryDbModelMapping::toCategoryModelMapping($task->category));
        $taskModel->setMeeting(MeetingListDbModelMapping::toMeetingModelListMapping($task->meeting, UserDbModelMapping::toUserModelMapping($task->category->meeting->creator)));
        $taskModel->setIsCompleted($task->is_completed ?? false);

        $taskModel->setCreatedAt($task->created_at);
        $taskModel->setUpdatedAt($task->updated_at);

        return $taskModel;
    }
}