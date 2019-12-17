<?php

namespace App\Src\models\TokenModel;


use App\Src\mappings\userDbModelMappings\UserDbModelMapping;
use App\Src\models\userModels\UserModel;
use App\User;
use Illuminate\Support\Facades\Auth;

class TokenModel
{

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $tokenType;

    /**
     * @var string
     */
    private $expiresIn;

    /**
     * @var UserModel
     */
    private $user;

    public function __construct($auth, User $user)
    {
        $this->setExpiresIn($auth->factory()->getTTL() * 60);
        $this->setTokenType('bearer');
        $this->setToken($auth->login($user));
        $this->setUser(UserDbModelMapping::toUserModelMapping($user));
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    /**
     * @param string $tokenType
     */
    public function setTokenType(string $tokenType): void
    {
        $this->tokenType = $tokenType;
    }

    /**
     * @return string
     */
    public function getExpiresIn(): string
    {
        return $this->expiresIn;
    }

    /**
     * @param string $expiresIn
     */
    public function setExpiresIn(string $expiresIn): void
    {
        $this->expiresIn = $expiresIn;
    }

    /**
     * @return UserModel
     */
    public function getUser(): UserModel
    {
        return $this->user;
    }

    /**
     * @param UserModel $user
     */
    public function setUser(UserModel $user): void
    {
        $this->user = $user;
    }
}