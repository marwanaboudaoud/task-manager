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

class CreateUserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $authService = new AuthService(
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
        $user = $authService->register($authModel);

        $result = $userService->findById($user->getId());

        $this->assertEquals($result, $user);

        $user = User::find($user->getId());
        $user->delete();
    }
}
