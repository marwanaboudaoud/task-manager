<?php

namespace App\Src\mappings\userModelMapping;

use App\Src\models\userModels\UserModel;
use App\User;

class UserModelMapping
{
    /**
     * @param UserModel $userModel
     * @return User
     */
    public static function toUserDBMapping(UserModel $userModel)
    {
        $user = new User();
        $user->id = $userModel->getId();
        $user->first_name = $userModel->getFirstName();
        $user->last_name = $userModel->getLastName();
        $user->email = $userModel->getEmail();
        $user->password = $userModel->getPassword();

        return $user;
    }
}