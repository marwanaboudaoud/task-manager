<?php

namespace Tests\Unit;

use App\Src\mappings\userDbModelMappings\UserDbModelMapping;
use App\Src\models\authModel\AuthModel;
use App\Src\repositories\userRepositories\UserDbRepository;
use App\Src\services\authService\AuthService;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AutoCompleteUserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAutoCompleteUser()
    {
        $AuthService = new AuthService(
            new UserDbRepository()
        );

        $names = [
            [
                'first' => 'Alex',
                'last' => 'Kuo',
            ],
            [
                'first' => 'Bas',
                'last' => 'Pouleijn',
            ],
            [
                'first' => 'Ricky',
                'last' => 'van Waas',
            ],
            [
                'first' => 'Dimitri',
                'last' => 'van der Vliet',
            ],
            [
                'first' => 'Erwin',
                'last' => 'van der Kleyn',
            ],
        ];

        $users = collect();

        foreach($names as $name){
            $authModel = new AuthModel();
            $authModel->setFirstName($name['first']);
            $authModel->setLastName($name['last']);
            $authModel->setEmail($this->faker->unique()->safeEmail);
            $authModel->setPassword('unitTest@');
            $authModel->setPasswordRepeat('unitTest@');

            $users->push($AuthService->register($authModel));
        }

        $q = 'van';

        $filtered = $users->filter(function($user) use ($q){
            return strpos($user->getEmail(), $q) || strpos($user->getFullName(), $q);

        });

        $result = User::where('email', 'LIKE', '%' . $q . '%')
            ->orWhere('name', 'LIKE', '%' . $q . '%')
            ->get();

        $mapped = $result->map(function ($user){
            return UserDbModelMapping::toUserModelMapping($user);
        });

        $this->assertEquals($mapped->toArray(), array_values($filtered->toArray()));
    }
}
