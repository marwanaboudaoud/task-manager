<?php

namespace Tests\Unit;

use App\MeetingList;
use App\Src\mappings\userDbModelMappings\UserDbModelMapping;
use App\Src\models\meetingListModel\MeetingListModel;
use App\Src\repositories\meetingListRepositories\MeetingListDbRepository;
use App\Src\services\meetingListService\MeetingListService;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetMeetingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetMeeting()
    {
        $meetingService = new MeetingListService(
            new MeetingListDbRepository()
        );

        $meetingModel = new MeetingListModel();
        $meetingModel->setName('Meeting');
        $meetingModel->setCreator(UserDbModelMapping::toUserModelMapping(User::all()->random()));
        $meetingModel->setIsArchived(false);

        $meetingCreate = $meetingService->create($meetingModel);
        $result = $meetingService->getById($meetingCreate->getId());

        $this->assertEquals($result, $meetingCreate);

        $meeting = MeetingList::find($meetingCreate->getId());
        $meeting->attendees()->detach();
        $meeting->categories()->delete();
        $meeting->delete();
    }
}
