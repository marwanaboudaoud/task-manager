<?php
namespace App\Src\repositories\taskRepositories;

use App\Src\models\taskModel\TaskModel;

interface ITaskRepository
{
    /**
     * @param int $id
     * @param array $fields
     * @return TaskModel
     */
    public function getById(int $id, array $fields = []);

    /**
     * @param TaskModel $taskModel
     * @return TaskModel
     */
    public function create(TaskModel $taskModel);

    /**
     * @param TaskModel $taskModel
     * @return TaskModel
     */
    public function edit(TaskModel $taskModel);

    /**
     * @param TaskModel $taskModel
     * @return mixed
     */
    public function checkTask(TaskModel $taskModel);
}