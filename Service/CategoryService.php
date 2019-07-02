<?php
namespace Service;

use Model\Category;
use Repository\CategoryRepository;
use Support\Manager\CustomerManager;

class CategoryService extends AbstractService
{
    public function registerCategory(array $categoryData)
    {
        $categoryRepository = new CategoryRepository();
        $userId = CustomerManager::getUserId();
        $category = new Category(
            $categoryData['cat_name'],
            $categoryData['cat_type'],
            $userId);
       $response = $categoryRepository->addCategory($category);

       return $response;
    }

    public function getAllCategories()
    {
        $categoryRepository = new CategoryRepository();
        $userId = CustomerManager::getUserId();
        $response = $categoryRepository->getAllCategoriesByUser($userId);

        return $response;
    }
}
