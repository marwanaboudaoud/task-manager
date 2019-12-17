<?php

namespace App\Src\services\authService;

use App\Src\models\authModel\AuthModel;
use App\Src\models\authModel\AuthResetModel;
use App\Src\models\userModels\UserModel;
use App\Src\repositories\userRepositories\IUserRepository;
use Exception;

class AuthService
{
    /**
     * @var IUserRepository
     */
    private $repo;

    public function __construct(IUserRepository $repository)
    {
        $this->setRepo($repository);
    }

    /**
     * @return IUserRepository
     */
    public function getRepo(): IUserRepository
    {
        return $this->repo;
    }

    /**
     * @param IUserRepository $repo
     */
    public function setRepo(IUserRepository $repo): void
    {
        $this->repo = $repo;
    }

    /**
     * @param AuthModel $authModel
     * @return Exception|mixed
     */
    public function login(AuthModel $authModel)
    {
        return $this->getRepo()->login($authModel);
    }

    /**
     * @param AuthModel $model
     * @return Exception|mixed
     */
    public function register(AuthModel $model)
    {
        $check = $this->passwordCheck($model);

        if ($check instanceof \Throwable) {
            return $check;
        }

        return $this->getRepo()->create($model);
    }

    /**
     * @param AuthModel $model
     * @return UserModel|Exception|null
     */
    public function edit(AuthModel $model)
    {
        $check = $this->passwordCheck($model);

        if ($check instanceof \Throwable) {
            return $check;
        }

        return $this->getRepo()->edit($model);
    }

    /**
     * @param AuthResetModel $model
     * @return UserModel|Exception|null
     */
    public function reset(AuthResetModel $model)
    {
        $check = $this->passwordCheck($model);

        if ($check instanceof \Throwable) {
            return $check;
        }

        return $this->getRepo()->reset($model);
    }

    /**
     * @param AuthModel $model
     * @return Exception|null
     */
    public function passwordCheck(AuthModel $model)
    {
        try{
            if ($model->getPassword() !== $model->getPasswordRepeat()){
                throw new \Exception('Password is not the same');
            }
        }
        catch(\Exception $e){
            return $e;
        }
        return null;
    }
}
