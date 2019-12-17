<?php

namespace App\Src\mappings\categoryModelMapping;

use App\Category;
use App\Src\models\categoryModel\CategoryModel;

class CategoryModelMapping
{
    /**
     * @param CategoryModel $categoryModel
     * @return Category
     */
    public static function toCategoryDbModelMapping(CategoryModel $categoryModel)
    {
        $category = new Category();
        $category->id = $categoryModel->getId();
        $category->name = $categoryModel->getName();
        $category->slug = $categoryModel->getSlug();
//        $category->tasks = $categoryModel->getTasks();

        return $category;
    }
}