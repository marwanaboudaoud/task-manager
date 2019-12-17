<?php

namespace App\Src\repositories\categoryRepository;

use App\Src\models\categoryModel\CategoryModel;
use App\Src\models\meetingListModel\MeetingListModel;
use Exception;

interface ICategoryRepository
{
    /**
     * @param CategoryModel $categoryModel
     * @return mixed
     */
    public function checkSlug(CategoryModel $categoryModel);

    /**
     * @param $id

     * @return CategoryModel
     */
    public function findById($id);

    /**
     * @param CategoryModel $categoryModel
     * @return CategoryModel|Exception
     */
    public function create(CategoryModel $categoryModel);

    /**
     * @param CategoryModel $categoryModel
     * @return CategoryModel|Exception
     */
    public function edit(CategoryModel $categoryModel);

    /**
     * @param CategoryModel $categoryModel
     * @return mixed
     */
    public function delete(CategoryModel $categoryModel);

    /**
     * @param MeetingListModel $meetingListModel
     * @return CategoryModel
     */
    public function getOtherCategory(MeetingListModel $meetingListModel);
}