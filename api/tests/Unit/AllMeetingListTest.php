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

class AllMeetingListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAllMeetingListTest()
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

        $meetings = collect();

        for ($i = 0; $i < 5; $i++){
            $meetingListModel = new MeetingListModel();
            $meetingListModel->setName($this->faker->name);
            $meetingListModel->setCreator($user);
            $meetingListModel->setIsArchived(true);
            $meetings->push($meetingListService->create($meetingListModel));
        }

        $result = $meetingListService->getByUserId($user->getId());

        $this->assertEquals($result, $meetings);

        foreach ($meetings as $meeting){
            $meetingList = MeetingList::find($meeting->getId());
            $meetingList->attendees()->detach();
            $meetingList->categories()->delete();
            $meetingList->delete();
        }

            $user = User::where('email', $user->getEmail())->first();
            $user->delete();

    }
}
