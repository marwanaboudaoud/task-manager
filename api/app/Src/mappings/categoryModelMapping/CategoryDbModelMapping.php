<?php

namespace App\Src\mappings\categoryModelMapping;

use App\Category;
use App\Src\models\categoryModel\CategoryModel;

class CategoryDbModelMapping
{
    /**
     * @param Category $category
     * @return CategoryModel
     */
    public static function toCategoryModelMapping(Category $category)
    {
        $categoryModel = new CategoryModel();
        $categoryModel->setId($category->id);
        $categoryModel->setName($category->name);
        $categoryModel->setSlug($category->slug);
//        $categoryModel->setTasks();
        return $categoryModel;
    }
}