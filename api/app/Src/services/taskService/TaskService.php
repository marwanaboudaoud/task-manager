<?php

namespace App\Src\services\taskService;


use App\Src\models\taskModel\TaskModel;
use App\Src\repositories\taskRepositories\ITaskRepository;

class TaskService
{
    /**
     * @var ITaskRepository
     */
    private $repo;

    public function __construct(ITaskRepository $repository)
    {
        $this->setRepo($repository);
    }

    /**
     * @param TaskModel $taskModel
     * @return TaskModel
     */
    public function create(TaskModel $taskModel)
    {
        return $this->getRepo()->create($taskModel);
    }

    /**
     * @param TaskModel $taskModel
     * @return TaskModel
     */
    public function edit(TaskModel $taskModel)
    {
        return $this->getRepo()->edit($taskModel);
    }

    /**
     * @param int $id
     * @param array $fields
     * @return TaskModel
     */
    public function getById(int $id, array $fields = [])
    {
        return $this->getRepo()->getById($id, $fields);
    }

    /**
     * @return ITaskRepository
     */
    public function getRepo(): ITaskRepository
    {
        return $this->repo;
    }

    /**
     * @param ITaskRepository $repo
     */
    public function setRepo(ITaskRepository $repo): void
    {
        $this->repo = $repo;
    }

}