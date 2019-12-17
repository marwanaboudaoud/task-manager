<?php

namespace App\Src\mappings\meetingListModelMapping;

use App\MeetingList;
use App\Src\mappings\categoryModelMapping\CategoryDbModelMapping;
use App\Src\models\meetingListModel\MeetingListModel;
use App\Src\models\userModels\UserModel;

class MeetingListDbModelMapping
{
    /**
     * @param MeetingList $meetingList
     * @param UserModel $user
     * @return MeetingListModel
     */
    public static function toMeetingModelListMapping(MeetingList $meetingList, UserModel $user)
    {
        $collection = collect();

        foreach($meetingList->categories()->get() as $category){
            $collection->push(CategoryDbModelMapping::toCategoryModelMapping($category));
        }

        $meetingListModel = new MeetingListModel();
        $meetingListModel->setId($meetingList->id);
        $meetingListModel->setName($meetingList->name);
        $meetingListModel->setCreator($user);
        $meetingListModel->setCategories($collection);
        $meetingListModel->setIsArchived($meetingList->is_archived ?? false);
        $meetingListModel->setCreatedAt($meetingList->created_at);
        $meetingListModel->setUpdatedAt($meetingList->updated_at);

        return $meetingListModel;
    }
}