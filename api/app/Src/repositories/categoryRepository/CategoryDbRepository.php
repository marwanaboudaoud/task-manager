<?php

namespace App\Src\repositories\categoryRepository;

use App\Category;
use App\Src\mappings\categoryModelMapping\CategoryDbModelMapping;
use App\Src\mappings\meetingListModelMapping\MeetingListModelMapping;
use App\Src\models\categoryModel\CategoryModel;
use App\Src\models\meetingListModel\MeetingListModel;
use Exception;

class CategoryDbRepository implements ICategoryRepository
{
    /**
     * @param CategoryModel $categoryModel
     * @return bool|Exception|mixed
     */
    public function checkSlug(CategoryModel $categoryModel)
    {
        $category = Category::where('slug', $categoryModel->getSlug())->first();

        try{
            if ($category){
                throw new Exception('category name already in use');
            }
        }
        catch(Exception $e){
            return $e;
        }

        return false;
    }

    /**
     * @param CategoryModel $categoryModel
     * @return CategoryModel|Exception
     */
    public function create(CategoryModel $categoryModel)
    {
        $check = $this->checkSlug($categoryModel);

        if ($check instanceof \Throwable) {
            return $check;
        }

        try{
            $category = new Category();
            $category->name = $categoryModel->getName();
            $category->slug = $categoryModel->getSlug();
            $category->meetingList()->associate(MeetingListModelMapping::toMeetingListDbModelMapping($categoryModel->getMeeting()));
            $category->save();
        }
        catch(Exception $e){
            return $e;
        }

        return CategoryDbModelMapping::toCategoryModelMapping($category);
    }

    /**
     * @param CategoryModel $categoryModel
     * @return CategoryModel
     */
    public function edit(CategoryModel $categoryModel)
    {
        // TODO: Implement edit() method.
    }

    /**
     * @param CategoryModel $categoryModel
     * @return mixed
     */
    public function delete(CategoryModel $categoryModel)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param $id
     * @return CategoryModel|\Exception
     */
    public function findById($id)
    {
        $category = Category::find($id);

        try{
            if(!$category){
                throw new Exception('Category not found');
            }
        }
        catch (\Exception $e){
            return $e;
        }

        return CategoryDbModelMapping::toCategoryModelMapping($category);
    }

    /**
     * @param MeetingListModel $meetingListModel
     * @return CategoryModel
     */
    public function getOtherCategory(MeetingListModel $meetingListModel)
    {
        return $meetingListModel->getCategories()->first();
    }
}