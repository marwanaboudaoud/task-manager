<?php

namespace App\Src\repositories\meetingListRepositories;

use App\Category;
use App\MeetingList;
use App\Src\mappings\meetingListModelMapping\MeetingListDbModelMapping;
use App\Src\mappings\userDbModelMappings\UserDbModelMapping;
use App\Src\mappings\userModelMapping\UserModelMapping;
use App\Src\models\meetingListModel\MeetingListModel;
use App\Src\models\userModels\UserModel;
use App\Src\services\mailService\MailService;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class MeetingListDbRepository implements IMeetingListRepository
{
    /**
     * @param int $id
     * @param array $fields
     * @return MeetingListModel|\Exception
     */
    public function getById(int $id, array $fields = [])
    {
        $meetingList = MeetingList::where('id', $id)->first();

        try{
            if (!isset($meetingList)) {
                throw new \Exception('Meeting not found');
            }
        }
        catch(\Exception $e){
            return $e;
        }

        $user = User::find($meetingList->creator_id);

        return MeetingListDbModelMapping::toMeetingModelListMapping($meetingList, UserDbModelMapping::toUserModelMapping($user));
    }

    /**
     * @param int $id
     * @return array|\Exception|Collection
     */
    public function getByUserId(int $id)
    {
        $meetingLists = MeetingList::where('creator_id', $id)->get();

        try{
            if (!isset($meetingLists)) {
                throw new \Exception('No meetings found');
            }
        }
        catch(\Exception $e){
            return $e;
        }

        $user = User::findOrFail($id);
        $meetings = collect();

        foreach($meetingLists as $meetingList){
            $meetings->push(MeetingListDbModelMapping::toMeetingModelListMapping($meetingList, UserDbModelMapping::toUserModelMapping($user)));
        }

        return $meetings;
    }

    /**
     * @param MeetingListModel $meetingListModel
     * @return MeetingListModel|\Exception
     */
    public function create(MeetingListModel $meetingListModel)
    {
        try{
            $meetingList = new MeetingList();
            $meetingList->name = $meetingListModel->getName();
            $meetingList->creator_id = $meetingListModel->getCreator()->getId();
            $meetingList->save();

            $categoryName = 'Overige';

            $category = new Category();
            $category->name = $categoryName;
            $category->slug = $meetingList->id . '-' . strtolower(str_replace(' ', '-', $categoryName));
            $category->meetingList()->associate($meetingList);
            $category->save();
        }
        catch (\Exception $e){
            return $e;
        }

        return MeetingListDbModelMapping::toMeetingModelListMapping($meetingList, $meetingListModel->getCreator());
    }

    /**
     * @param MeetingListModel $meetingListModel
     * @return MeetingListModel|\Throwable
     */
    public function edit(MeetingListModel $meetingListModel)
    {

        $meeting = $this->checkMeeting($meetingListModel);

        if($meeting instanceof \Throwable){
            return $meeting;
        }

        if ($meetingListModel->getName()){
            $meeting->name = $meetingListModel->getName();
        }

        $meeting->save();

        return MeetingListDbModelMapping::toMeetingModelListMapping($meeting, $meetingListModel->getCreator());
    }

    /**
     * @param MeetingListModel $meetingListModel
     * @return \Throwable|MeetingList
     */
    public function checkMeeting(MeetingListModel $meetingListModel)
    {
        try{
            $meeting = MeetingList::findOrFail($meetingListModel->getId());
        }
        catch(ModelNotFoundException $e){
            return $e;
        }

        return $meeting;

    }




    /**
     * @param MeetingListModel $meetingListModel
     * @return MeetingListModel
     */
    public function archive(MeetingListModel $meetingListModel)
    {
        // TODO: Implement archive() method.
    }

    /**
     * @param MeetingListModel $meetingListModel
     * @param UserModel $userModel
     * @return MeetingListModel|\Exception|ModelNotFoundException
     */
    public function addAttendee(MeetingListModel $meetingListModel, UserModel $userModel)
    {
        try{
            $meetingList = MeetingList::findOrFail($meetingListModel->getId());
        }
        catch(ModelNotFoundException $e){
            return $e;
        }

        $user = User::where('email', $userModel->getEmail())->first();

        $creator = User::find($meetingList->creator_id);
        $meetingListModel = MeetingListDbModelMapping::toMeetingModelListMapping($meetingList, UserDbModelMapping::toUserModelMapping($creator));

        if(!$user) {
            $user = new User();
            $user->email = $userModel->getEmail();
            $user->save();

            return $this->addNonExistingAttendee($meetingListModel, $userModel);
        }

        $meetingList->attendees()->syncWithoutDetaching($user);
        $meetingListModel = MeetingListDbModelMapping::toMeetingModelListMapping($meetingList, UserDbModelMapping::toUserModelMapping($creator));

        return $this->addExistingAttendee($meetingListModel, UserDbModelMapping::toUserModelMapping($user));
    }

    public function addExistingAttendee(MeetingListModel $meetingListModel, UserModel $userModel)
    {
        $mailService = new MailService();
        $result = $mailService->sendAddExistingAttendeeMail($meetingListModel, $userModel);

        return $result;
    }

    public function addNonExistingAttendee(MeetingListModel $meetingListModel, UserModel $userModel)
    {
        $mailService = new MailService();
        $result = $mailService->sendAddNonExistingAttendeeMail($meetingListModel, $userModel);

        return $result;
    }

    /**
     * @param MeetingListModel $meetingListModel
     * @return \Exception|ModelNotFoundException|Collection
     */
    public function getAllAttendee(MeetingListModel $meetingListModel)
    {
        try{
            $meetingList = MeetingList::findOrFail($meetingListModel->getId());
        }
        catch (ModelNotFoundException $e){
            return $e;
        }

        $attendees = collect();

        foreach($meetingList->attendees as $attendee){
            $attendees->push(UserDbModelMapping::toUserModelMapping($attendee));
        }

        return $attendees;
    }

    /**
     * @param MeetingListModel $meetingListModel
     * @param UserModel $userModel
     * @return MeetingListModel|\Exception|ModelNotFoundException
     */
    public function removeAttendee(MeetingListModel $meetingListModel, UserModel $userModel)
    {
        try{
            $meetingList = MeetingList::findOrFail($meetingListModel->getId());
        }
        catch(ModelNotFoundException $e){
            return $e;
        }

        $attendees = $meetingList->attendees()->get();

        try{
            $user = User::findOrFail($userModel->getId());
        }
        catch(ModelNotFoundException $e){
            return $e;
        }

        try{
            if (!$attendees->contains($user)) {
                throw new \Exception('User is not in this meeting');
            }
        }
        catch(\Exception $e){
            return $e;
        }

        try{
            if ($attendees->count() < 1) {
                throw new \Exception('Meeting cannot be empty');
            }
        }
        catch(\Exception $e){
            return $e;
        }

        $meetingList->attendees()->detach($user);

        $creator = User::find($meetingList->creator_id);

        return MeetingListDbModelMapping::toMeetingModelListMapping($meetingList, UserDbModelMapping::toUserModelMapping($creator));
    }

}