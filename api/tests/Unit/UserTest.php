<?php

namespace Tests\Unit;

use App\Src\models\authModel\AuthModel;
use App\Src\repositories\userRepositories\UserDbRepository;
use App\Src\services\authService\AuthService;
use App\Src\services\userServices\UserService;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateUser()
    {
        $AuthService = new AuthService(
            new UserDbRepository()
        );

        $userService = new UserService(
            new UserDbRepository()
        );

        $authModel = new AuthModel();
        $authModel->setFirstName('Unit');
        $authModel->setLastName('Test');
        $authModel->setEmail($this->faker->unique()->safeEmail);
        $authModel->setPassword('unitTest@');
        $authModel->setPasswordRepeat('unitTest@');

        $createUser = $AuthService->register($authModel);

        $result = $userService->findById($createUser->getId());

        $this->assertEquals($result, $createUser);

        $user = User::find($result->getId());
        $user->delete();
    }
}
