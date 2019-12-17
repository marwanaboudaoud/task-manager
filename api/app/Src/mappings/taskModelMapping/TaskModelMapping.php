<?php

namespace App\Src\mappings\taskModelMapping;


use App\Src\mappings\categoryModelMapping\CategoryModelMapping;
use App\Src\mappings\meetingListModelMapping\MeetingListModelMapping;
use App\Src\mappings\userModelMapping\UserModelMapping;
use App\Src\models\taskModel\TaskModel;
use App\Task;

class TaskModelMapping
{
    /**
     * @param TaskModel $taskModel
     * @return Task
     */
    public static function toTaskDbModelMapping(TaskModel $taskModel)
    {
        $task = new Task();
        $task->id = $taskModel->getId();
        $task->title = $taskModel->getTitle();
        $task->description = $taskModel->getDescription() ?? null;
        $task->deadline = $taskModel->getDeadline() ?? null;
        $task->assignee = $taskModel->getAssignee() ? UserModelMapping::toUserDBMapping($taskModel->getAssignee()) : null;
        $task->category = CategoryModelMapping::toCategoryDbModelMapping($taskModel->getCategory());
        $task->meeting = MeetingListModelMapping::toMeetingListDbModelMapping($taskModel->getMeeting());
        $task->is_completed = $taskModel->isCompleted();
        $task->created_at = $taskModel->getCreatedAt();
        $task->updated_at = $taskModel->getUpdatedAt();

        return $task;
    }
}