<?php

namespace App\Src\services\userServices;

use App\Src\models\userModels\UserModel;
use App\Src\repositories\userRepositories\IUserRepository;
use Illuminate\Support\Collection;

class UserService
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
     * @param $id
     * @param string $fields
     * @return UserModel|\Exception
     */
    public function findById($id, $fields = '*')
    {
        return $this->getRepo()->findById($id, $fields);
    }

    /**
     * @param string $string
     * @return Collection
     */
    public function search(string $string)
    {
        return $this->getRepo()->search($string);
    }

    /**
     * @return IUserRepository
     */
    protected function getRepo(): IUserRepository
    {
        return $this->repo;
    }

    /**
     * @param IUserRepository $repo
     */
    protected function setRepo(IUserRepository $repo): void
    {
        $this->repo = $repo;
    }
}