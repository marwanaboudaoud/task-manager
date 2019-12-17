<?php

namespace App\Src\services\meetingListService;

use App\Src\models\meetingListModel\MeetingListModel;
use App\Src\models\userModels\UserModel;
use App\Src\repositories\meetingListRepositories\IMeetingListRepository;
use Illuminate\Support\Collection;

class MeetingListService
{
    /**
     * @var IMeetingListRepository
     */
    private $repo;

    public function __construct(IMeetingListRepository $repository)
    {
        $this->setRepo($repository);
    }

    /**
     * @param MeetingListModel $meetingListModel
     * @return MeetingListModel
     */
    public function create(MeetingListModel $meetingListModel)
    {
        return $this->getRepo()->create($meetingListModel);
    }

    public function edit(MeetingListModel $meetingListModel)
    {
        return $this->getRepo()->edit($meetingListModel);
    }

    /**
     * @return IMeetingListRepository
     */
    public function getRepo(): IMeetingListRepository
    {
        return $this->repo;
    }

    /**
     * @param IMeetingListRepository $repo
     */
    public function setRepo(IMeetingListRepository $repo): void
    {
        $this->repo = $repo;
    }

    /**
     * @param int $id
     * @param array $fields
     * @return MeetingListModel
     */
    public function getById(int $id, array $fields = [])
    {
        return $this->getRepo()->getById($id, $fields);
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getByUserId(int $id)
    {
        return $this->getRepo()->getByUserId($id);
    }

    /**
     * @param MeetingListModel $meetingListModel
     * @param UserModel $userModel
     * @return MeetingListModel
     */
    public function addAttendee(MeetingListModel $meetingListModel, UserModel $userModel)
    {
        return $this->getRepo()->addAttendee($meetingListModel, $userModel);
    }

    /**
     * @param MeetingListModel $meetingListModel
     * @return Collection
     */
    public function getAllAttendees(MeetingListModel $meetingListModel)
    {
        return $this->getRepo()->getAllAttendee($meetingListModel);
    }

    /**
     * @param MeetingListModel $meetingListModel
     * @param UserModel $userModel
     * @return MeetingListModel
     */
    public function removeAttendee(MeetingListModel $meetingListModel, UserModel $userModel)
    {
        return $this->getRepo()->removeAttendee($meetingListModel, $userModel);
    }
}