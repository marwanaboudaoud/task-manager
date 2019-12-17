<?php

namespace App\Src\services\categoryService;

use App\Src\models\categoryModel\CategoryModel;
use App\Src\models\meetingListModel\MeetingListModel;
use App\Src\repositories\categoryRepository\ICategoryRepository;

class CategoryService
{
    /**
     * @var ICategoryRepository
     */
    private $repo;

    public function __construct(ICategoryRepository $repo)
    {
        $this->setRepo($repo);
    }

    /**
     * @param CategoryModel $categoryModel
     * @return mixed
     */
    public function checkSlug(CategoryModel $categoryModel)
    {
        return $this->getRepo()->checkSlug($categoryModel);
    }

    /**
     * @param CategoryModel $categoryModel
     * @return CategoryModel
     */
    public function create(CategoryModel $categoryModel)
    {
        return $this->getRepo()->create($categoryModel);
    }


    /**
     * @param $id
     * @return CategoryModel
     */
    public function findById($id)
    {
        return $this->getRepo()->findById($id);
    }

    /**
     * @param MeetingListModel $meetingListModel
     * @return CategoryModel
     */
    public function getOtherCategory(MeetingListModel $meetingListModel)
    {
        return $this->getRepo()->getOtherCategory($meetingListModel);
    }

    /**
     * @return ICategoryRepository
     */
    public function getRepo(): ICategoryRepository
    {
        return $this->repo;
    }

    /**
     * @param ICategoryRepository $repo
     */
    public function setRepo(ICategoryRepository $repo): void
    {
        $this->repo = $repo;
    }
}