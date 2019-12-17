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

class GetAllAttendeesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAllAttendees()
    {
        $AuthService = new AuthService(
            new UserDbRepository()
        );

        $meetingListService = new MeetingListService(
            new MeetingListDbRepository()
        );

        // Create 5 users
        $users = collect();
        for ($i = 1; $i < 5 ; $i++){
            $authModel = new AuthModel();
            $authModel->setFirstName('Unit');
            $authModel->setLastName('Test');
            $authModel->setEmail($this->faker->unique()->safeEmail);
            $authModel->setPassword('unitTest@');
            $authModel->setPasswordRepeat('unitTest@');

            $users->push($AuthService->register($authModel));
        }

        $meetingListModel = new MeetingListModel();
        $meetingListModel->setName($this->faker->name);
        $meetingListModel->setCreator($users[0]);
        $meetingListModel->setIsArchived(true);

        $meetingList = $meetingListService->create($meetingListModel);

        foreach($users as $user){
            $meetingListService->addAttendee($meetingList, $user);
        }

        $result = $meetingListService->getAllAttendees($meetingList);

        $this->assertEquals($result, $users);

        $meetingList = MeetingList::find($meetingList->getId());
        $meetingList->attendees()->detach();
        $meetingList->categories()->delete();
        $meetingList->delete();

        foreach ($users as $user){
            $user = User::where('email', $user->getEmail())->first();
            $user->delete();
        }
    }
}
