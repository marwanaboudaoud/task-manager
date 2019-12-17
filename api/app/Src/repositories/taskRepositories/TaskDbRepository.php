<?php

namespace App\Src\repositories\taskRepositories;

use App\Category;
use App\MeetingList;
use App\Src\mappings\categoryModelMapping\CategoryModelMapping;
use App\Src\mappings\meetingListModelMapping\MeetingListModelMapping;
use App\Src\mappings\taskModelMapping\TaskDbModelMapping;
use App\Src\mappings\taskModelMapping\TaskModelMapping;
use App\Src\mappings\userModelMapping\UserModelMapping;
use App\Src\models\taskModel\TaskModel;
use App\Task;
use App\User;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class TaskDbRepository implements ITaskRepository
{
    /**
     * @param int $id
     * @param array $fields
     * @return TaskModel|\Exception
     */
    public function getById(int $id, array $fields = [])
    {
        $task = Task::where('id', $id)->first();

        try{
            if (!isset($task)) {
                throw new \Exception('Task not found');
            }
        }
        catch(\Exception $e){
            return $e;
        }

        return TaskDbModelMapping::toTaskModelMapping($task);
    }

    /**
     * @param TaskModel $taskModel
     * @return TaskModel|\Exception
     */
    public function create(TaskModel $taskModel)
    {
        try{
            $task = new Task();
            $task->title = $taskModel->getTitle();
            $task->description = $taskModel->getDescription() ?? null;
            if ($taskModel->getDeadline()){
                $task->deadline = new Carbon($taskModel->getDeadline());
            }
            $task->assignee()->associate($taskModel->getAssignee() ? UserModelMapping::toUserDBMapping($taskModel->getAssignee()) : null);
            $task->category()->associate(CategoryModelMapping::toCategoryDbModelMapping($taskModel->getCategory()));
            $task->meeting()->associate(MeetingListModelMapping::toMeetingListDbModelMapping($taskModel->getMeeting()));

            $task->save();
        }
        catch (\Exception $e){
            return $e;
        }

        return TaskDbModelMapping::toTaskModelMapping($task);
    }

    /**
     * @param TaskModel $taskModel
     * @return TaskModel|\Throwable
     */
    public function edit(TaskModel $taskModel)
    {
        $task = $this->checkTask($taskModel);

        if($task instanceof \Throwable){
            return $task;
        }

        if ($taskModel->getTitle()){
            $task->title = $taskModel->getTitle();
        }
        if ($taskModel->getDescription()){
            $task->description = $taskModel->getDescription();
        }
        if ($taskModel->getDeadline()){
            $task->deadline = new Carbon($taskModel->getDeadline());
        }
        if ($taskModel->getAssignee()){
            $task->assignee()->associate(UserModelMapping::toUserDBMapping($taskModel->getAssignee()));
        }
        if ($taskModel->getCategory()){
            $task->category()->associate(CategoryModelMapping::toCategoryDbModelMapping($taskModel->getCategory()));
        }
        if ($taskModel->isCompleted()){
            $task->is_completed = $taskModel->isCompleted();
        }

        $task->save();

        return TaskDbModelMapping::toTaskModelMapping($task);
    }

    /**
     * @param TaskModel $taskModel
     * @return \Throwable|Task
     */
    public function checkTask(TaskModel $taskModel)
    {
        try{
            $task = Task::findOrFail($taskModel->getId());
        }
        catch(ModelNotFoundException $e){
            return $e;
        }

        try{
            if ($task->meeting()->first()->id !== $taskModel->getMeeting()->getId()){
                throw new \Exception('Meeting list id/task id combination not valid');
            }
        }
        catch(\Exception $e){
            return $e;
        }

        try{
            $categoryId = $taskModel->getCategory()->getId();

            $check = $task->meeting()->whereHas('categories', function ($query) use($categoryId) {
                $query->where('id', '=', $categoryId);
            })->first();

            if(!$check instanceof MeetingList){
                throw new \Exception('Invalid category id');
            }
        }
        catch(\Exception $e){
            return $e;
        }

        return $task;

    }
}