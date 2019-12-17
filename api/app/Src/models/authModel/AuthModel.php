<?php

namespace App\Src\models\authModel;

use App\Src\models\userModels\UserModel;

class AuthModel extends UserModel
{
    /**
     * @var string
     */
    private $password_repeat;

    /**
     * @return string
     */
    public function getPasswordRepeat(): string
    {
        return $this->password_repeat;
    }

    /**
     * @param string $password_repeat
     */
    public function setPasswordRepeat(string $password_repeat): void
    {
        $this->password_repeat = $password_repeat;
    }
}
