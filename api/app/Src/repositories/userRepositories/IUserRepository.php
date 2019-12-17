<?php

namespace App\Src\repositories\userRepositories;

use App\Src\models\authModel\AuthModel;
use App\Src\models\authModel\AuthResetModel;
use App\Src\models\userModels\UserModel;
use Illuminate\Support\Collection;

interface IUserRepository
{
    /**
     * @param $id
     * @param $fields
     * @return UserModel
     */
    public function findById($id, $fields);

    /**
     * @param string $string
     * @return Collection
     */
    public function search(string $string);

    /**
     * @param AuthModel $authModel
     * @return mixed
     */
    public function create(AuthModel $authModel);

    /**
     * @param UserModel $userModel
     * @return UserModel|\Exception
     */
    public function edit(UserModel $userModel);

    /**
     * @param AuthModel $authModel
     * @return mixed
     */
    public function login(AuthModel $authModel);

    /**
     * @param AuthResetModel $authResetModel
     * @return UserModel|\Exception
     */
    public function reset(AuthResetModel $authResetModel);
}