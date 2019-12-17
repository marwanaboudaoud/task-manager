<?php

namespace Tests\Unit;

use App\MeetingList;
use App\Src\models\authModel\AuthModel;
use App\Src\models\meetingListModel\MeetingListModel;
use App\Src\repositories\meetingListRepositories\MeetingListDbRepository;
use App\Src\repositories\userRepositories\UserDbRepository;
use App\Src\services\authService\AuthService;
use App\Src\services\meetingListService\MeetingListService;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddAttendeeToMeetingListTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $AuthService = new AuthService(
            new UserDbRepository()
        );

        $meetingListService = new MeetingListService(
            new MeetingListDbRepository()
        );

        $authModel = new AuthModel();
        $authModel->setFirstName('Unit');
        $authModel->setLastName('Test');
        $authModel->setEmail($this->faker->unique()->safeEmail);
        $authModel->setPassword('unitTest@');
        $authModel->setPasswordRepeat('unitTest@');

        $user = $AuthService->register($authModel);

        $meetingListModel = new MeetingListModel();
        $meetingListModel->setName($this->faker->name);
        $meetingListModel->setCreator($user);
        $meetingListModel->setIsArchived(true);

        $meetingList = $meetingListService->create($meetingListModel);

        $meetingListService->addAttendee($meetingList, $user);

        $result = $meetingListService->getById($meetingList->getId());

        $this->assertEquals($result, $meetingList);

        $meetingList = MeetingList::find($meetingList->getId());
        $meetingList->attendees()->detach();
        $meetingList->categories()->delete();
        $meetingList->delete();

        $user = User::find($user->getId());
        $user->delete();
    }
}
