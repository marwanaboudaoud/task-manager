<?php
namespace App\Src\repositories\meetingListRepositories;

use App\Src\models\meetingListModel\MeetingListModel;
use App\Src\models\userModels\UserModel;
use Illuminate\Support\Collection;

interface IMeetingListRepository
{
    /**
     * @param int $id
     * @param array $fields
     * @return MeetingListModel
     */
    public function getById(int $id, array $fields = []);

    /**
     * @param int $id
     * @return Collection
     */
    public function getByUserId(int $id);

    /**
     * @param MeetingListModel $meetingListModel
     * @return MeetingListModel
     */
    public function create(MeetingListModel $meetingListModel);

    /**
     * @param MeetingListModel $meetingListModel
     * @return MeetingListModel
     */
    public function edit(MeetingListModel $meetingListModel);

    /**
     * @param MeetingListModel $meetingListModel
     * @return MeetingListModel
     */
    public function archive(MeetingListModel $meetingListModel);

    /**
     * @param MeetingListModel $meetingListModel
     * @param UserModel $userModel
     * @return MeetingListModel
     */
    public function addAttendee(MeetingListModel $meetingListModel, UserModel $userModel);

    /**
     * @param MeetingListModel $meetingListModel
     * @return Collection
     */
    public function getAllAttendee(MeetingListModel $meetingListModel);

    /**
     * @param MeetingListModel $meetingListModel
     * @param UserModel $userModel
     * @return MeetingListModel
     */
    public function removeAttendee(MeetingListModel $meetingListModel, UserModel $userModel);
}