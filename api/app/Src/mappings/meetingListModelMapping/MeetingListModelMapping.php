<?php

namespace App\Src\mappings\meetingListModelMapping;

use App\MeetingList;
use App\Src\mappings\categoryModelMapping\CategoryDbModelMapping;
use App\Src\mappings\categoryModelMapping\CategoryModelMapping;
use App\Src\mappings\userModelMapping\UserModelMapping;
use App\Src\models\meetingListModel\MeetingListModel;
use Rebing\GraphQL\Support\SelectFields;

class MeetingListModelMapping
{
    /**
     * @param MeetingListModel $model
     * @param SelectFields $fields
     * @return MeetingList
     */
    public static function toMeetingListDbModelMapping(MeetingListModel $model, SelectFields $fields = null)
    {
        $meetingList = new MeetingList();
        $prefix = 'meeting_lists';

        if ($fields){
            foreach($fields->getSelect() as $select){
                switch($select){
                    case $prefix . ".id":
                        $meetingList->id = $model->getId();
                        break;
                    case $prefix . ".name":
                        $meetingList->name = $model->getName();
                        break;
                    case $prefix . ".is_archived":
                        $meetingList->is_archived = $model->IsArchived();
                        break;
                    case $prefix . ".created_at":
                        $meetingList->created_at = $model->getCreatedAt();
                        break;
                    case $prefix . ".updated_at":
                        $meetingList->updated_at = $model->getUpdatedAt();
                        break;
                }
            }
        }
        else{
            $meetingList->id = $model->getId();
            $meetingList->name = $model->getName();
            $meetingList->is_archived = $model->IsArchived();
            $meetingList->created_at = $model->getCreatedAt();
            $meetingList->updated_at = $model->getUpdatedAt();
        }

        return $meetingList;
    }
}