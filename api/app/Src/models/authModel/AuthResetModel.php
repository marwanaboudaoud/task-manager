<?php

namespace App\Src\models\authModel;


class AuthResetModel extends AuthModel
{
    /**
     * @var string
     */
    private $resetToken;

    /**
     * @return string
     */
    public function getResetToken(): string
    {
        return $this->resetToken;
    }

    /**
     * @param string $resetToken
     */
    public function setResetToken(string $resetToken): void
    {
        $this->resetToken = $resetToken;
    }
}