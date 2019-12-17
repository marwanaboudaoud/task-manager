<?php

namespace App\Src\mappings\userDbModelMappings;

use App\Src\models\userModels\UserModel;
use App\User;

class UserDbModelMapping
{
    /**
     * @param User $user
     * @return UserModel
     */
    public static function toUserModelMapping(User $user)
    {
        $userModel = new UserModel();
        $userModel->setId($user->id);
        $userModel->setFirstName($user->first_name);
        $userModel->setLastName($user->last_name);
        $userModel->setEmail($user->email);
        $userModel->setPassword($user->password);

        return $userModel;
    }
}